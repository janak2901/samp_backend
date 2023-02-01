<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('first_name', 30)->nullable();
                $table->string("display_name")->nullable();
                $table->string('middle_name', 30)->nullable();
                $table->string('last_name', 30)->nullable();
                $table->string('email', 50)->nullable();
                $table->boolean('is_valid_email')->default(0);
                $table->boolean('is_check_email')->default(0);
                $table->string('password', 245)->nullable();
                $table->string('otp', 245)->nullable();
                $table->dateTime('otp_time')->nullable();
                $table->dateTime('invitation_expiry_date')->nullable();
                $table->string('unique_id', 11)->nullable();
                $table->boolean('is_active')->default(0);
                $table->boolean("is_invite")->default(0);
                $table->boolean('cancel_invitation')->default(0);
                $table->boolean("onboarded")->default(0);
                $table->enum('gender', ["male", "female"])->nullable();
                $table->date('birth_date')->nullable();
                $table->date('join_date')->nullable();
                $table->string('profile_pic', 245)->nullable();
                $table->string('phone_code', 7)->nullable();
                $table->string('phone_no', 20)->nullable();
                $table->string("house_number")->nullable();
                $table->longText("street_address")->nullable();
                $table->string("land_mark")->nullable();
                $table->unsignedBigInteger("city")->nullable();
                $table->unsignedBigInteger("state")->nullable();
                $table->unsignedBigInteger("country")->nullable();
                $table->string("zipcode")->nullable();
                $table->foreign("city")->references('id')->on("cities")->onDelete('cascade')->onUpdate('cascade');
                $table->foreign("state")->references('id')->on("states")->onDelete('cascade')->onUpdate('cascade');
                $table->foreign("country")->references('id')->on("countries")->onDelete('cascade')->onUpdate('cascade');
                $table->string('remember_token', 255)->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}