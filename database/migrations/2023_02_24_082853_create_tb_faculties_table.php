<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_faculties', function (Blueprint $table) {
            $table->id('organization_id');
            $table->string('organizational_name');
            //$table->string('major');
            $table->timestamps();
        });

        Schema::create('tb_majors', function (Blueprint $table) {
            $table->id('major_id');
            $table->string('major_name');
            $table->integer('organization_id');
            $table->string('group_disciplines');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_faculties');
        Schema::dropIfExists('tb_major');
    }
}
