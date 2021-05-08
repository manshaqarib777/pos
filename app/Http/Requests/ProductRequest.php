<?php
/**
 * This file implements Product Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  ProductRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a product request.
 *
 * @category Class
 * @package  ProductRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class ProductRequest extends FormRequest
{
    private $_nameRules = 'required';
    private $_codeRules = 'numeric';
    private $_symbologyRules = 'sometimes';
    private $_alertQuantityRules = 'sometimes';
    private $_statusRules = 'sometimes';
    private $_discounableRules = 'sometimes';
    private $_taxRules = 'sometimes';

    /**
     * Determine if the user is authorized to make this request
     *
     * @return boolean
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
            $this->_nameRules = 'unique:products,name,' . $this->product->id;
            $this->_codeRules = 'sometimes|nullable|unique:products,code,' . $this->product->id;
            $this->_symbologyRules = 'required';
            $this->_alertQuantityRules = 'required';
            $this->_statusRules = 'required';
            $this->_statusRules = 'required';
            $this->__taxRules =  'required';
        }

        if ($this->method() == 'POST') {
            $this->_nameRules = 'unique:products,name';
            $this->_codeRules = 'sometimes|nullable|unique:products,code';
        }


        return [
        'name'        =>  'required|max:30|min:5|' . $this->_nameRules,
        'code'        =>  'regex:/^[0-9]+$/|size:12|' . $this->_codeRules,
        'type'              => 'required',
        'barcode_symbology' => $this->_symbologyRules,
        'alert_quantity'    => $this->_alertQuantityRules,
        'cost'              => 'required',
        'price'             => 'required',
        'tax'               => $this->_taxRules,
        'unit'              => 'required',
        'product_details'   => 'required',
        'warehouse'         => 'required',
        'category'          => 'required',
        'supplier'          => 'required',
        'status'            => $this->_statusRules,
        'discountable'      => $this->_discounableRules,
        ];
    }
}
