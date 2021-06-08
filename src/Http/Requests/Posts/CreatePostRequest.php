<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Posts;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Http\Requests\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\{Exists, Unique};

/**
 * Class     CreatePostRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Posts
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
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'   => ['required', 'string', 'max:255'],
            'slug'    => ['required', 'string', new Unique(Blog::table('posts'), 'slug')],
            'excerpt' => ['required', 'string', 'max:255'],
            'body'    => ['required', 'string'],
            'tags'    => ['required', 'array'],
            'tags.*'  => ['required', new Exists(Blog::table('tags'), 'uuid')],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->get('slug') ?: $this->get('title')),
        ]);
    }
}
