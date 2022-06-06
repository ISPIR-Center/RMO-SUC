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
        Schema::create('patenteds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id');
            $table->string('patent_no');
            $table->date('date_issue');
            $table->string('utilization');
            $table->string('product_name');
            $table->string('file_1')->nullable();
            $table->string('file_2')->nullable();
            $table->string('file_3')->nullable();
            $table->string('status');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('patenteds');
    }
};
