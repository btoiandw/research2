<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbResearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_research', function (Blueprint $table) {
            $table->unsignedBigInteger('research_id')->primary();
            $table->string('research_th');
            $table->string('research_en');
            $table->string('research_source_id');
            $table->string('type_research_id');
            $table->text('keyword');
            $table->date('date_research_start');
            $table->date('date_research_end');
            $table->text('research_area');
            $table->double('budage_research');
            //ส่งครั้งแรก
            $table->string('word_file_0');
            $table->string('pdf_file_0');
            $table->dateTime('date_upload_file_0');
            $table->text('research_summary_feedback_0')->nullable();
            $table->string('summary_feedback_file_0')->nullable();
            //ปรับแก้ครั้งที่ 1
            $table->string('word_file_1')->nullable();
            $table->string('pdf_file_1')->nullable();
            $table->dateTime('date_upload_file_1')->nullable();
            $table->text('research_summary_feedback_1')->nullable();
            $table->string('summary_feedback_file_1')->nullable();
            //ปรับแก้ครั้งที่ 2
            $table->string('word_file_2')->nullable();
            $table->string('pdf_file_2')->nullable();
            $table->dateTime('date_upload_file_2')->nullable();
            $table->text('research_summary_feedback_2')->nullable();
            $table->string('summary_feedback_file_2')->nullable();
            //ปรับแก้ครั้งที่ 3
            $table->string('word_file_3')->nullable();
            $table->string('pdf_file_3')->nullable();
            $table->dateTime('date_upload_file_3')->nullable();
            $table->text('research_summary_feedback_3')->nullable();
            $table->string('summary_feedback_file_3')->nullable();

            $table->text('base_feed_text')->nullable();
            $table->string('base_feed_file')->nullable();
            $table->string('research_status')->default('0');
            $table->string('year_research');
            $table->timestamps();

            //$table->primary(['research_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_research');
    }
}
