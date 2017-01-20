<?php

use Arcanesoft\Blog\Bases\Migration;
use Arcanesoft\Blog\Entities\PostStatus;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateBlogPostsTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateBlogPostsTable extends Migration
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * CreateBlogPostsTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable('posts');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createSchema(function(Blueprint $table) {
            $table->increments('id');

            $table->integer('author_id')->unsigned()->default(0);
            $table->integer('category_id')->unsigned();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longtext('content_raw');
            $table->longtext('content_html');
            $table->boolean('is_draft')->default(false);
            $table->timestamps();
            $table->timestamp('published_at');
            $table->softDeletes();
        });
    }
}
