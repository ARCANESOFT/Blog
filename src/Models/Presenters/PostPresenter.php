<?php namespace Arcanesoft\Blog\Models\Presenters;

use Arcanesoft\Blog\Entities\PostStatus;
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
        $locale = $this->getAttributeFromArray('locale');

        try {
            return localization()
                ->getSupportedLocales()
                ->get($locale)
                ->native();
        }
        catch (\Exception $e) {
            return strtoupper($locale);
        }
    }

    /**
     * Get the content attribute.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function getContentAttribute()
    {
        return new HtmlString($this->getAttributeFromArray('content_html'));
    }

    /**
     * Get the status attribute.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->isDraft() ? PostStatus::STATUS_DRAFT : PostStatus::STATUS_PUBLISHED;
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
        $this->setAttribute('is_draft', $status === PostStatus::STATUS_DRAFT);

        return $this;
    }

    /**
     * Get the status name attribute.
     *
     * @return string|null
     */
    public function getStatusNameAttribute()
    {
        return PostStatus::get(
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
        return PostStatus::all();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the post's status is "draft".
     *
     * @return bool
     */
    abstract public function isDraft();

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
        return route('admin::blog.posts.show', [$this]);
    }

    /**
     * Get the edit URL.
     *
     * @return string
     */
    public function getEditUrl()
    {
        return route('admin::blog.posts.edit', [$this]);
    }

    /* -----------------------------------------------------------------
     |  Eloquent Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get an attribute from the $attributes array.
     *
     * @param  string  $key
     * @return mixed
     */
    abstract protected function getAttributeFromArray($key);

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    abstract public function setAttribute($key, $value);
}
