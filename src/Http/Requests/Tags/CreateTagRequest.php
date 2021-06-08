<?php namespace Arcanesoft\Blog\Http\Requests\Tags;

use Arcanesoft\Blog\Http\Requests\FormRequest;
use Arcanesoft\Blog\Rules\Tags\NameRule;
use Arcanesoft\Blog\Rules\Tags\SlugRule;
use Illuminate\Support\Str;

/**
 * Class     CreateTagRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Tags
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (is_null($this->get('slug'))) {
            $this->merge([
                'slug' => Str::slug($this->get('name')),
            ]);
        }
    }
}
