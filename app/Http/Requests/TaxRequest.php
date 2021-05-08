<?php
/**
 * This file implements Tax Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  TaxRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a tax request.
 *
 * @category Class
 * @package  TaxRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class TaxRequest extends FormRequest
{
    private $_nameRules = 'required';
    private $_codeRules = 'required';
    /**
     Determine if the user is authorized to make this request.

     @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     Get the validation rules that apply to the request.

     @return array
     */
    public function rules()
    {
        // Check Create or Update
        if ($this->method() == 'PATCH') {
            $this->_nameRules     = 'unique:taxes,name,' . $this->tax->id;
            $this->_codeRules     = 'unique:taxes,code,' . $this->tax->id;
        }

        if ($this->method() == 'POST') {
            $this->_nameRules     = 'unique:taxes,name';
            $this->_codeRules     = 'unique:taxes,code';
        }

        return [
        'name'          => 'required|string|' . $this->_nameRules,
        'code'          => 'required|' . $this->_codeRules,
        'rate'          => 'required|numeric'
        ];
    }
}
