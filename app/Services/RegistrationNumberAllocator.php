<?php

namespace App\Services;

use App\Enums\ProductStatus;
use App\Models\Certificate;
use App\Models\Product;
use App\Models\RegistrationApplication;

class RegistrationNumberAllocator
{
    public function allocate(RegistrationApplication $application): void
    {
        $registrationNo = $this->generateRegistrationNo();

        if ($application->product_id) {
            // Update the existing product
            $product = $application->product;
            $product->status          = ProductStatus::Active;
            $product->registration_no = $registrationNo;
            $product->expires_at      = now()->addYears(5);
            $product->save();
        } else {
            // Create a new product as a placeholder
            $product = Product::create([
                'name'                  => $application->application_no,
                'registrant_company_id' => $application->applicant_company_id,
                'status'                => ProductStatus::Active,
                'registration_no'       => $registrationNo,
                'expires_at'            => now()->addYears(5),
            ]);
        }

        Certificate::create([
            'application_id'  => $application->id,
            'registration_no' => $registrationNo,
            'issued_at'       => now(),
            'expires_at'      => now()->addYears(5),
            'pdf_path'        => null,
        ]);
    }

    private function generateRegistrationNo(): string
    {
        $year     = now()->year;
        $sequence = Certificate::count() + 1;

        return sprintf('MP-%d-%05d', $year, $sequence);
    }
}
