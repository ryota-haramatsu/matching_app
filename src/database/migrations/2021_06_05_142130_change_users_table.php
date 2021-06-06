<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_id')->nullable()->after('id')->comment('add for socialite');
            $table->string('provider_name')->nullable()->after('provider_id')->comment('add for socialite');
            $table->string('nickname')->nullable()->after('name')->comment('add for socialite');
            $table->string('avatar')->nullable()->after('email')->comment('add for socialite');
            $table->string('email')->nullable()->change()->comment('change to nullable for socialite'); // socialiteログインの時にnullの場合があるため変更
            $table->string('password')->nullable()->change()->comment('change to nullable for socialite'); // socialiteログインの時にnullの場合があるため変更
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 通常のusersテーブルにする
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provider_id', 'provider_name', 'nickname', 'avatar']);
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
}
