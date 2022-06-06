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
        Schema::create('paper_presenteds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id');
            $table->string('paper_title');
            $table->string('presenters');
            $table->string('paper_title_2');
            $table->string('venue');
            $table->date('date');
            $table->string('organizer');
            $table->string('conference_type')->nullable();
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
        Schema::dropIfExists('paper_presenteds');
    }
};
