<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_feedback', function (Blueprint $table) {
           // $table->id();
            $table->integer('research_id')->primary();
            $table->integer('employee_referees_id');

            $table->dateTime('date_send_referess')->nullable();
            $table->string('status')->default(0);
            /*0=รอตรวจสอบ ,1=ตรวจสอบแล้ว*/
            $table->text('feedback')->nullable();
            $table->string('Assessment_result')->nullable();
            $table->string('suggestionFile')->nullable();
            $table->dateTime('Date_feedback_research')->nullable();
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
        Schema::dropIfExists('tb_feedback');
    }
}
