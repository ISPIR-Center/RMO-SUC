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
        Schema::create('journal_citeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id');
            $table->string('journal_title');
            $table->string('publication');
            $table->string('publisher');
            $table->string('authors');
            $table->date('year_published');
            $table->string('link');
            $table->string('vol_no')->nullable();
            $table->string('pages')->nullable();
            $table->string('file_1')->nullable();
            $table->string('file_2')->nullable();
            $table->string('file_3')->nullable();
            $table->string('file_4')->nullable();
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
        Schema::dropIfExists('journal_citeds');
    }
};
