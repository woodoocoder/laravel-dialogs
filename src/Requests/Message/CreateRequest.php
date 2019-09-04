<?php

namespace Woodoocoder\LaravelDialogs\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $tablePrefix = config('woodoocoder.dialogs.table_prefix');
        
        return [
            'dialog_id' => 'numeric|exists:'.$tablePrefix.'dialogs,id',
            'message' => 'required|string',
        ];
    }
}
