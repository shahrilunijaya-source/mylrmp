<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_finding_attachments', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('finding_id');
            $table->string('path', 500);
            $table->string('mime', 100)->nullable();
            $table->unsignedInteger('size_bytes')->nullable();
            $table->timestamps();

            $table->foreign('finding_id')
                ->references('id')
                ->on('inspection_findings')
                ->onDelete('cascade');

            $table->index('finding_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_finding_attachments');
    }
};
