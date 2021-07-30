<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Authors;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Http\Routes\AuthorsRoutes;
use Arcanesoft\Foundation\Authorization\Rules\Users\EmailRule;
use Illuminate\Validation\Rule;

/**
 * Class     UpdateAuthorRequest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateAuthorRequest extends FormRequest
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
        $author = $this->getCurrentAuthor();

        return [
            // Author
            'username' => ['required', 'string'],
            'slug'     => ['required', 'string', Rule::unique(Blog::table('authors', 'slug'))->ignore($author)],
            'bio'      => ['required', 'string'],

            // User
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:255', EmailRule::unique()->ignore($author)],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the current author.
     *
     * @return \Arcanesoft\Blog\Models\Author|mixed
     */
    protected function getCurrentAuthor()
    {
        return $this->route()->parameter(AuthorsRoutes::AUTHOR_WILDCARD);
    }
}
