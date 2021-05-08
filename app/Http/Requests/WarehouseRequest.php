<?php
/**
 * This file implements Warehouse Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  WarehouseRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a warehouse request.
 *
 * @category Class
 * @package  WarehouseRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class WarehouseRequest extends FormRequest
{
    private $_nameRules = 'required';
    private $_codeRules = 'required';
    private $_emailRules = 'required';
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
            $this->_nameRules  = 'unique:warehouses,name,' . $this->warehouse->id;
            $this->_codeRules  = 'unique:warehouses,code,' . $this->warehouse->id;
            $this->_emailRules = 'unique:warehouses,email,' . $this->warehouse->id;
        }
        if ($this->method() == 'POST') {
            $this->_nameRules  = 'unique:warehouses,name';
            $this->_codeRules  = 'unique:warehouses,code';
            $this->_emailRules = 'unique:warehouses,email';
        }
        return [
        'name'           => 'required|string|' . $this->_nameRules,
        'code'           => 'sometimes|nullable|size:12|' . $this->_codeRules,
        'email'          => 'required|email|' . $this->_emailRules,
        'phone'          => 'required',
        'address'        => 'required',
        ];
    }
}
