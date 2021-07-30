<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Authors;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Foundation\Authorization\Rules\Users\EmailRule;
use Illuminate\Validation\Rule;

/**
 * Class     CreateAuthorRequest
 *
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
}
