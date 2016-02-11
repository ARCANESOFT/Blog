<?php namespace Arcanesoft\Blog\Http\Requests\Backend\Posts;

use Arcanesoft\Blog\Bases\FormRequest;
use Arcanesoft\Blog\Entities\PostStatus;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Tag;

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
        'publish_date' => 'required|date|date_format:Y-m-d',
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
        return $this->updateRules($this->rules);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Update request rules.
     *
     * @param  array  $rules
     *
     * @return array
     */
    private function updateRules(array $rules)
    {
        $rules['category'] .= '|in:' . implode(',', array_keys(Category::getSelectOptions(false)));
        $rules['tags']     .= '|in:' . implode(',', array_keys(Tag::getSelectOptions()));
        $rules['status']   .= '|in:' . implode(',', PostStatus::keys());

        return $rules;
    }
}
