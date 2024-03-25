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
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->foreignid('category_id')->constrained()->onDelete('cascade');
            $table->foreignid('job_type_id')->constrained()->onDelete('cascade');
            $table->foreignid('vacancy');
            $table->foreignid('salary')->nullable();
            $table->string('location');
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->text('responsibility')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('keywords')->nullable();
            $table->string('experience');
            $table->string('company_name');
            $table->string('company_location')->nullable();
            $table->string('company_website')->nullable();
            $table->integer('is_featured')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
