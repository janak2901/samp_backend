<?php

use Centroall\Helper\Utils\CommonUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table(
                'users',
                function (Blueprint $table) {
                    if (!Schema::hasColumn('users', 'marital_status')) {
                        $table->enum('marital_status', ['married', 'widowed', 'separated', 'divorced', 'single'])->nullable()->after('gender');
                    }
                    if (!Schema::hasColumn('users', 'archived_at')) {
                        $table->timestamp('archived_at')->nullable()->after('updated_at');
                    }
                }
            );
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
            Schema::table(
                'users',
                function (Blueprint $table) {
                    if (Schema::hasColumn('users', 'marital_status')) {
                        $table->dropColumn('marital_status');
                    }
                    if (Schema::hasColumn('users', 'archived_at')) {
                        $table->dropColumn('archived_at');
                    }
                }
            );
        }
    }
}