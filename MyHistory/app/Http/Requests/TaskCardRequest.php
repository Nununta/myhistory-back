<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //バリデーション設定
        return [
            'name' => 'required|max:50',
            'content' => 'required|max:300',
            'status' => 'required',
            'limit' => 'required',
            'list_name' => 'required'
            
        ];
    }

    //エラーメッセージの日本語化
    public function attributes()
    {
        return [
            'name' => 'カード名',
            'content' => 'タスク内容',
            'status' => 'ステータス',
            'limit' => 'タスク期限',
            'list_name' => 'リスト名'
        
        ];
    }
}
