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
        Schema::create('products', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('registrant_company_id');
            $table->unsignedBigInteger('formulation_type_id')->nullable();
            $table->string('registration_no', 30)->unique()->nullable();
            $table->enum('status', ['pending', 'active', 'expired', 'cancelled'])->default('pending');
            $table->date('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('registrant_company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('restrict');

            $table->foreign('formulation_type_id')
                ->references('id')
                ->on('formulation_types')
                ->onDelete('set null');

            $table->index('registrant_company_id');
            $table->index('status');
            $table->index('registration_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
