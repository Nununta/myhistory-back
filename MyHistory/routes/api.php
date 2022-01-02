<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; //追記

use App\Http\Controllers\TaskListController;
use App\Http\Controllers\TaskCardController;
// use App\Http\Controllers\LearnCardController;
// use App\Http\Controllers\LearnListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');


Route::prefix('auth')->group(function() {
    // ログイン
    Route::post('/login', [LoginController::class, 'login']);
    
    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout']);
});

///追記
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// タスクリスト取得
Route::get('/task-list', [TaskListController::class,'get'])->name('taskList');

// タスクリスト登録
Route::post('/task-list', [TaskListController::class,'create'])->name('taskListCreate');

// タスクリスト削除
Route::delete('/task-list/{taskList}', [TaskListController::class,'delete'])->name('taskListDelete');

// タスクカード(リスト所属)取得
Route::get('/task-card', [TaskCardController::class,'get'])->name('taskCard');

// タスクカード全件取得
Route::get('/task-card/all', [TaskCardController::class,'getAll'])->name('taskCardAll');

// タスクカード登録
Route::post('/task-card', [TaskCardController::class,'create'])->name('taskCardCreate');

// タスクカード詳細取得
Route::get('/task-card/{taskCard}', [TaskCardController::class,'show'])->name('taskCardShow');

// タスクカード削除
Route::delete('/task-card/{taskCard}', [TaskCardController::class,'delete'])->name('taskCardDelete');

// タスクカード更新
Route::patch('/task-card/{taskCard}', [TaskCardController::class,'update'])->name('taskCardUpdate');