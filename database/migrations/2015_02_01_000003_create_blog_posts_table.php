<?php

use Arcanesoft\Blog\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateBlogPostsTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @see \Arcanesoft\Blog\Models\Post
 */
class CreateBlogPostsTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * CreateBlogPostsTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable('posts');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createSchema(function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id')->default(0);
            $table->unsignedInteger('category_id');
            $table->string('locale', 5)->default(config('app.locale'));
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt');
            $table->string('thumbnail')->nullable();
            $table->longtext('content_raw');
            $table->longtext('content_html');
            $table->boolean('is_draft')->default(false);
            $table->timestamps();
            $table->timestamp('published_at');
            $table->softDeletes();

            $table->unique(['locale', 'slug']);
        });
    }
}
