<?php namespace Arcanesoft\Blog\ViewComposers\Admin\Dashboard;

use Arcanesoft\Blog\Models\Tag;
use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class     TagsRatiosComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsRatiosComposer extends AbstractComposer
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const VIEW = 'blog::admin._composers.dashboard.tags-ratios-chart';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function compose(View $view)
    {
        $view->with('tagsRatios', $this->prepareRatios(
            $this->cachedTags()->load(['posts'])
        ));
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Prepare the tags ratios.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $tags
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function prepareRatios(Collection $tags)
    {
        $ratios = $tags->filter(function (Tag $tag) {
                return $tag->hasPosts();
            })
            ->transform(function (Tag $tag) {
                return [
                    'label' => $tag->name,
                    'posts' => $tag->posts->count(),
                ];
            })
            ->sortByDesc('posts');

        $chunk  = $ratios->splice(5);
        $ratios = $this->colorizeRatios($ratios);

        return $chunk->isEmpty() ? $ratios : $ratios->push([
            'label' => 'Other Tags',
            'posts' => $chunk->sum('posts'),
            'color' => '#D2D6DE',
        ]);
    }

    /**
     * Colorize the ratios.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $ratios
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function colorizeRatios(Collection $ratios)
    {
        $colors = ['#F56954', '#00A65A', '#F39C12', '#00C0EF', '#3C8DBC'];

        return $ratios->values()->transform(function (array $values, $key) use ($colors) {
            return $values + ['color' => $colors[$key]];
        });
    }
}
