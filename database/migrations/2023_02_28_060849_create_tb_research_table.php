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
            $table->unsignedBigInteger('research_id');
            $table->timestamp('date_upload_file');
            $table->string('research_th');
            $table->string('research_en');
            $table->string('research_source_id');
            $table->string('type_research_id');
            $table->text('keyword');
            $table->date('date_research_start');
            $table->date('date_research_end');
            $table->text('research_area');
            $table->double('budage_research');
            $table->string('word_file');
            $table->string('pdf_file');
            $table->text('research_summary_feedback')->nullable();
            $table->string('summary_feedback_file')->nullable();
            $table->string('research_status')->default('0');
            /*0=รอตรวจสอบ, 1=ไม่ผ่าน/ปรับปรุงครั้งที่ 1, 2=ไม่ผ่าน/ปรับปรุงครั้งที่ 2, 3=ไม่ผ่าน/ปรับปรุงครั้งที่ 3, 4=ผ่าน, 5=ยกเลิก,6=รอการตวจสอบจากคระกรรมการ,7=ไม่ผ่านการตรวจสอบโดยแอดมิน */
            $table->string('year_research');
            $table->timestamps();

            $table->primary(['research_id', 'date_upload_file']);
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
