<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLeaveManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('employee_leave_managements'))) {
            Schema::create('employee_leave_managements', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("user_id");
                $table->unsignedBigInteger("leave_type_id");
                $table->enum("leave_status", ["Approve", "Pending","Reject"]);
                $table->unsignedBigInteger("approve_by")->nullable();
                $table->integer("start_slot")->nullable();
                $table->integer("end_slot")->nullable();
                $table->float("days")->nullable();
                $table->date("start_date")->nullable();
                $table->date("end_date")->nullable();
                $table->text("note")->nullable();
                $table->boolean("status")->nullable();
                $table->text("reject_reason")->nullable();
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->unsignedBigInteger('deleted_by')->nullable();
                $table->foreign("created_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("updated_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("deleted_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("user_id")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("leave_type_id")->references('id')->on("leave_types")->onUpdate('cascade')->onDelete('cascade');
                $table->foreign("approve_by")->references('id')->on("users")->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('employee_leave_management');
    }
}
