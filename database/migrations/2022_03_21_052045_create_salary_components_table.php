<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('salary_components')) {
            Schema::create('salary_components', function (Blueprint $table) {
                $table->id();
                $table->enum('category', ['earning', 'deduction']);
                $table->string('component_name');
                $table->text('description')->nullable();
                $table->string('name_in_pay_slip');
                $table->boolean('is_pf_applicable')->default(0);
                $table->boolean('is_esic_applicable')->default(0);
                $table->boolean('is_component_taxable')->default(0);
                $table->boolean('include_for_loss_of_pay')->default(0);
                $table->boolean('hide_this_component')->default(0);
                $table->enum('deduction_frequency', ['one_time_deduction', 'recurring_deduction'])->nullable();
                $table->boolean('default')->default(0);
                $table->boolean('status')->default(0);
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
        Schema::dropIfExists('salary_components');
    }
}