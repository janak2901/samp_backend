<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemainingFieldsInLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('leave_types')) {
            Schema::table('leave_types', function (Blueprint $table) {
                if (!Schema::hasColumn("leave_types", "status")) {
                    $table->boolean("status")->default(0)->after('id');
                }

                if (!Schema::hasColumn("leave_types", "auth_person")) {
                    $table->enum("auth_person", ["hr_manager", "reporting_person", "both"])->nullable()->after('require_approval');
                }

                if (!Schema::hasColumn("leave_types", "leave_exceeds_days")) {
                    $table->mediumInteger("leave_exceeds_days")->nullable()->after('doc_proof_required');
                }

                if (!Schema::hasColumn("leave_types", "count_holiday_for_leave_period")) {
                    $table->enum("count_holiday_for_leave_period", ["count_as_leave", "dont_count_as_leave"])->nullable()->after("count_weekend_as_leave_after_days");
                }

                if (!Schema::hasColumn("leave_types", "count_holiday_before_leave_period")) {
                    $table->boolean("count_holiday_before_leave_period")->nullable()->after("count_holiday_for_leave_period");
                }

                if (!Schema::hasColumn("leave_types", "count_holiday_as_leave_before_days")) {
                    $table->smallInteger("count_holiday_as_leave_before_days")->nullable()->after("count_holiday_before_leave_period");
                }

                if (!Schema::hasColumn("leave_types", "count_holiday_after_leave_period")) {
                    $table->boolean("count_holiday_after_leave_period")->nullable()->after("count_holiday_as_leave_before_days");
                }

                if (!Schema::hasColumn("leave_types", "count_holiday_between_leave_period")) {
                    $table->boolean("count_holiday_between_leave_period")->nullable()->after("count_holiday_after_leave_period");
                }

                if (!Schema::hasColumn("leave_types", "count_holiday_as_leave_between_days")) {
                    $table->smallInteger("count_holiday_as_leave_between_days")->nullable()->after("count_holiday_between_leave_period");
                }



                if (!Schema::hasColumn("leave_types", "count_weekend_for_leave_period")) {
                    $table->enum("count_weekend_for_leave_period", ["count_as_leave", "dont_count_as_leave"])->nullable()->after("count_holiday_as_leave_between_days");
                }

                if (!Schema::hasColumn("leave_types", "count_weekend_before_leave_period")) {
                    $table->boolean("count_weekend_before_leave_period")->nullable()->after("count_weekend_for_leave_period");
                }

                if (!Schema::hasColumn("leave_types", "count_weekend_as_leave_before_days")) {
                    $table->smallInteger("count_weekend_as_leave_before_days")->nullable()->after("count_weekend_before_leave_period");
                }

                if (!Schema::hasColumn("leave_types", "count_weekend_after_leave_period")) {
                    $table->boolean("count_weekend_after_leave_period")->nullable()->after("count_weekend_as_leave_before_days");
                }

                if (!Schema::hasColumn("leave_types", "count_weekend_between_leave_period")) {
                    $table->boolean("count_weekend_between_leave_period")->nullable()->after("count_weekend_after_leave_period");
                }

                if (!Schema::hasColumn("leave_types", "count_weekend_as_leave_between_days")) {
                    $table->smallInteger("count_weekend_as_leave_between_days")->nullable()->after("count_weekend_between_leave_period");
                }
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
        if (Schema::hasTable('leave_types')) {
            Schema::table('leave_types', function (Blueprint $table) {
                if (Schema::hasColumn("leave_types", "status")) {
                    $table->dropColumn("status");
                }

                if (Schema::hasColumn("leave_types", "auth_person")) {
                    $table->dropColumn("auth_person")->nullable();
                }

                if (Schema::hasColumn("leave_types", "leave_exceeds_days")) {
                    $table->dropColumn("leave_exceeds_days");
                }

                if (Schema::hasColumn("leave_types", "count_holiday_for_leave_period")) {
                    $table->dropColumn("count_holiday_for_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_holiday_before_leave_period")) {
                    $table->dropColumn("count_holiday_before_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_holiday_as_leave_before_days")) {
                    $table->dropColumn("count_holiday_as_leave_before_days");
                }

                if (Schema::hasColumn("leave_types", "count_holiday_after_leave_period")) {
                    $table->dropColumn("count_holiday_after_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_holiday_between_leave_period")) {
                    $table->dropColumn("count_holiday_between_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_holiday_as_leave_between_days")) {
                    $table->dropColumn("count_holiday_as_leave_between_days");
                }



                if (Schema::hasColumn("leave_types", "count_weekend_for_leave_period")) {
                    $table->dropColumn("count_weekend_for_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_weekend_before_leave_period")) {
                    $table->dropColumn("count_weekend_before_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_weekend_as_leave_before_days")) {
                    $table->dropColumn("count_weekend_as_leave_before_days");
                }

                if (Schema::hasColumn("leave_types", "count_weekend_after_leave_period")) {
                    $table->dropColumn("count_weekend_after_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_weekend_between_leave_period")) {
                    $table->dropColumn("count_weekend_between_leave_period");
                }

                if (Schema::hasColumn("leave_types", "count_weekend_as_leave_between_days")) {
                    $table->dropColumn("count_weekend_as_leave_between_days");
                }
            });
        }
    }
}