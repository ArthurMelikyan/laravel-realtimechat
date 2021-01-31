<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
        return [
            'message'=>'string:max1000|nullable',
            // ! list of file extensions to prevent security issues
            'file'=>'nullable|mimes:jpg,mp4,bmp,png,pdf,doc,docx,mp3,csv,css,html,epub,gif,js,json,rar,zip,svg,txt', //! etc.....
        ];
    }
}
