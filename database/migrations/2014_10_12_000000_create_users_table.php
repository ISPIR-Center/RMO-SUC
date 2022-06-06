<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->string('campus')->nullable();
            $table->string('college')->nullable();
            $table->string('contact')->nullable();
           
            $table->string('type')->nullable();
            $table->string('is_active', 1)->default('1');
            $table->string('office_name')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('employee_type')->nullable();
            $table->string('suffix')->nullable();
            $table->string('lastname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('firstname')->nullable();
            $table->string('fullname')->nullable();
            $table->string('gender')->nullable();
            $table->integer('research_no')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
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
