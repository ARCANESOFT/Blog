<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Categories;

/**
 * Class     CreateCategoryRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Admin\Categories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateCategoryRequest extends CategoryFormRequest
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
            'name' => ['required', 'min:3'],
        ];
    }
}
