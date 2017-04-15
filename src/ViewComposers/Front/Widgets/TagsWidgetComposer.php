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
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const VIEW = 'blog::front._composers.widgets.tags-widget';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function compose(View $view)
    {
        $tags = Tag::with('posts')
            ->whereHas('posts', function (Builder $b) {
                // TODO: Try to export this code with model's scope ?
                $b->where('is_draft', false)
                  ->where('published_at', '<=', Carbon::now());
            })
            ->get()
            ->sortByDesc(function($tag) {
                return $tag->posts->count();
            });

        $view->with('tagsWidgetItems', $tags);
    }
}
