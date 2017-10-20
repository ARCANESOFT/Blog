<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Posts;

use Illuminate\Support\Str;

/**
 * Class     CreatePostRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Admin\Posts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreatePostRequest extends PostRequest
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
        return array_merge(parent::rules(), [
            'slug' => ['required', 'string', $this->getSlugRule()],
        ]);
    }

    /**
     * Sanitize the inputs.
     *
     * @return array
     */
    protected function sanitize()
    {
        return [
            'slug'      => Str::slug($this->get($this->has('slug') ? 'slug' : 'title', '')),
            'seo_title' => $this->get(empty($this->get('seo_title')) ? 'title' : 'seo_title'),
        ];
    }
}
