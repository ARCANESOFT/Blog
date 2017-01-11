<?php namespace Arcanesoft\Blog\Http\Controllers\Front;

use Arcanesoft\Blog\Models\Post;

/**
 * Class     PostsController
 *
 * @package  Arcanesoft\Blog\Http\Controllers\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $posts = Post::published()->latest()->paginate(6);

        return $this->view('blog::front.posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        return $this->view('blog::front.posts.single', compact('post'));
    }

    public function archive($year)
    {
        $posts = Post::publishedAt($year)->latest()->paginate(6);

        return $this->view('blog::front.posts.single', compact('posts'));
    }
}
