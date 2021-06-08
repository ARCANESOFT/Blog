<?php namespace Arcanesoft\Blog;

/**
 * Class     Blog
 *
 * @package  Arcanesoft\Blog
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Blog
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  bool */
    public static $runsMigrations = true;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the blog table name.
     *
     * @param  string       $name
     * @param  string|null  $default
     * @param  bool         $prefixed
     *
     * @return string
     */
    public static function table(string $name, $default = null, $prefixed = true): string
    {
        $name = config()->get("arcanesoft.blog.database.tables.{$name}", $default);

        return $prefixed ? static::prefixTable($name) : $name;
    }

    /**
     * Get the model class by the given key.
     *
     * @param  string       $name
     * @param  string|null  $default
     *
     * @return string
     */
    public static function model(string $name, $default = null): string
    {
        // TODO: Throw exception if not found ?

        return config()->get("arcanesoft.blog.database.models.{$name}", $default);
    }

    /**
     * Make/Get the model instance.
     *
     * @param  string       $name
     * @param  string|null  $default
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|mixed
     */
    public static function makeModel(string $name, $default = null)
    {
        return app()->make(static::model($name, $default));
    }

    /**
     * Add the blog prefix to the table.
     *
     * @param  string  $name
     *
     * @return string
     */
    public static function prefixTable(string $name): string
    {
        $prefix = config()->get('arcanesoft.blog.database.prefix');

        return $prefix ? $prefix.$name : $name;
    }
}
