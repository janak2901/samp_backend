<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('leave_types')) {
            if (Schema::hasColumn('leave_types', 'list_of_reasons')) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                Schema::drop('leave_types');
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }

        if (!(Schema::hasTable('leave_types'))) {
            Schema::create('leave_types', function (Blueprint $table) {
                $table->id();
                $table->string('leave_type_name', 245);
                $table->string('leave_code', 10)->nullable();
                $table->text('description')->nullable();

                $table->smallInteger('effective_after')->nullable();
                $table->enum('effective_after_type', ['day', 'month', 'year'])->nullable();
                $table->enum('effective_after_from', ['joining_date', 'completing_probation'])->nullable();

                $table->smallInteger('salary_deduction_days')->nullable();

                $table->smallInteger('carry_forward')->nullable();
                $table->enum('carry_forward_type', ['percent', 'unit'])->nullable();
                $table->mediumInteger('carry_forward_max_limit')->nullable();

                $table->smallInteger('encashment')->nullable();
                $table->enum('encashment_type', ['percent', 'unit'])->nullable();
                $table->mediumInteger('encashment_max_limit')->nullable();

                $table->text('accrual')->nullable(); //
                $table->text('reset')->nullable(); //

                $table->tinyInteger('allow_if_join_before')->nullable();

                $table->boolean('is_join_pro_rate')->nullable();
                $table->boolean('is_leave_pro_rate')->nullable();

                $table->smallInteger('leave_request_before_days')->nullable();
                $table->boolean('allow_applying_half_day')->nullable();
                $table->boolean('doc_proof_required')->nullable();

                $table->enum('restrict_to_gender', ['male', 'female', 'transgender'])->nullable();
                $table->enum('restrict_to_marital_status', ['married', 'unmarried'])->nullable();

                $table->enum('round_off_dec_leave', ['do_not', 'half_day', ' full_day'])->nullable();

                $table->boolean('require_approval')->nullable();

                $table->smallInteger('max_consecutive_leave_days')->nullable();
                $table->smallInteger('min_days_gap_between_two_leaves')->nullable();

                $table->boolean('allow_in_notice_period')->nullable();

                $table->smallInteger('max_no_of_leave')->nullable();
                $table->enum('max_no_of_leave_in', ['week', 'month', 'year'])->nullable();

                $table->smallInteger('count_holiday_as_leave_after_days')->nullable();
                $table->smallInteger('count_weekend_as_leave_after_days')->nullable();

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
        Schema::dropIfExists('leave_types');
    }
}