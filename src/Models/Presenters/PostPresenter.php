<?php namespace Arcanesoft\Blog\Models\Presenters;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

/**
 * Trait PostPresenter
 *
 * @package  Arcanesoft\Blog\Models\Presenters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string                          locale_native
 * @property  \Illuminate\Support\HtmlString  content
 * @property  string                          status
 * @property  string                          status_name
 */
trait PostPresenter
{
    /* -----------------------------------------------------------------
     |  Accessors
     | -----------------------------------------------------------------
     */

    /**
     * Get the locale's native name.
     *
     * @return string
     */
    public function getLocaleNativeAttribute()
    {
        return localization()->getSupportedLocales()->get($this->locale)->native();
    }

    /**
     * Get the content attribute.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function getContentAttribute()
    {
        return new HtmlString($this->content_html);
    }

    /**
     * Get the status attribute.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->isDraft() ? self::STATUS_DRAFT : self::STATUS_PUBLISHED;
    }

    /**
     * Set the status attribute.
     *
     * @param  string  $status
     *
     * @return self
     */
    public function setStatusAttribute($status)
    {
        $this->attributes['is_draft'] = ($status === self::STATUS_DRAFT);

        return $this;
    }

    /**
     * Get the status name attribute.
     *
     * @return string|null
     */
    public function getStatusNameAttribute()
    {
        return self::getStatuses()->get(
            $this->getStatusAttribute()
        );
    }

    /**
     * Get the post statuses.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getStatuses()
    {
        return new Collection(
            trans('blog::posts.statuses', [])
        );
    }

    /* -----------------------------------------------------------------
     |  URL Accessors
     | -----------------------------------------------------------------
     */

    /**
     * Get the show URL.
     *
     * @return string
     */
    public function getShowUrl()
    {
        return route('admin::blog.posts.show', $this);
    }

    /**
     * Get the edit URL.
     *
     * @return string
     */
    public function getEditUrl()
    {
        return route('admin::blog.posts.edit', $this);
    }
}
