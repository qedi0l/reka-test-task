<?php

namespace App\Http\Controllers;

use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use App\Models\File;
use Illuminate\Support\Str;
use App\Models\UserList;
use Intervention\Image\Facades\Image;

class TaskController extends Controller
{
    use UploadFile;
    function create(Request $request):RedirectResponse{
        $task = new Task();
        $task->name = $request->input("name");
        $file = $request->file('img');
        //$task->image = $this->storeFile($file);
        $task->image = "";
        $task->tags = $request->input("tags");
        $task->data = $request->input("data");

        $listID = $request->input("listID");
        $task->user_list_id = $listID;

        $task->save();

        return redirect()->route('list.show',['id' => $listID]);
    }
    function update(Request $request):RedirectResponse{
        $taskID = $request->input("taskID");
        $task = Task::find($taskID);
        $listID = $task->user_list_id;

        $task->name = $request->input("newName");
        $task->data = $request->input("newData");
        $task->save();

        return redirect()->route('list.show',['id' => $listID]);

    }

    function delete(Request $request):RedirectResponse{
        $taskID = $request->input("taskID");
        $task = Task::find($taskID);
        $task->delete();

        $listID = $request->input("listID");
        return redirect()->route('list.show',['id' => $listID]);
    }

    function search(Request $request) {
        $listID = $request->input("listID");
        $list  = UserList::find($listID);

        $search = $request->input("tagsSearch");
        $search = explode(",",$search);

        $tasks = $list->tasks;
        $found = [];//array_unique
        
        //dd($search);

        foreach($search as $item){
            for($i=0;$i<count($tasks);$i++){
                $task = $tasks[$i];
                $taskTags = explode(",",$task->tags);
                if (array_search($item,$taskTags)){
                    array_push($found,$task);
                }
            }
        }
        $found = collect(array_unique($found));

        
        if (empty($search[0]))
            return view("profile.listCard", ["list"=>$list,"id"=>$listID, "tasks"=>$list->tasks]);
        elseif(!empty($found)) 
            return view("profile.listCard", ["list"=>$list,"id"=>$listID, "tasks"=>$found]);
        else
            return response()->json(["found"=>false],200);
    }
    
    function addImage(Request $request):RedirectResponse{
        $taskID = $request->taskID;
        $task = Task::find($taskID);
        $listID = $task->user_list_id;

        $image = $request->file('file');
        if (isset($image)){
            $task->image = $this->storeFile($image);
        }
        else $task->image = "";

        $task->save();

        return redirect()->route('list.show',['id' => $listID]);
    }

    function setTag(Request $request):RedirectResponse{
        $taskID = $request->input('taskID');
        $task = Task::find($taskID);
        $listID = $task->user_list_id;

        $exisitTags = $task->tags;
        $newTags = $request->input('tagsInput');
        $tags = $exisitTags.",".$newTags;
        
        $task->tags = $tags;
        $task->save();

        return redirect()->route('list.show',['id' => $listID]);

    }


    function removeTag(Request $request):RedirectResponse{
        $task = Task::find($request->input("taskID"));
        $listID = $task->user_list_id;

        $tagToRemove = $request->tag;
        $tags = explode(",",$task->tags);
        unset($tags[array_search($tagToRemove,$tags)]);
        $task->tags = implode(",",$tags);
        $task->save(); 

        return redirect()->route('list.show',['id' => $listID]);
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
