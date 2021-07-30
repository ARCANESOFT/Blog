<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Http\Requests\Authors;

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
        $this->merge([
            'slug' => Str::slug($this->get('slug') ?? $this->get('username')),
        ]);
    }
}
