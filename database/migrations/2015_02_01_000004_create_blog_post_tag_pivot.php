<?php

use Arcanesoft\Blog\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateBlogTagsTable
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CreateBlogPostTagPivot extends Migration
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * CreateBlogTagsTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable('post_tag');
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
            $table->integer('post_id')->unsigned();
            $table->integer('tag_id')->unsigned();
        });
    }
}
