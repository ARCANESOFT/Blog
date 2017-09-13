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

        $this->setTable('post_tag');
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
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('tag_id');

            $table->primary(['post_id', 'tag_id']);
        });
    }
}
