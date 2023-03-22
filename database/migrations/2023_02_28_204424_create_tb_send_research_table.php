<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSendResearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_send_research', function (Blueprint $table) {
            $table->unsignedBigInteger('research_id');
            $table->unsignedBigInteger('id');
            $table->integer('pc');
            $table->timestamps();

            $table->primary(['research_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_send_research');
    }
}
