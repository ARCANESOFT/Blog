<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Posts;

use Arcanesoft\Blog\Http\Requests\Admin\FormRequest;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Models\Tag;
use Illuminate\Validation\Rule;

/**
 * Class     PostRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Admin\Posts
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class PostRequest extends FormRequest
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // TODO: Adding seo rules
        return [
            'title'        => ['required', 'string', 'max:255'],
            'excerpt'      => ['required', 'string', 'max:200'],
            'content'      => ['required', 'string'],
            'category'     => static::getCategoryRule(),
            'tags'         => static::getTagsRule(),
            'published_at' => ['required', 'date_format:Y-m-d'],
            'status'       => static::getPostStatusRule(),
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validated inputs.
     *
     * @return array
     */
    public function getValidatedInputs()
    {
        return array_merge([
            'author_id'   => $this->user()->getAuthIdentifier(),
            'category_id' => $this->get('category')
        ], $this->only([
            // POST inputs
            'title', 'excerpt', 'content', 'tags', 'published_at', 'status',

            // SEO inputs
            'seo_title', 'seo_description', 'seo_keywords',
        ]));
    }

    /**
     * Get the slug rule.
     *
     * @param  string  $column
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected static function getSlugRule($column = 'slug')
    {
        $prefix = config('arcanesoft.blog.database.prefix', 'blog_');

        return Rule::unique("{$prefix}posts", $column);
    }

    /**
     * Get the category rule.
     *
     * @return array
     */
    protected static function getCategoryRule()
    {
        return ['required', 'integer', 'in:'.Category::getSelectOptions(false)->keys()->implode(',')];
    }

    /**
     * Get the tags rule.
     *
     * @return array
     */
    protected static function getTagsRule()
    {
        return ['required', 'array', 'min:1', 'in:'.Tag::getSelectOptions()->keys()->implode(',')];
    }

    /**
     * Get the post status rule.
     *
     * @return array
     */
    protected static function getPostStatusRule()
    {
        return ['required', 'string', 'in:'.Post::getStatuses()->keys()->implode(',')];
    }
}
