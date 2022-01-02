<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearnListRequest extends FormRequest
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
        ];
    }

     //エラーメッセージの日本語化
     public function attributes()
     {
         return [
             'name' => 'リスト名',
         ];
     }
}
