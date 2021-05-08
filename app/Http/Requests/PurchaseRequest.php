<?php
/**
 * This file implements Purchase Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  PurchaseRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a purchase request.
 *
 * @category Class
 * @package  PurchaseRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class PurchaseRequest extends FormRequest
{
    private $_refRules = 'required';

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
            $this->_refRules = 'unique:purchases,reference,' . $this->purchase->id;
        }

        if ($this->method() == 'POST') {
            $this->_refRules = 'unique:purchases,reference';
        }


        return [
        'date'           => 'required',
        'reference'      => 'required|alpha_num|' . $this->_refRules,
        'staff_note'     => 'required',
        'shipping'       => 'required',
        'discount_rate'  => 'required',
        'supplier'       => 'required',
        'tax'            => 'required',
        ];
    }
}
