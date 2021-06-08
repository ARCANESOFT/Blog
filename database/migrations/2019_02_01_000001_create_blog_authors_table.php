<?php

declare(strict_types=1);

use Arcanesoft\Blog\Database\Migration;
use Arcanesoft\Blog\Blog;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateBlogAuthorsTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @see  \Arcanesoft\Blog\Models\Author
 */
class CreateBlogAuthorsTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Make a migration instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable(Blog::table('authors', 'authors', false));
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->createSchema(function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->morphs('creator');
            $table->string('username');
            $table->string('slug')->unique();
            $table->text('bio');
            $table->text('meta')->nullable();
            $table->timestamps();

            $table->index(['uuid', 'slug']);
        });
    }
}
