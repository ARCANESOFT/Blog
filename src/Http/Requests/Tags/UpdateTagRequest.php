<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Tags;

use Arcanesoft\Blog\Http\Routes\TagsRoutes;
use Arcanesoft\Blog\Rules\Tags\{NameRule, SlugRule};

/**
 * Class     UpdateTagRequest
 *
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
     * Get the current tag.
     *
     * @return \Arcanesoft\Blog\Models\Tag|mixed
     */
    protected function getCurrentTag()
    {
        return $this->route()->parameter(TagsRoutes::TAG_WILDCARD);
    }
}
