<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premises', function (Blueprint $table) {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('name', 255);
            $table->string('license_no', 50)->nullable()->unique();
            $table->unsignedBigInteger('owner_company_id')->nullable();
            $table->string('address_line1', 255);
            $table->string('address_line2', 255)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('state', 30)->nullable();
            $table->string('pic_name', 255)->nullable();
            $table->string('pic_phone', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('owner_company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('set null');

            $table->index('state');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('premises');
    }
};
