<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawsurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rawsurvey', function (Blueprint $table) {
            $table->increments('id');
            $table->string('respondent_serial');
            $table->string('respondent_id');
            $table->string('datacollection_status')->nullable();
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('interview_length')->nullable();
            $table->string('db_wave')->nullable();
            $table->string('db_interviewdate')->nullable();
            $table->string('quota_year')->nullable();
            $table->string('quota_month')->nullable();
            $table->string('quota_wave')->nullable();
            $table->string('s_info')->nullable();
            $table->string('s1')->nullable();
            $table->string('q1')->nullable();
            $table->string('q2')->nullable();
            $table->string('q3')->nullable();
            $table->string('q4')->nullable();
            $table->string('q5')->nullable();
            $table->string('q6')->nullable();
            $table->string('q7')->nullable();
            $table->string('q8')->nullable();
            $table->string('q8_9')->nullable();
            $table->string('q9')->nullable();
            $table->string('q10')->nullable();
            $table->string('q11')->nullable();
            $table->string('q12')->nullable();
            $table->string('q13')->nullable();
            $table->string('q14')->nullable();
            $table->string('rq14')->nullable();
            $table->string('cklow_score')->nullable();
            $table->string('opinion_category')->nullable();
            $table->string('complaint1')->nullable();
            $table->string('complaint2')->nullable();
            $table->string('recommend')->nullable();
            $table->string('s_region')->nullable();
            $table->string('s_category')->nullable();
            $table->string('s_person2')->nullable();
            $table->string('s_person')->nullable();
            $table->string('send_date')->nullable();
            $table->string('acceptance_code')->nullable();
            $table->string('product_code')->nullable();
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
        Schema::dropIfExists('rawsurvey');
    }
}
