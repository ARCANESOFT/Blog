<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Posts;

use Arcanesoft\Blog\Blog;
use Illuminate\Validation\Rules\{Exists, Unique};

/**
 * Class     CreatePostRequest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreatePostRequest extends FormRequest
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
                new Unique(Blog::table('posts'), 'slug'),
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
}
