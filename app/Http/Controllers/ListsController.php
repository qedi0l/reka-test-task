<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\UserList;
use Illuminate\Http\RedirectResponse;
use App\Models\Task;

class ListsController extends Controller
{
    function show(Request $request): View
    {

        $userId = $request->user()->id;
        $lists = UserList::query()->select("*")->where("owner",$userId)->get();

        $sharedAcess = [];
        foreach ($lists as $list){
            if ((str_contains($list->hasAccess, $userId))){
                array_push($sharedAcess,[$list->name=>$list]);
            }
        }
        
        return view("profile.userLists", ["lists" => $lists, "sharedAcess"=>$sharedAcess]);
    }

    function create(Request $request): RedirectResponse
    {

        $list = new UserList();
        $list->name = $request->input('name');
        $list->data = $request->input('data');
        $list->owner = $request->user()->id;
        $list->save(); 

        return back()->with('status', 'success');
    }
    
    function showList(Request $request): View
    {
        $userId = $request->user()->id;
        $listID = $request->id;

        $list = UserList::find($listID);

        // Has access
        if (($list->owner == $userId) || (str_contains($list->hasAccess, $userId)))
        {
            // Not empty
            if($tasks = $this->getTasks($listID)) 
                return view("profile.listCard", ["list"=>$list, "tasks"=>$tasks]);
            else 
                return view("profile.listCard", ["list"=>$list])->with("status", "list-emty");
        }
        else
            return redirect()->back();
        
    }

    function share(Request $request): RedirectResponse
    {
        
        $listID = $request->listID;
        $list = UserList::find($listID);
        
        $hasAccess = explode(",",$list->hasAccess);
        $sharedIDs = explode(",",$request->sharedID);
        
        foreach($sharedIDs as $sharedID){
            array_push($hasAccess,$sharedID);
        }
        
        $hasAccess = array_unique($hasAccess);
        
        $list->hasAccess = implode(",",$hasAccess);
        $list->save();


        return back()->with("status","success");
    }
    function removeShared(Request $request): RedirectResponse
    {
        $listID = $request->listID;
        $list = UserList::find($listID);
        
        $hasAccess = explode(",",$list->hasAccess);
        $removeSharedID = $request->removeSharedID;

        unset($hasAccess[array_search($removeSharedID,$hasAccess)]);

        $hasAccess = implode(",",$hasAccess);
        
        $list->hasAccess = $hasAccess;
        $list->save();
        
        return back()->with("status","success");
    }


    function delete(Request $request)
    {
        $listID = $request->input("listID");
        $list = UserList::find($listID);
        $tasks = $this->getTasks($listID);

        foreach($tasks as $task){
            $taskID = $task->id;
            $task = Task::find($taskID);
            $task->delete();
        }

        $list->delete();

        return back()->with("status","success");
    }


    private function getTasks($listID)
    {
        $list  = UserList::find($listID);
        $tasks = $list->tasks;
        return $tasks;

    }
    
}
