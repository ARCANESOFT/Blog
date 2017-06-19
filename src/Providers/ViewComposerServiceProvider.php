<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\Providers\ViewComposerServiceProvider as ServiceProvider;
use Arcanesoft\Blog\ViewComposers\Admin\Dashboard\CategoriesCountComposer;
use Arcanesoft\Blog\ViewComposers\Admin\Dashboard\CategoriesRatiosComposer;
use Arcanesoft\Blog\ViewComposers\Admin\Dashboard\CommentsCountComposer;
use Arcanesoft\Blog\ViewComposers\Admin\Dashboard\PostsCountComposer;
use Arcanesoft\Blog\ViewComposers\Admin\Dashboard\TagsCountComposer;
use Arcanesoft\Blog\ViewComposers\Admin\Dashboard\TagsRatiosComposer;
use Arcanesoft\Blog\ViewComposers\Admin\Forms\LocalesSelectComposer;
use Arcanesoft\Blog\ViewComposers\Front\Widgets\ArchivesWidgetComposer;
use Arcanesoft\Blog\ViewComposers\Front\Widgets\CategoriesWidgetComposer;
use Arcanesoft\Blog\ViewComposers\Front\Widgets\TagsWidgetComposer;

/**
 * Class     ViewComposerServiceProvider
 *
 * @package  Arcanesoft\Blog\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ViewComposerServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerClasses = [
        // Dashboard view composers
        PostsCountComposer::VIEW       => PostsCountComposer::class,
        CategoriesCountComposer::VIEW  => CategoriesCountComposer::class,
        CategoriesRatiosComposer::VIEW => CategoriesRatiosComposer::class,
        TagsCountComposer::VIEW        => TagsCountComposer::class,
        TagsRatiosComposer::VIEW       => TagsRatiosComposer::class,
        CommentsCountComposer::VIEW    => CommentsCountComposer::class,

        // Admin view composers
        LocalesSelectComposer::VIEW    => LocalesSelectComposer::class,

        // Public view composers (Widgets)
        CategoriesWidgetComposer::VIEW => CategoriesWidgetComposer::class,
        TagsWidgetComposer::VIEW       => TagsWidgetComposer::class,
        ArchivesWidgetComposer::VIEW   => ArchivesWidgetComposer::class,
    ];
}
