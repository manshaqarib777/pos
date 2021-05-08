<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    private $_nameRules = 'required';

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

        // Check Create or Update
        if ($this->method() == 'PATCH') {
            $this->_nameRules  = 'unique:groups,name,' . $this->group->id;
        }

        if ($this->method() == 'POST') {
            $this->_nameRules = 'unique:groups,name';
        }

        return [
        'name' => 'required|regex:/^[A-Za-z0-9 ]+$/|' . $this->_nameRules,
        'details' => 'required|regex:/^[A-Za-z0-9 ]+$/'
        ];
    }
}
