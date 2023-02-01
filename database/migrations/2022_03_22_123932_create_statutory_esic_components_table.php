<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatutoryEsicComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('statutory_esic_components')) {
            Schema::create('statutory_esic_components', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_esic_activated')->default(0);
                $table->string('company_esic_number')->nullable();
                $table->string('esic_applicable_from')->nullable();
                $table->float('employer_cont_rate')->default(3.25);
                $table->float('employee_cont_rate')->default(0.75);
                $table->string('esic_eligibility')->default('Monthly gross salary eligible for ESIC 21000');
                $table->string('esic_deduction_cycle')->default('monthly');
                $table->boolean('employer_count_from_ctc')->default(0);
                $table->boolean('hide_this_component')->default(0);
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('statutory_esic_components');
    }
}