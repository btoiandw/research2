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
            $table->string('status')->default('1');
            $table->text('lesson1');
            $table->text('lesson2')->nullable();
            $table->text('lesson3')->nullable();
            $table->text('lesson4')->nullable();
            $table->text('lesson5')->nullable();
            $table->text('lesson6')->nullable();
            $table->text('lesson7')->nullable();
            $table->text('lesson8')->nullable();
            $table->text('lesson9')->nullable();
            $table->text('lesson10')->nullable();
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
