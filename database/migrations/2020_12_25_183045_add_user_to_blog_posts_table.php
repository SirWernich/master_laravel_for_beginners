<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            echo env('DB_CONNECTION');
            if (env('DB_CONNECTION') === 'sqlite_testing') {
                $table->foreignId('user_id')->default(0)->constrained('users');
            } else {
                $table->foreignId('user_id')->constrained('users'); // ->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);   // laravel figures out name of foreign key
            $table->dropColumn('user_id');
        });
    }
}
