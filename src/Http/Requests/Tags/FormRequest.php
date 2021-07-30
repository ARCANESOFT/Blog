<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Support\Str;

/**
 * Class     FormRequest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* -----------------------------------------------------------------
     |  Common Methods
     | -----------------------------------------------------------------
     */

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
}
