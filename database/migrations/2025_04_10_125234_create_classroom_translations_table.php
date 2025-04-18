<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classroom_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('classroom_id')->unsigned();
            $table->string('locale')->index();
            $table->string('classroom')->required()->unique();
            // $table->text('notes')->nullable();        
            $table->unique(['classroom_id', 'locale']);
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_translations');
    }
};
