<?php

use Arcanesoft\Blog\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateBlogTagsTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @see \Arcanesoft\Blog\Models\Tag
 */
class CreateBlogTagsTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * CreateBlogTagsTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable('tags');
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
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('name');
            $table->unique('slug');
        });
    }
}
