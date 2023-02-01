<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('userss')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('role_id')->nullable();
                $table->foreign("role_id")->references('id')->on("roles")->onDelete('cascade')->onUpdate('cascade');
                $table->string('first_name', 30)->nullable();
                $table->string('middle_name', 30)->nullable();
                $table->string('last_name', 30)->nullable();
                $table->string('email', 50)->nullable();
                $table->string('password', 245)->nullable();
                $table->string('salary', 245)->nullable();
                $table->string('phone_no', 20)->nullable();
                $table->enum('gender', ["male", "female"])->nullable();
                $table->enum('marital_status', ['married', 'widowed', 'separated', 'divorced', 'single'])->nullable();
                $table->date('birth_date')->nullable();
                $table->date('join_date')->nullable();
                $table->string('profile_pic', 245)->nullable();
                $table->string('signature', 245)->nullable();
                $table->string("house_number")->nullable();
                $table->longText("street_address")->nullable();
                $table->string("land_mark")->nullable();
                $table->unsignedBigInteger("city")->nullable();
                $table->unsignedBigInteger("state")->nullable();
                $table->unsignedBigInteger("country")->nullable();
                $table->string("zipcode")->nullable();
                $table->boolean("is_delete")->default(0);
                $table->foreign("city")->references('id')->on("cities")->onDelete('cascade')->onUpdate('cascade');
                $table->foreign("state")->references('id')->on("states")->onDelete('cascade')->onUpdate('cascade');
                $table->foreign("country")->references('id')->on("countries")->onDelete('cascade')->onUpdate('cascade');
                $table->string('remember_token', 255)->nullable();
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
        Schema::dropIfExists('userss');
    }
}
