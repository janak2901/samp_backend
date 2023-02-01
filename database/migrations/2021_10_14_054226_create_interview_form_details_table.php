<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('interview_form_details'))) {

            Schema::create('interview_form_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("interview_field_id");
                $table->unsignedBigInteger("interview_candidate_id");
                $table->text("answer");
                $table->foreign("interview_field_id")->references('id')->on("interview_fields")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("interview_candidate_id")->references('id')->on("interview_candidates")->onUpdate('cascade')->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_form_details');
    }
}
