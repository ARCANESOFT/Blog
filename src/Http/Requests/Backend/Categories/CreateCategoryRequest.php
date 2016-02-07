<?php namespace Arcanesoft\Blog\Http\Requests\Backend\Categories;

use Arcanesoft\Blog\Bases\FormRequest;

/**
 * Class     CreateCategoryRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Backend\Categories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateCategoryRequest extends FormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Role validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|min:3',
    ];

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
        return $this->rules;
    }
}
