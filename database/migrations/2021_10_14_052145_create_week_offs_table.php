<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!(Schema::hasTable('week_offs'))) {

            Schema::create('week_offs', function (Blueprint $table) {
                $table->id();
                $table->string("slug", 50);
                $table->string("name", 50);
                $table->text("description");
                $table->enum("monday", [1, 0]);
                $table->enum("tuesday", [1, 0]);
                $table->enum("wednesday", [1, 0]);
                $table->enum("thursday", [1, 0]);
                $table->enum("friday", [1, 0]);
                $table->enum("saturday", [1, 0]);
                $table->enum("sunday", [1, 0]);
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
        Schema::dropIfExists('week_offs');
    }
}
