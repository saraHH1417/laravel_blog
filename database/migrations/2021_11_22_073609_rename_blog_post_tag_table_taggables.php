<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBlogPostTagTableTaggables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_post_tag' , function (Blueprint $table){
            $table->dropForeign(['blog_post_id']);
            $table->dropColumn('blog_post_id');
        });

        Schema::rename('blog_post_tag' , 'taggables');

        Schema::table('taggables' , function (Blueprint $table){

//            $table->unsignedInteger('taggable_id');
//            $table->string('taggable_column');
            $table->morphs('taggable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taggables' , function (Blueprint $table){
            $table->dropMorphs('taggable');
        });

        Schema::rename('taggables' , 'blog_post_tag');

        Schema::disableForeignKeyConstraints();
        Schema::table('blog_post_tag' , function (Blueprint $table){
            $table->unsignedInteger('blog_post_id')->index();

            $table->foreign('blog_post_id')
                ->references('id')
                ->on('blog_posts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }
}
