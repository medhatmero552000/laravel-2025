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
        // Create 'sections' table
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ststus');
            $table->bigInteger('grade_id');
            $table->bigInteger('classroom_id');

            $table->softDeletes();
            $table->timestamps();
        });

        // Create 'section_translations' table
        Schema::create('section_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('classroom_id');
            $table->string('locale')->index();
            $table->string('section_name')->unique(); // required by default
            // $table->text('notes')->nullable();
            $table->unique(['section_id','locale']);
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_translations');
        Schema::dropIfExists('sections');
    }
};
