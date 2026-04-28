<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_checklist_responses', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('inspection_id');
            $table->unsignedBigInteger('checklist_item_id');
            $table->enum('answer', ['Yes', 'No', 'NA'])->default('NA');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['inspection_id', 'checklist_item_id'], 'icr_inspection_item_unique');

            $table->foreign('inspection_id')
                ->references('id')
                ->on('inspections')
                ->onDelete('cascade');

            $table->foreign('checklist_item_id')
                ->references('id')
                ->on('inspection_checklist_items')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_checklist_responses');
    }
};
