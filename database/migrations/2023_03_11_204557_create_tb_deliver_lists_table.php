<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDeliverListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_deliver_lists', function (Blueprint $table) {
            $table->id('deliver_id');
            $table->integer('research_source_id');
            $table->string('Type_research');
            $table->date('Date_start_contract');
            $table->date('Date_end_contract');
            $table->text('lesson1');
            $table->text('lesson2');
            $table->text('lesson3');
            $table->text('lesson4');
            $table->text('lesson5');
            $table->text('lesson6');
            $table->text('lesson7');
            $table->text('lesson8');
            $table->text('lesson9');
            $table->text('lesson10');
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
        Schema::dropIfExists('tb_deliver_lists');
    }
}
