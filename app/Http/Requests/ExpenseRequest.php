<?php
/**
 * This file implements Expense Request.
 *
 * PHP version 7.2
 *
 * @category Class
 * @package  ExpenseRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This class describes a expense request.
 *
 * @category Class
 * @package  ExpenseRequest
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class ExpenseRequest extends FormRequest
{
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
        return [
        'amount'    => 'required|numeric',
        'type'      => 'required|max:50',
        'note'      => 'required|max:255',
        ];
    }
}
