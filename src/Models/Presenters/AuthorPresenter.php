<?php namespace Arcanesoft\Blog\Models\Presenters;

use Illuminate\Support\Str;

/**
 * Trait     AuthorPresenter
 *
 * @package  Arcanesoft\Blog\Models\Presenters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property-read  string  full_name
 * @property-read  string  first_name
 * @property-read  string  last_name
 * @property-read  string  email
 */
trait AuthorPresenter
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the `full_name` attribute.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->creator->full_name;
    }

    /**
     * Get the `first_name` attribute.
     *
     * @return string
     */
    public function getFirstNameAttribute()
    {
        return $this->creator->first_name;
    }

    /**
     * Get the `last_name` attribute.
     *
     * @return string
     */
    public function getLastNameAttribute()
    {
        return $this->creator->last_name;
    }

    /**
     * Get the `email` attribute.
     *
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->creator->email;
    }

    /**
     * Set the `slug` attribute.
     *
     * @param  string  $slug
     *
     * @return void
     */
    public function setSlugAttribute(string $slug)
    {
        $this->attributes['slug'] = Str::slug($slug);
    }
}
