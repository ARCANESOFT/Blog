<?php namespace Arcanesoft\Blog\Http\Requests\Admin\Tags;

use Arcanesoft\Blog\Http\Requests\Admin\FormRequest;

/**
 * Class     TagFormRequest
 *
 * @package  Arcanesoft\Blog\Http\Requests\Admin\Tags
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TagFormRequest extends FormRequest
{
    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validated data.
     *
     * @return array
     */
    public function getValidatedData()
    {
        return [
            'name' => $this->get('name'),
            'slug' => $this->get('slug', $this->get('name')),
        ];
    }
}
