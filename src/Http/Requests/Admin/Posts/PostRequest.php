<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Posts;

use Arcanesoft\Blog\Bases\FormRequest;
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
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'        => 'required|max:255',
            'excerpt'      => 'required|max:200',
            'content'      => 'required',
            'category'     => static::getCategoryRule(),
            'tags'         => static::getTagsRule(),
            'published_at' => 'required|date_format:Y-m-d',
            'status'       => static::getPostStatusRule(),
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the slug rule.
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
     * @return string
     */
    protected static function getCategoryRule()
    {
        return 'required|min:1|in:'.Category::getSelectOptions(false)->keys()->implode(',');
    }

    /**
     * Get the tags rule.
     *
     * @return string
     */
    protected static function getTagsRule()
    {
        return 'required|array|min:1|in:'.Tag::getSelectOptions()->keys()->implode(',');
    }

    /**
     * Get the post status rule.
     *
     * @return string
     */
    protected static function getPostStatusRule()
    {
        return 'required|in:'.Post::getStatuses()->keys()->implode(',');
    }
}
