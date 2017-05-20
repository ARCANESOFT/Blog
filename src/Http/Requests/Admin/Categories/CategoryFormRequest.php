<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Categories;

use Arcanesoft\Blog\Http\Requests\Admin\FormRequest;

/**
 * Class     CategoryFormRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Admin\Categories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class CategoryFormRequest extends FormRequest
{
    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validated inputs.
     *
     * @return array
     */
    public function getValidatedData()
    {
        return $this->only(['name']);
    }
}
