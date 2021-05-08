<?php
/**
 * This file implements Subcategory Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  SubcategoryRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a subcategory request.
 *
 * @category Class
 * @package  SubcategoryRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class SubcategoryRequest extends FormRequest
{
    private $_nameRule = 'required';
    private $_codeRule = 'numeric';

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
            $this->_nameRule = 'unique:subcategories,name,' . $this->subcategory->id;
            $this->_codeRule = 'sometimes|nullable|unique:subcategories,code,' . $this->subcategory->id;
        }
        if ($this->method() == 'POST') {
            $this->_nameRule = 'unique:subcategories,name';
            $this->_codeRule = 'sometimes|nullable|unique:subcategories,code';
        }
        return [
        'category'   => 'required',
        'name'       => 'required|max:25|min:5|string|' . $this->_nameRule,
        'code'       => 'regex:/^[0-9]+$/|size:12|' . $this->_codeRule,
        'detail'     => 'required'
        ];
    }
}
