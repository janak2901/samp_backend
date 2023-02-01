<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTrackerPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "Migrating in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "Migration name --> 2022_02_08_092453_update_tracker_policies_table");

        if (Schema::hasTable('tracker_policies')) {
            //Schema::dropIfExists('tracker_policies');

            Schema::table('tracker_policies', function (Blueprint $table) {
                if (Schema::hasColumn('tracker_policies', 'name')) {
                    $table->renameColumn('name', 'policy_name');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> Name field updated to policy name." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> Name field not found." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'method')) {
                    $table->enum('method', ['Centroall Tracker', 'Centroall Web Clock In/Out', 'Biometeric Machine'])->after('id');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> method field added in tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> method field already exists." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'mouse_click')) {
                    $table->integer('mouse_click')->nullable()->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click field nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'keyboard_key_press')) {
                    $table->integer('keyboard_key_press')->nullable()->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_key_press field nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_key_press field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'mouse_click_weightage')) {
                    $table->integer('mouse_click_weightage')->nullable()->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click_weightage field nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click_weightage field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'keyboard_click_weightage')) {
                    $table->integer('keyboard_click_weightage')->nullable()->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_click_weightage field nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_click_weightage field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'minimum_productivity_for_overtime_eligibility')) {
                    $table->integer('minimum_productivity_for_overtime_eligibility')->nullable()->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_for_overtime_eligibility field nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_for_overtime_eligibility field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'status')) {
                    $table->boolean('status')->default(0)->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> status field default value 0 changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> status field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'is_allowed_screen_short')) {
                    $table->dropColumn('is_allowed_screen_short');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> is_allowed_screen_short field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> is_allowed_screen_short field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'ss_start_time')) {
                    $table->dropColumn('ss_start_time');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_start_time field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_start_time field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'ss_end_time')) {
                    $table->dropColumn('ss_end_time');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_end_time field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_end_time field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'ideal_mouse_click')) {
                    $table->dropColumn('ideal_mouse_click');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_mouse_click field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_mouse_click field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'ideal_keyboard_key_press')) {
                    $table->dropColumn('ideal_keyboard_key_press');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_keyboard_key_press field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_keyboard_key_press field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'minimum_productivity_per_activity')) {
                    $table->dropColumn('minimum_productivity_per_activity');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_per_activity field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_per_activity field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'productivity_count_type')) {
                    $table->dropColumn('productivity_count_type');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> productivity_count_type field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> productivity_count_type field not found." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'ignore_out_punch_mins')) {
                    $table->integer('ignore_out_punch_mins')->after('name');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ignore_out_punch_mins field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ignore_out_punch_mins field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'out_punch_missing_action')) {
                    $table->enum('out_punch_missing_action', ['Ignore Last In Punch', 'Add Last Punch According To Shift Time'])->after('ignore_out_punch_mins');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> out_punch_missing_action field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> out_punch_missing_action field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'highlight_missing_punch_entry')) {
                    $table->boolean('highlight_missing_punch_entry')->default(0)->after('out_punch_missing_action');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> highlight_missing_punch_entry field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> highlight_missing_punch_entry field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'min_working_hrs_for_full_day')) {
                    $table->integer('min_working_hrs_for_full_day')->nullable()->after('highlight_missing_punch_entry');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_full_day field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_full_day field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'min_working_mins_for_full_day')) {
                    $table->integer('min_working_mins_for_full_day')->nullable()->after('min_working_hrs_for_full_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_full_day field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_full_day field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'min_working_hrs_for_half_day')) {
                    $table->integer('min_working_hrs_for_half_day')->nullable()->after('min_working_mins_for_full_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_half_day field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_half_day field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'min_working_mins_for_half_day')) {
                    $table->integer('min_working_mins_for_half_day')->nullable()->after('min_working_hrs_for_half_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_half_day field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_half_day field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'allow_screenshot')) {
                    $table->boolean('allow_screenshot')->default(0)->after('min_working_mins_for_half_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> allow_screenshot field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> allow_screenshot field already exists." . date('Y-m-d h:i A'));
                }

                if (!Schema::hasColumn('tracker_policies', 'screenshot_capturing_interval')) {
                    $table->integer('screenshot_capturing_interval')->nullable()->after('allow_screenshot');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> screenshot_capturing_interval field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> screenshot_capturing_interval field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'prod_criteria')) {
                    $table->boolean('prod_criteria')->default(0)->after('allow_screenshot');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> prod_criteria field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> prod_criteria field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'late_coming_early_going')) {
                    $table->boolean('late_coming_early_going')->default(0)->after('prod_criteria');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_early_going field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_early_going field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'set_ideal_prod_criteria')) {
                    $table->integer('set_ideal_prod_criteria')->nullable()->after('prod_criteria');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> set_ideal_prod_criteria field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> set_ideal_prod_criteria field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'late_coming_after_mins')) {
                    $table->integer('late_coming_after_mins')->nullable()->after('set_ideal_prod_criteria');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_after_mins field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_after_mins field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'early_going_before_mins')) {
                    $table->integer('early_going_before_mins')->nullable()->after('late_coming_after_mins');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> early_going_before_mins field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> early_going_before_mins field already exists." . date('Y-m-d h:i A'));
                }

                if (!Schema::hasColumn('tracker_policies', 'default_memo_time')) {
                    $table->integer('default_memo_time')->nullable()->after('early_going_before_mins');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> default_memo_time field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> default_memo_time field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('status');
                    $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> created_by field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> created_by field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'updated_by')) {
                    $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
                    $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> updated_by field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> updated_by field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'deleted_by')) {
                    $table->unsignedBigInteger('deleted_by')->nullable()->after('updated_by');
                    $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> deleted_by field added." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> deleted_by field already exists." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> Tracker policies table not found." . date('Y-m-d h:i A'));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CommonUtil::logRecorder('update-db-schema-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "Migrating rollbacking in database --> " . DB::connection()->getDatabaseName() . ' at ' . date('Y-m-d h:i A'));
        CommonUtil::logRecorder('update-db-schema-logs', 'migrate-rollback-logs-' . date('Y-m-d') . '', "Migration name --> 2022_02_08_092453_update_tracker_policies_table");

        if (Schema::hasTable('tracker_policies')) {
            //Schema::dropIfExists('tracker_policies');

            Schema::table('tracker_policies', function (Blueprint $table) {
                if (!Schema::hasColumn('tracker_policies', 'policy_name')) {
                    $table->renameColumn('policy_name', 'name');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> Policy Name field updated to name." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> Policy Name field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'method')) {
                    $table->dropColumn('method');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> method field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> method field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'mouse_click')) {
                    $table->integer('mouse_click')->nullable(false)->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click field not nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'keyboard_key_press')) {
                    $table->integer('keyboard_key_press')->nullable(false)->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_key_press field not nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_key_press field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'mouse_click_weightage')) {
                    $table->integer('mouse_click_weightage')->nullable(false)->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click_weightage field not nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> mouse_click_weightage field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'keyboard_click_weightage')) {
                    $table->integer('keyboard_click_weightage')->nullable(false)->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_click_weightage field not nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> keyboard_click_weightage field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'minimum_productivity_for_overtime_eligibility')) {
                    $table->integer('minimum_productivity_for_overtime_eligibility')->nullable(false)->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_for_overtime_eligibility field not nullable changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_for_overtime_eligibility field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'status')) {
                    $table->boolean('status')->default(1)->change();
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> status field default value 1 changed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> status field not found." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'is_allowed_screen_short')) {
                    $table->boolean('is_allowed_screen_short');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> is_allowed_screen_short field added from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> is_allowed_screen_short field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'ss_start_time')) {
                    $table->integer('ss_start_time')->after('name');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_start_time field added from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_start_time field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'ss_end_time')) {
                    $table->integer('ss_end_time')->after('ss_start_time');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_end_time field added from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ss_end_time field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'ideal_mouse_click')) {
                    $table->integer('ideal_mouse_click')->after('ss_end_time');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_mouse_click field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_mouse_click field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'ideal_keyboard_key_press')) {
                    $table->integer('ideal_keyboard_key_press')->after('ideal_mouse_click');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_keyboard_key_press field added in tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ideal_keyboard_key_press field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'minimum_productivity_per_activity')) {
                    $table->integer('minimum_productivity_per_activity')->after('ideal_keyboard_key_press');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_per_activity field added in tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> minimum_productivity_per_activity field already exists." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'productivity_count_type')) {
                    $table->integer('productivity_count_type')->after('minimum_productivity_per_activity');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> productivity_count_type field added in tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> productivity_count_type field already exists." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'ignore_out_punch_mins')) {
                    $table->dropColumn('ignore_out_punch_mins')->after('name');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ignore_out_punch_mins field removed." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> ignore_out_punch_mins field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'out_punch_missing_action')) {
                    $table->dropColumn('out_punch_missing_action');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> out_punch_missing_action field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> out_punch_missing_action field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'highlight_missing_punch_entry')) {
                    $table->dropColumn('highlight_missing_punch_entry');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> highlight_missing_punch_entry field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> highlight_missing_punch_entry field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'min_working_hrs_for_full_day')) {
                    $table->dropColumn('min_working_hrs_for_full_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_full_day field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_full_day field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'min_working_mins_for_full_day')) {
                    $table->dropColumn('min_working_mins_for_full_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_full_day field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_full_day field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'min_working_hrs_for_half_day')) {
                    $table->dropColumn('min_working_hrs_for_half_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_half_day field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_hrs_for_half_day field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'min_working_mins_for_half_day')) {
                    $table->dropColumn('min_working_mins_for_half_day');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_half_day field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> min_working_mins_for_half_day field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'allow_screenshot')) {
                    $table->dropColumn('allow_screenshot');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> allow_screenshot field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> allow_screenshot field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'prod_criteria')) {
                    $table->dropColumn('prod_criteria');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> prod_criteria field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> prod_criteria field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'late_coming_early_going')) {
                    $table->dropColumn('late_coming_early_going');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_early_going field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_early_going field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'set_ideal_prod_criteria')) {
                    $table->dropColumn('set_ideal_prod_criteria')->nullable()->after('prod_criteria');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> set_ideal_prod_criteria field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> set_ideal_prod_criteria field not found." . date('Y-m-d h:i A'));
                }


                if (Schema::hasColumn('tracker_policies', 'late_coming_after_mins')) {
                    $table->dropColumn('late_coming_after_mins');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_after_mins field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_coming_after_mins field not found." . date('Y-m-d h:i A'));
                }


                if (!Schema::hasColumn('tracker_policies', 'late_going_before_mins')) {
                    $table->dropColumn('late_going_before_mins');

                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_going_before_mins field removed from tracker policies table." . date('Y-m-d h:i A'));
                } else {
                    CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> late_going_before_mins field not found." . date('Y-m-d h:i A'));
                }
            });
        } else {
            CommonUtil::logRecorder('update-db-schema-logs', 'update-db-schema-logs-' . date('Y-m-d') . '', "2022_02_08_092453_update_tracker_policies_table --> Tracker policies table not found." . date('Y-m-d h:i A'));
        }
    }
}
