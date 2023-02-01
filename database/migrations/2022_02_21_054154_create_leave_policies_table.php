<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('leave_policies')) {
            if (Schema::hasColumn('leave_policies', 'leave_type_name')) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                Schema::drop('leave_types');
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }

        if (!(Schema::hasTable('leave_policies'))) {
            Schema::create('leave_policies', function (Blueprint $table) {
                $table->id();
                $table->string('leave_policy_name', 245);
                $table->text('description')->nullable();
                $table->string('effective_after')->nullable();
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
        Schema::dropIfExists('leave_policies');
    }
}