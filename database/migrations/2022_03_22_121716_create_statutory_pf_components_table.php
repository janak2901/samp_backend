<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatutoryPfComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('statutory_pf_components')) {
            Schema::create('statutory_pf_components', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_pf_activated')->default(0);
                $table->string('company_epf_number')->nullable();
                $table->string('pf_applicable_from')->nullable();
                $table->float('employer_cont_rate')->default(13.00);
                $table->float('employee_cont_rate')->default(12.00);
                $table->string('ef_eligibility')->default("(Basic + DA) > 15000");
                $table->string('pf_deduction_cycle')->default("monthly");
                $table->boolean('employer_cont_in_ctc')->default(0);
                $table->boolean('employer_eldi_cont_in_ctc')->default(0);
                $table->boolean('admin_charges_in_ctc')->default(0);
                $table->enum('eligible_for_abry', ['employee', 'both_employee_and_employer'])->nullable();
                $table->boolean('hide_this_component')->default(0);
                $table->boolean('pro_rate_restricted_wage')->default(0);
                $table->boolean('all_applicable_pf_comp')->default(0);
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
        Schema::dropIfExists('statutory_pf_components');
    }
}