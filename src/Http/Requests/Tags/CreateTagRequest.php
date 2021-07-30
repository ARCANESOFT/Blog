<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Tags;

use Arcanesoft\Blog\Rules\Tags\{NameRule, SlugRule};

/**
 * Class     CreateTagRequest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateTagRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                NameRule::unique(),
            ],
            'slug' => [
                'required',
                'string',
                SlugRule::unique(),
            ],
        ];
    }
}
