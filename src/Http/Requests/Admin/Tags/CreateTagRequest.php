<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Tags;

/**
 * Class     CreateTagRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Admin\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateTagRequest extends TagFormRequest
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
        $rules = [];

        // TODO: Adding an 'exists' rule to check if the name exists
        if ($this->isTranslatable())
            $rules['name.*'] = ['required', 'string', 'min:3'];
        else
            $rules['name'] = ['required', 'string', 'min:3'];

        return $rules;
    }
}
