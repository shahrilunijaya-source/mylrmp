<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_findings', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('inspection_id');
            $table->enum('severity', ['minor', 'major']);
            $table->string('category', 100);
            $table->unsignedBigInteger('linked_product_id')->nullable();
            $table->text('description');
            $table->timestamps();

            $table->foreign('inspection_id')
                ->references('id')
                ->on('inspections')
                ->onDelete('cascade');

            $table->foreign('linked_product_id')
                ->references('id')
                ->on('products')
                ->onDelete('set null');

            $table->index('inspection_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_findings');
    }
};
