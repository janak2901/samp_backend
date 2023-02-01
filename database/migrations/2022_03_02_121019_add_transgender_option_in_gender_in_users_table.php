<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTransgenderOptionInGenderInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'gender')) {
                    DB::statement("ALTER TABLE `users` CHANGE `gender` `gender` ENUM('male','female','transgender') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'gender')) {
                    DB::statement("ALTER TABLE `users` CHANGE `gender` `gender` ENUM('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
                }
            });
        }
    }
}