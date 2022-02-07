<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashcardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashcard_user', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('flashcard_id');
            $table->enum('status',['Not Answered', 'Correct', 'Incorrect'])->default('Not Answered');
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
        Schema::dropIfExists('flashcard_user');
    }
}
