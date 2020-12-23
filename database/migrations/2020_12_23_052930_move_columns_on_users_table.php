<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MoveColumnsOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN lname VARCHAR(20) AFTER fname");
            //$table->string('profile_picture', 255);
            DB::statement("ALTER TABLE users MODIFY COLUMN profile_picture VARCHAR(255) AFTER email");
            DB::statement("ALTER TABLE users MODIFY COLUMN compound VARCHAR(255) AFTER email");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
