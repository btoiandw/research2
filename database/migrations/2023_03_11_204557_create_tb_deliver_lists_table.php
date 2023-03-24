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
            $table->unsignedBigInteger('deliver_id');
            $table->unsignedBigInteger('num_lesson');
            $table->integer('research_source_id');
            $table->string('Type_research');
            $table->date('Date_start_contract');
            $table->date('Date_end_contract');
            $table->string('status')->default('1');
            $table->text('lesson');
            $table->timestamps();

            $table->primary(['deliver_id', 'num_lesson']);
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
