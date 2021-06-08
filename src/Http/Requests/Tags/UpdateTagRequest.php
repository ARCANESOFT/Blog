<?php namespace Arcanesoft\Blog\Http\Requests\Tags;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Http\Requests\FormRequest;
use Arcanesoft\Blog\Http\Routes\TagsRoutes;
use Arcanesoft\Blog\Rules\Tags\NameRule;
use Arcanesoft\Blog\Rules\Tags\SlugRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Class     UpdateTagRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UpdateTagRequest extends FormRequest
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
        $tag = $this->getCurrentTag();

        return [
            'name' => [
                'required',
                'string',
                NameRule::unique()->ignore($tag->getRouteKey(), $tag->getRouteKeyName()),
            ],
            'slug' => [
                'required',
                'string',
                SlugRule::unique()->ignore($tag->getRouteKey(), $tag->getRouteKeyName()),
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (is_null($this->get('slug'))) {
            $this->merge([
                'slug' => Str::slug($this->get('name')),
            ]);
        }
    }

    /**
     * Get the current tag.
     *
     * @return \Arcanesoft\Blog\Models\Tag|mixed
     */
    protected function getCurrentTag()
    {
        return $this->route()->parameter(TagsRoutes::TAG_WILDCARD);
    }
}
