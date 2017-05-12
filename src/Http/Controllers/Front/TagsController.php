<?php namespace Arcanesoft\Blog\Http\Controllers\Front;

use Arcanesoft\Blog\Models\Tag;

/**
 * Class     TagsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Complete the seo feature.
 */
class TagsController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function show($slug)
    {
        /** @var  \Arcanesoft\Blog\Models\Tag  $tag */
        $tag   = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->paginate();

        $this->setTitle($title = 'Tag: '.$tag->name);
        $this->addBreadcrumb($title);

        return $this->view('blog::front.tags.show', compact('tag', 'posts'));
    }
}
