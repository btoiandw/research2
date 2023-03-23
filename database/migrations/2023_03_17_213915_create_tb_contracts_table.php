<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_contracts', function (Blueprint $table) {
            $table->integer('contract_id');
            $table->integer('research_id');
            $table->string('file_cont')->nullable();
            $table->date('date_start_cont');
            $table->date('date_end_cont');
            $table->double('money_cont');
            $table->date('date_upload_file')->nullable();
            $table->date('date_gen')->nullable();
            $table->integer('deliver_id');
            $table->string('contract_status');
            $table->timestamps();

            $table->primary(['contract_id','research_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_contracts');
    }
}
