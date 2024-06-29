<?php

namespace App\Http\Controllers;

use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use App\Models\File;
use App\Models\UserList;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use UploadFile;
    function create(Request $request):RedirectResponse
    {
        
        $task = new Task();
        $task->name = $request->input("name");

        $task->image = "";
        $task->tags = $request->input("tags");
        $task->data = $request->input("data");

        $listID = $request->input("listID");
        $task->user_list_id = $listID;

        $task->save();

        return back()->with('status', 'success');
    }
    function update(Request $request):RedirectResponse
    {
        $taskID = $request->input("taskID");
        $task = Task::find($taskID);

        $task->name = $request->input("newName");
        $task->data = $request->input("newData");
        $task->save();

        return back()->with('status', 'success');

    }

    function delete(Request $request):RedirectResponse
    {
        $taskID = $request->input("taskID");
        $task = Task::find($taskID);
        $task->delete();

        return back()->with('status', 'success');
    }

    function search(Request $request) 
    {
        $listID = $request->listID;
        $list  = UserList::find($listID);

        $search = $request->tagsSearch;
        $search = explode(",",$search);

        $tasks = $list->tasks;
        $found = [];

        foreach($tasks as $task){
            $taskTags = explode(",",$task->tags);
            foreach($search as $item){
                if (in_array($item,$taskTags)){
                    array_push($found,$task);
                }
            }
        }
        $found = collect(array_unique($found));
        
        if (empty($search[0])) return back();
                
        if($found){
            return view('profile.listCard', [
                    "list"=>$list,
                    "id"=>$listID,
                    "tasks"=>$found
                ]);
        }
        else
            return response()->json(["found"=>false],200);
    }
    
    function addImage(Request $request)
    {
        $taskID = $request->taskID;
        $task = Task::find($taskID);


        // validation
        $validator = Validator::make($request->all(),[
            'file' => 'mimes:png,jpg,jpeg'
        ]);

        if ($validator->fails())
        {
            $task->image = "";
            $task->save();

            return back()->with('status', 'not uploaded');
        }

        // upload
        $image = $request->file;

        if (isset($image)){
            $task->image = $this->storeFile($image);
        }

        $task->save();

        return back()->with('status', 'upload failed');

    }

    function setTag(Request $request):RedirectResponse
    {
        $taskID = $request->input('taskID');
        $task = Task::find($taskID);

        $exisitTags = $task->tags;
        $newTags = $request->input('tagsInput');
        $tags = $exisitTags.",".$newTags;
        
        $task->tags = $tags;
        $task->save();

        return back()->with('status', 'success');

    }

    function removeTag(Request $request):RedirectResponse
    {
        $task = Task::find($request->input("taskID"));

        $tagToRemove = $request->tag;
        $tags = explode(",",$task->tags);

        unset($tags[array_search($tagToRemove,$tags)]);

        $task->tags = implode(",",$tags);
        $task->save(); 

        return back()->with('status', 'success');
    }


    private function storeFile($file, $folder = null)
    {

        $path = $this->UploadFile($file, 'Attachments');
        
        File::create([
            'path' => $path
        ]);
        
        return $path;
    }
    
}
