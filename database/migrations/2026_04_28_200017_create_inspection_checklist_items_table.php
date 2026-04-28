<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_checklist_items', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('code', 20)->unique();
            $table->string('category', 50);
            $table->string('prompt_en', 500);
            $table->string('prompt_ms', 500);
            $table->enum('applies_to', ['Premises', 'Company', 'Both'])->default('Both');
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['applies_to', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_checklist_items');
    }
};
