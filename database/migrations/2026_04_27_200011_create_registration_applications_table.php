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
        Schema::create('registration_applications', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string('application_no', 20)->unique();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('applicant_user_id');
            $table->unsignedBigInteger('applicant_company_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->enum('current_stage', [
                'draft',
                'submitted',
                'tech_review',
                'label_review',
                'decision',
                'approved',
                'rejected',
                'needs_revision',
            ])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('set null');

            $table->foreign('subcategory_id')
                ->references('id')
                ->on('product_subcategories')
                ->onDelete('set null');

            $table->foreign('applicant_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            $table->foreign('applicant_company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('restrict');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('set null');

            $table->index('applicant_user_id');
            $table->index('applicant_company_id');
            $table->index('current_stage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_applications');
    }
};
