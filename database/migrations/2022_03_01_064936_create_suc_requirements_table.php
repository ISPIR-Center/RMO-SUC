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
        Schema::create('suc_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_id')->constrained()->onDelete('cascade');
            $table->string('suc_completed_file')->nullable();
            $table->string('suc_contract_file')->nullable();
            $table->string('suc_contract_name')->nullable();
            $table->string('suc_contract_from')->nullable();
            $table->string('suc_contract_to')->nullable();
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
        Schema::dropIfExists('suc_requirements');
    }
};
