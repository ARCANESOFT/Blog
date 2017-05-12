<?php namespace Arcanesoft\Blog\Http\Controllers\Front;

use Arcanesoft\Blog\Models\Post;

/**
 * Class     PostsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Complete the seo feature.
 */
class PostsController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $posts = Post::published()->latest()->paginate(6);

        return $this->view('blog::front.posts.index', compact('posts'));
    }

    public function show($slug)
    {
        /** @var  \Arcanesoft\Blog\Models\Post  $post */
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $this->setTitle($post->seo->title);
        $this->setDescription($post->seo->description);
        $this->setKeywords($post->seo->keywords ? $post->seo->keywords->toArray() : []);
        $this->addBreadcrumb($post->title);

        return $this->view('blog::front.posts.single', compact('post'));
    }

    public function archive($year)
    {
        $posts = Post::publishedAt($year)->latest()->paginate(6);

        return $this->view('blog::front.posts.single', compact('posts'));
    }
}
