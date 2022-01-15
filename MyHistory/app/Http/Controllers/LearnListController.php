<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LearnListRequest;
use App\Models\Learn\LearnList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LearnListController extends Controller
{
    public function __construct()
    {
        //このコントローラー内のアクションは全て認証が必要になる
        $this->middleware('auth');
    }

    public function get()
    {
        //認証ユーザの値のみ取得
        $learnLists = LearnList::where('user_id',Auth::id())->orderBy('created_at','desc')->get();  
        return response()->json(['learnList' => $learnLists],201);
    }

    public function create(LearnListRequest $request, LearnList $learnList)
    {
        $learnList->fill($request->all());
        $learnList->user_id = $request->user()->id;
        $learnList->save();

        return response()->json(['taskList' => $learnList],201);
    }

    public function delete(LearnList $learnList)
    {        
        $learnList->cards()->each(function ($cards) {
            $cards->delete();
        });
        
        $learnList->delete();
        return response()->json(['message' => '削除が完了しました'],201);
    }
}
