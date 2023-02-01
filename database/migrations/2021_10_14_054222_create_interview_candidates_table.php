<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('interview_candidates'))) {

            Schema::create('interview_candidates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("designation_id");
                $table->unsignedBigInteger("department_id");
                $table->string("f_name", 20);
                $table->string("l_name", 20);
                $table->string("m_name", 20);
                $table->string("email", 50);
                $table->string("phone_no", 20);
                $table->enum("employeement_type", ["Non technical", "technical"]);
                $table->integer("current_salary");
                $table->integer("expected_salary");
                $table->enum("status",   ["Pass", " Fail", " Pending"]);
                $table->foreign("designation_id")->references('id')->on("designations")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("department_id")->references('id')->on("departments")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('interview_candidate');
    }
}
