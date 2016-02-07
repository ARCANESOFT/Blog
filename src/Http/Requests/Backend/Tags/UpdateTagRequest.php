<?php namespace Arcanesoft\Blog\Http\Requests\Backend\Tags;

use Arcanesoft\Blog\Bases\FormRequest;

/**
 * Class     UpdateTagRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Backend\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateTagRequest extends FormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
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
        return [
            'name' => 'required|min:3',
        ];
    }
}
