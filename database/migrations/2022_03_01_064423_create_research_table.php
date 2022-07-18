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
        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->string('type')->nullable();//program, project, research
            $table->string('college')->nullable();
            $table->string('leader')->nullable();
            $table->string('leader_id')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('location_from')->nullable()->default('Faculty');//faculty,college,pchair,rmo
            $table->string('location_to')->default('Program Chair');
            $table->char('is_internally_funded', 1)->default('0');
            $table->string('is_presented', 1)->nullable();
            $table->string('is_published', 1)->nullable();
            $table->string('is_utilized', 1)->nullable();
            $table->string('is_patented', 1)->nullable();
            $table->date('date_completed')->nullable();
            $table->date('date_published')->nullable();
            $table->date('date_utilized')->nullable();
            $table->date('date_presented')->nullable();
            $table->date('date_patented')->nullable();
            $table->string('year_completed')->nullable();
            $table->string('year_published')->nullable();
            $table->string('year_presented')->nullable();
            $table->string('year_utilized')->nullable();
            $table->string('year_patented')->nullable();
            $table->string('year_journa_cited')->nullable();
            $table->string('year_book_cited')->nullable();
            $table->string('discipline_covered')->nullable();
            $table->string('deliverables')->nullable();
            $table->string('program_component')->nullable();
            $table->string('budget')->nullable();
            $table->string('university_research_agenda')->nullable();
            $table->string('completed_file')->nullable();
            $table->string('partner_contract_file')->nullable();
            $table->string('funding_agency')->nullable();
            $table->date('contract_from')->nullable();
            $table->date('contract_to')->nullable();
            $table->text('remarks')->nullable();
            $table->string('funded_on')->nullable();
            $table->string('budget_bsu')->nullable();
            $table->text('station')->default('1');
            $table->char('is_editable', 1)->default('0');
            $table->char('is_book_cited', 1)->default('0');
            $table->char('is_journal_cited', 1)->default('0');
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
        Schema::dropIfExists('research');
    }
};
