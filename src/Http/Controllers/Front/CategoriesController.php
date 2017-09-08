<?php namespace Arcanesoft\Blog\Http\Controllers\Front;

use Arcanesoft\Blog\Models\Category;

/**
 * Class     CategoriesController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Complete the seo feature.
 */
class CategoriesController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function show($slug)
    {
        /** @var  \Arcanesoft\Blog\Models\Category  $category */
        $category = Category::query()->where('slug', $slug)->firstOrFail();
        $posts    = $category->posts()->paginate();

        $this->setTitle($title = "Category: {$category->name}");
        $this->addBreadcrumb($title);

        return $this->view('blog::front.categories.show', compact('category', 'posts'));
    }
}
