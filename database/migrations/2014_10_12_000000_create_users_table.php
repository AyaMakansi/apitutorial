<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->enum('type', ['Admin', 'Professor','Student']);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('user')->insert([
            'user_name'=>'root',
            'email'=>'root@root.com',
            'password'=>Hash::make('root1234'),
            'type'=>'Admin' 
        ]);
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
};
