<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCardRequest;
use App\Models\Task\TaskList;
use App\Models\Task\TaskCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TaskCardController extends Controller
{
    public function __construct()
    {
        //このコントローラー内のアクションは全て認証が必要になる
        $this->middleware('auth');
    }

    public function get(Request $request){
        
        $list_id = $request->list_id;
        $sort = $request->sort;
        $order = $request->order;

        $taskCards = TaskCard::where('user_id',Auth::id())->where('list_id',$list_id)->orderBy($sort,$order)->get();

        foreach ($taskCards as $taskCard) {  
                $carbon = new Carbon($taskCard->limit);
                $taskCard->limit = $carbon->format('Y/m/d');    
                $createDate = new Carbon($taskCard->created_at, 'Asia/Tokyo');
                $taskCard->date = $createDate->format('Y/m/d');
        } 

        return response()->json(['taskCards' => $taskCards],201);
    }

    public function getAll(Request $request){
        $taskCards = TaskCard::where('user_id',Auth::id())->get();
        return response()->json(['taskCards' => $taskCards],201);
    }

    public function create(TaskCardRequest $request, TaskCard $taskCard)
    {
        $user_id = $request->user()->id;
        $status = $request->status;
        switch ($status){
            case '未着手':
                $status = 0;
                break;
            case '対応中':
                $status = 1;
                break;
            case '保留':
                $status = 2;
                break;
            default:
                $status = 3;
        }

        $list_name = $request->list_name;
        $list = TaskList::where('name',$list_name)->first();
        $list_id = $list->id;
        
        $taskCard->fill([
            'user_id' => $user_id,
            'list_id' => $list_id,
            'name' => $request->name,
            'content' => $request->content,
            'status' => $status,
            'limit' => $request->limit,
        ]);

        $taskCard->save();
        return response()->json(['taskCard' => $taskCard],201);
    }

    public function show(TaskCard $taskCard)
    {   
        $carbon = new Carbon($taskCard->limit);
        $date = $carbon->format('Y/m/d');
        
        $taskListsName=TaskList::get(['name']);
        $cardListName = $taskCard->list->name;
        
        return response()->json(['taskCard' => $taskCard,'date' => $date,'taskListsName' => $taskListsName,'cardListName' => $cardListName],200);
    }

    public function delete(TaskCard $taskCard)
    {         
        $taskCard->delete();
        return response()->json(['message' => '削除が完了しました'],201);
    }

    public function update(TaskCardRequest $request,TaskCard $taskCard)
    {         
        $status = $request->status;
        switch ($status){
            case '未着手':
                $status = 0;
                break;
            case '対応中':
                $status = 1;
                break;
            case '保留':
                $status = 2;
                break;
            default:
                $status = 3;
        }
        
        $list_name = $request->list_name;
        $list = TaskList::where('name',$list_name)->first();
        $list_id = $list->id;

        $taskCard->update([
            'name' => $request->name,
            'list_id' => $list_id,
            'content' => $request->content,
            'status' => $status,
            'limit' => $request->limit,
        ]);
        return response()->json(['taskCard' => $taskCard],201);
    }
}
