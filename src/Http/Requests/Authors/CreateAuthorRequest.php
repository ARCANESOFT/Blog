<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Authors;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Http\Requests\FormRequest;
use Arcanesoft\Foundation\Auth\Rules\Users\EmailRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Class     CreateAuthorRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Authors
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateAuthorRequest extends FormRequest
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
        return [
            // Author
            'username' => ['required', 'string'],
            'slug'     => ['required', 'string', Rule::unique(Blog::table('authors', 'slug'))],
            'bio'      => ['required', 'string'],

            // User
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:255', EmailRule::unique()],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->get('slug') ?? $this->get('username')),
        ]);
    }

    /**
     * Get the validated data.
     *
     * @return array
     */
    public function getValidatedData(): array
    {
        return $this->all([
            // Author
            'username',
            'slug',
            'bio',

            // User
            'first_name',
            'last_name',
            'email',
            'password',
        ]);
    }
}
