<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Posts;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Http\Routes\PostsRoutes;
use Arcanesoft\Blog\Models\Post;
use Illuminate\Validation\Rules\{Exists, Unique};

/**
 * Class     UpdatePostRequest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdatePostRequest extends FormRequest
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title'   => [
                'required',
                'string',
                'max:255',
            ],
            'slug'    => [
                'required',
                'string',
                (new Unique(Blog::table('posts'), 'slug'))->ignore($this->getCurrentPost()),
            ],
            'excerpt' => [
                'required',
                'string',
                'max:255',
            ],
            'body'    => [
                'required',
                'string',
            ],
            'tags'    => [
                'required',
                'array',
            ],
            'tags.*'  => [
                'required',
                new Exists(Blog::table('tags'), 'uuid'),
            ],
        ];
    }

    /**
     * Get the current post.
     *
     * @return \Arcanesoft\Blog\Models\Post|mixed
     */
    protected function getCurrentPost(): Post
    {
        return $this->route()->parameter(PostsRoutes::POST_WILDCARD);
    }
}
