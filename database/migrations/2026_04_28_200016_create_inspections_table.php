<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('inspection_no', 20)->unique();
            $table->morphs('target');           // target_type, target_id
            $table->unsignedBigInteger('inspector_id');
            $table->date('scheduled_for');
            $table->timestamp('conducted_at')->nullable();
            $table->enum('status', [
                'scheduled',
                'in_progress',
                'compliant',
                'minor_nc',
                'major_nc',
                'cancelled',
            ])->default('scheduled');
            $table->text('summary')->nullable();
            $table->string('report_pdf_path', 500)->nullable();
            $table->string('notice_pdf_path', 500)->nullable();
            $table->date('notice_deadline')->nullable();
            $table->timestamps();

            $table->foreign('inspector_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->index('status');
            $table->index('scheduled_for');
            $table->index('inspector_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
