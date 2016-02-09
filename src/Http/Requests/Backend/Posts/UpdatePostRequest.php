<?php namespace Arcanesoft\Blog\Http\Requests\Backend\Posts;

use Arcanesoft\Blog\Bases\FormRequest;

/**
 * Class     UpdatePostRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Backend\Posts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdatePostRequest extends FormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Category validation rules.
     *
     * @var array
     */
    protected $rules = [
        'title'        => 'required|max:255',
        'excerpt'      => 'required|max:200',
        'content'      => 'required',
        'category'     => 'required|min:1',
        'tags'         => 'required|array|min:1',
        'publish_date' => 'required',
        'status'       => 'required',
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
