<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatutoryProfTaxComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('statutory_prof_tax_components')) {
            Schema::create('statutory_prof_tax_components', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('state');
                $table->foreign("state")->references('id')->on("states")->onUpdate('cascade')->onDelete('cascade');
                $table->string('registration_number');
                $table->enum('deduction_cycle', ['quarterly', 'monthly', 'half_year', 'yearly'])->default('quarterly');
                $table->boolean('calculate_prof_tax_monthly')->default(0);
                $table->json('prof_tax_json');
                $table->boolean('status')->default(1);
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
        Schema::dropIfExists('statutory_prof_tax_components');
    }
}