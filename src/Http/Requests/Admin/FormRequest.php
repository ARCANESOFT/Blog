<?php namespace Arcanesoft\Blog\Http\Requests\Admin;

use Arcanedev\Support\Http\FormRequest as BaseFormRequest;
use Arcanesoft\Blog\Blog;

/**
 * Class     FormRequest
 *
 * @package  Arcanesoft\Blog\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the blog is translatable.
     *
     * @return bool
     */
    protected function isTranslatable()
    {
        return Blog::instance()->isTranslatable();
    }

    /**
     * Get the supported locales (only keys).
     *
     * @return array
     */
    protected function getSupportedLocales()
    {
        return Blog::instance()->getSupportedLocalesKeys();
    }
}
