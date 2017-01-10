<?php namespace Arcanesoft\Blog\ViewComposers\Front\Widgets;

use Arcanesoft\Blog\Entities\PostStatus;
use Arcanesoft\Blog\Models\Tag;
use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class     TagsWidgetComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Front\Widgets
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsWidgetComposer extends AbstractComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'blog::front._composers.widgets.tags-widget';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function compose(View $view)
    {
        $tags = Tag::with('posts')
            ->whereHas('posts', function (Builder $b) {
                $b->where('status', PostStatus::STATUS_PUBLISHED)
                  ->where('publish_date', '<=', Carbon::now());
            })
            ->get()
            ->sortByDesc(function($tag) {
                return $tag->posts->count();
            });

        $view->with('tagsWidgetItems', $tags);
    }
}
