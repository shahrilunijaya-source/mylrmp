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
        Schema::create('certificates', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('application_id')->unique();
            $table->string('registration_no', 30)->unique();
            $table->timestamp('issued_at');
            $table->date('expires_at');
            $table->string('pdf_path')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();

            $table->foreign('application_id')
                ->references('id')
                ->on('registration_applications')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
