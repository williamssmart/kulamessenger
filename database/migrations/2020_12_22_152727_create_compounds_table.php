<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compounds', function (Blueprint $table) {
            $table->id();
            $table->string('name' , 100);
            $table->timestamps();
        });

        DB::table('compounds')->insert([
            ['name' => 'Ibani polo' ,'created_at' => date('Y-m-d h-m-s') , 'updated_at'=> date('Y-m-d h-m-s')],
            ['name' => 'Ogono polo' , 'created_at' => date('Y-m-d h-m-s'), 'updated_at'=> date('Y-m-d h-m-s')],
            ['name' => 'Igbebiridia polo','created_at' => date('Y-m-d h-m-s'), 'updated_at'=> date('Y-m-d h-m-s')],
            ['name' => 'Agame polo','created_at' => date('Y-m-d h-m-s'), 'updated_at'=> date('Y-m-d h-m-s')],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compounds');
    }
}
