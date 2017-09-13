<?php

use Arcanesoft\Blog\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateBlogCategoriesTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @see \Arcanesoft\Blog\Models\Tag
 */
class CreateBlogCategoriesTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * CreateBlogCategoriesTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable('categories');
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
            $table->string('name', 50);
            $table->string('slug', 50);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('name');
            $table->unique('slug');
        });
    }
}
