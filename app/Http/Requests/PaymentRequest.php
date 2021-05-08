<?php
/**
 * This file implements Tax Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  PaymentRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a payement gateway request.
 *
 * @category Class
 * @package  PaymentRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class PaymentRequest extends FormRequest
{
    private $_titleRules = 'required';
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
            $this->_titleRules     = 'unique:payments,title,' . $this->payment->id;
            $this->_codeRules     = 'unique:payments,code,' . $this->payment->id;
        }

        if ($this->method() == 'POST') {
            $this->_titleRules     = 'unique:payments,title';
            $this->_codeRules     = 'unique:payments,code';
        }

        return [
        'title'   => 'required|string|' . $this->_titleRules,
        'code'    => 'required|' . $this->_codeRules,
        'state'   => 'required|numeric',
        'detail'  => 'required'
        ];
    }
}
