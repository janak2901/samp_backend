<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonTechnicalEmployeePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('non_technical_employee_policies'))) {

            Schema::create('non_technical_employee_policies', function (Blueprint $table) {
                $table->id();
                $table->string("slug", 50);
                $table->string("name", 50);
                $table->text("description");
                $table->enum("is_allowed_overtime", [1, 0]);
                $table->enum("is_allowed_screen_shot", [1, 0]);
                $table->enum("is_allowed_time_duration", [1, 0]);
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
        Schema::dropIfExists('non_technical_employee_policies');
    }
}
