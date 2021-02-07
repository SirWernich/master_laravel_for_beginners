<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
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
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);   // laravel figures out name of foreign key
            $table->dropColumn('user_id');
        });
    }
}
