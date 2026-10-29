<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fire_report_id')
                ->constrained('fire_reports')
                ->restrictOnDelete();

            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->text('note');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_reviews');
    }
};
