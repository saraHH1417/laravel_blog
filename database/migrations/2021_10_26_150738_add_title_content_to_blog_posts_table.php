<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleContentToBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if(env('DB_CONNECTION') === 'sqlite_testing'){
                $table->string('title')->default('');
                $table->text('contents')->default('');
            }else{
                $table->string('title');
                $table->text('contents');
            }
        });

//        Schema::rename('blog_posts' , 'blogPosts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['title' , 'contents']);
        });

//        Schema::rename('blogPosts' , 'blog_posts');
    }
}
