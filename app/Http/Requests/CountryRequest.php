<?php
/**
 * This file implements Country Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  CountryRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a category request.
 *
 * @category Class
 * @package  CountryRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class CountryRequest extends FormRequest
{
    private $_nameRules = 'required';
    private $_codeRules = 'numeric';

    /**
     * Authorization
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Request Validation
     *
     * @return array
     */
    public function rules()
    {
        // Check Create or Update
        if ($this->method() == 'PATCH') {
            $this->_nameRules = 'unique:countries,name,' . $this->category->id;
        }

        if ($this->method() == 'POST') {
            $this->_nameRules = 'unique:countries,name';
        }

        return [
        'name' => 'required|regex:/^[A-Za-z0-9 ]+$/|' . $this->_nameRules,
        ];
    }
}
