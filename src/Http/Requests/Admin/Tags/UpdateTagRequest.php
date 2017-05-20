<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Tags;

/**
 * Class     UpdateTagRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Admin\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateTagRequest extends TagFormRequest
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
        // TODO: Adding an 'exists' rule to check if the name exists
        return [
            'name' => ['required', 'string', 'min:3'],
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validated data.
     *
     * @return array
     */
    public function getValidatedData()
    {
        return $this->only(['name']);
    }
}
