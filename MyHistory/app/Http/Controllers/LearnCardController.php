<?php

namespace App\Http\Controllers;

use App\Http\Requests\LearnCardRequest;
use App\Models\Learn\LearnCard;
use App\Models\Learn\LearnList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LearnCardController extends Controller
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

        $learnCards = LearnCard::where('user_id',Auth::id())->where('list_id',$list_id)->orderBy($sort,$order)->get();
    
        foreach ($learnCards as $learnCard) {  
                $carbon = new Carbon($learnCard->limit);
                $learnCard->limit = $carbon->format('Y/m/d');    
                $createDate = new Carbon($learnCard->created_at, 'Asia/Tokyo');
                $learnCard->date = $createDate->format('Y/m/d');
        } 

        return response()->json(['learnCards' => $learnCards],201);
    }

    public function getAll(Request $request){
        $learnCards = LearnCard::where('user_id',Auth::id())->get();
        return response()->json(['learnCards' => $learnCards],201);
    }
    
    public function create(LearnCardRequest $request, LearnCard $learnCard)
    {
        $user_id = $request->user()->id;
        $status = $request->status;
        switch ($status){
            case '未着手':
                $status = 0;
                break;
            case '学習中':
                $status = 1;
                break;
            case '保留':
                $status = 2;
                break;
            default:
                $status = 3;
        }

        $list_name = $request->list_name;
        $list = LearnList::where('name',$list_name)->first();
        $list_id = $list->id;
        
        $learnCard->fill([
            'user_id' => $user_id,
            'list_id' => $list_id,
            'name' => $request->name,
            'content' => $request->content,
            'status' => $status,
        ]);

        $learnCard->save();
        return response()->json(['learnCard' => $learnCard],201);
    }

    public function show(LearnCard $learnCard)
    {    
        $learnListsName=LearnList::get(['name']);
        $cardListName = $learnCard->list->name;

        return response()->json(['learnCard' => $learnCard,'learnListsName' => $learnListsName,'cardListName' => $cardListName],200);
    }

    public function delete(LearnCard $learnCard)
    {         
        $learnCard->delete();
        return response()->json(['message' => '削除が完了しました'],201);
    }

    public function update(LearnCardRequest $request,LearnCard $learnCard)
    {         
        $status = $request->status;
        switch ($status){
            case '未着手':
                $status = 0;
                break;
            case '学習中':
                $status = 1;
                break;
            case '保留':
                $status = 2;
                break;
            default:
                $status = 3;
        }

        $list_name = $request->list_name;
        $list = LearnList::where('name',$list_name)->first();
        $list_id = $list->id;
        

        $learnCard->update([
            'name' => $request->name,
            'list_id' => $list_id,
            'content' => $request->content,
            'status' => $status,
        ]);
        return response()->json(['learnCard' => $learnCard],201);
    }
}
