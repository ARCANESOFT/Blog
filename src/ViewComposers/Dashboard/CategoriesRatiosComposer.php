<?php namespace Arcanesoft\Blog\ViewComposers\Dashboard;

use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\ViewComposers\AbstractComposer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class     CategoriesRatiosComposer
 *
 * @package  Arcanesoft\Blog\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesRatiosComposer extends AbstractComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'blog::admin._composers.dashboard.categories-ratios-chart';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function compose(View $view)
    {
        $view->with('categoriesRatios', $this->prepareRatios(
            $this->cachedCategories()->load(['posts'])
        ));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Prepare the categories ratios.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function prepareRatios(Collection $categories)
    {
        $ratios = $categories->filter(function (Category $category) {
                return $category->hasPosts();
            })
            ->transform(function (Category $category) {
                return [
                    'label' => $category->name,
                    'posts' => $category->posts->count(),
                ];
            })
            ->sortByDesc('posts');

        $chunk  = $ratios->splice(5);
        $ratios = $this->colorizeRatios($ratios);

        return $chunk->isEmpty() ? $ratios : $ratios->push([
            'label' => 'Other Categories',
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
