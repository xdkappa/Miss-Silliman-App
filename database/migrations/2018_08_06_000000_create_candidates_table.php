<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->string('C_FName'); //Candidate's First Name
            $table->string('C_MName'); //Candidate's Middle Name
            $table->string('C_LName'); //Candidate's Last Name
            $table->integer('C_College')->unsigned(); //Candidate's College
            $table->string('C_YearLevel'); //Candidate's Year Level
            $table->string('C_SY'); //Candidate's SY attended
            $table->string('C_isTop'); //Candidate's ranking
            $table->string('C_Number'); //Candidate's number
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
        Schema::dropIfExists('candidates');
    }
}
