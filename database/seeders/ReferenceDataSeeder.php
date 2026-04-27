<?php

namespace Database\Seeders;

use App\Models\ActiveIngredient;
use App\Models\Crop;
use App\Models\FormulationType;
use App\Models\Pest;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProductCategories();
        $this->seedProductSubcategories();
        $this->seedFormulationTypes();
        $this->seedCrops();
        $this->seedPests();
        $this->seedActiveIngredients();
    }

    private function seedProductCategories(): void
    {
        $categories = [
            ['name_ms' => 'Komoditi',                    'name_en' => 'Commodity',               'slug' => 'komoditi',                   'sort_order' => 1],
            ['name_ms' => 'Proprietari',                 'name_en' => 'Proprietary',              'slug' => 'proprietari',                'sort_order' => 2],
            ['name_ms' => 'Penggunaan Data',             'name_en' => 'Data Waiver',              'slug' => 'penggunaan-data',            'sort_order' => 3],
            ['name_ms' => 'Tukar Sumber',                'name_en' => 'Change of Source',         'slug' => 'tukar-sumber',               'sort_order' => 4],
            ['name_ms' => 'Perubahan Komposisi Minor',   'name_en' => 'Minor Composition Change', 'slug' => 'perubahan-komposisi-minor',  'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            ProductCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }

    private function seedProductSubcategories(): void
    {
        $subcategories = [
            ['name_ms' => 'Kimia',        'name_en' => 'Chemical',           'slug' => 'kimia',        'sort_order' => 1],
            ['name_ms' => 'Bio-Pestisid', 'name_en' => 'Bio-Pesticide',      'slug' => 'bio-pestisid', 'sort_order' => 2],
            ['name_ms' => 'Risiko Rendah','name_en' => 'Low Risk Pesticide', 'slug' => 'risiko-rendah','sort_order' => 3],
        ];

        foreach ($subcategories as $subcategory) {
            ProductSubcategory::firstOrCreate(
                ['slug' => $subcategory['slug']],
                $subcategory
            );
        }
    }

    private function seedFormulationTypes(): void
    {
        $formulations = [
            ['code' => 'EC', 'name_ms' => 'Cecair Emulsi',                  'name_en' => 'Emulsifiable Concentrate'],
            ['code' => 'SL', 'name_ms' => 'Cecair Boleh Larut',             'name_en' => 'Soluble Liquid'],
            ['code' => 'WP', 'name_ms' => 'Serbuk Boleh Basah',             'name_en' => 'Wettable Powder'],
            ['code' => 'GR', 'name_ms' => 'Granul',                         'name_en' => 'Granule'],
            ['code' => 'SC', 'name_ms' => 'Ampaian Pekat',                  'name_en' => 'Suspension Concentrate'],
            ['code' => 'WG', 'name_ms' => 'Granul Boleh Basah',             'name_en' => 'Water-Dispersible Granule'],
            ['code' => 'DP', 'name_ms' => 'Serbuk Habuk',                   'name_en' => 'Dustable Powder'],
            ['code' => 'UL', 'name_ms' => 'Cecair Ultra Rendah Isipadu',    'name_en' => 'Ultra-Low Volume Liquid'],
        ];

        foreach ($formulations as $formulation) {
            FormulationType::firstOrCreate(
                ['code' => $formulation['code']],
                $formulation
            );
        }
    }

    private function seedCrops(): void
    {
        $crops = [
            ['name_ms' => 'Padi',              'name_en' => 'Rice'],
            ['name_ms' => 'Getah',             'name_en' => 'Rubber'],
            ['name_ms' => 'Kelapa Sawit',      'name_en' => 'Oil Palm'],
            ['name_ms' => 'Sayur-sayuran',     'name_en' => 'Vegetables'],
            ['name_ms' => 'Koko',              'name_en' => 'Cocoa'],
            ['name_ms' => 'Pisang',            'name_en' => 'Banana'],
            ['name_ms' => 'Jagung',            'name_en' => 'Corn'],
            ['name_ms' => 'Pelbagai Tanaman',  'name_en' => 'Various Crops'],
        ];

        foreach ($crops as $crop) {
            Crop::firstOrCreate(
                ['name_en' => $crop['name_en']],
                $crop
            );
        }
    }

    private function seedPests(): void
    {
        $pests = [
            ['name_ms' => 'Tikus',               'name_en' => 'Rodents'],
            ['name_ms' => 'Serangga Tanah',      'name_en' => 'Soil Insects'],
            ['name_ms' => 'Kulat',               'name_en' => 'Fungi'],
            ['name_ms' => 'Rumpai',              'name_en' => 'Weeds'],
            ['name_ms' => 'Ulat Daun',           'name_en' => 'Leaf Caterpillars'],
            ['name_ms' => 'Serangga Penghisap',  'name_en' => 'Sucking Insects'],
            ['name_ms' => 'Kulat Akar',          'name_en' => 'Root Rot Fungi'],
            ['name_ms' => 'Pelbagai Perosak',    'name_en' => 'Various Pests'],
        ];

        foreach ($pests as $pest) {
            Pest::firstOrCreate(
                ['name_en' => $pest['name_en']],
                $pest
            );
        }
    }

    private function seedActiveIngredients(): void
    {
        $ingredients = [
            ['name' => 'Glyphosate',          'cas_no' => '1071-83-6',    'is_gazetted' => false],
            ['name' => 'Paraquat',            'cas_no' => '4685-14-7',    'is_gazetted' => true],
            ['name' => 'Cypermethrin',        'cas_no' => '52315-07-8',   'is_gazetted' => false],
            ['name' => 'Imidacloprid',        'cas_no' => '138261-41-3',  'is_gazetted' => false],
            ['name' => 'Chlorpyrifos',        'cas_no' => '2921-88-2',    'is_gazetted' => false],
            ['name' => 'Mancozeb',            'cas_no' => '8018-01-7',    'is_gazetted' => false],
            ['name' => 'Carbendazim',         'cas_no' => '10605-21-7',   'is_gazetted' => false],
            ['name' => 'Lambda-cyhalothrin',  'cas_no' => '91465-08-6',   'is_gazetted' => false],
            ['name' => 'Atrazine',            'cas_no' => '1912-24-9',    'is_gazetted' => false],
            ['name' => 'Fipronil',            'cas_no' => '120068-37-3',  'is_gazetted' => false],
            ['name' => 'Dimethoate',          'cas_no' => '60-51-5',      'is_gazetted' => false],
            ['name' => 'Malathion',           'cas_no' => '121-75-5',     'is_gazetted' => false],
            ['name' => 'Thiram',              'cas_no' => '137-26-8',     'is_gazetted' => false],
            ['name' => 'Captan',              'cas_no' => '133-06-2',     'is_gazetted' => false],
            ['name' => 'Methomyl',            'cas_no' => '16752-77-5',   'is_gazetted' => true],
            ['name' => 'Endosulfan',          'cas_no' => '115-29-7',     'is_gazetted' => true],
            ['name' => 'Monocrotophos',       'cas_no' => '6923-22-4',    'is_gazetted' => true],
            ['name' => 'Methyl Bromide',      'cas_no' => '74-83-9',      'is_gazetted' => true],
            ['name' => 'Aldrin',              'cas_no' => '309-00-2',     'is_gazetted' => true],
            ['name' => 'Dieldrin',            'cas_no' => '60-57-1',      'is_gazetted' => true],
            ['name' => 'Ethion',              'cas_no' => '563-12-2',     'is_gazetted' => false],
            ['name' => 'Profenofos',          'cas_no' => '41198-08-7',   'is_gazetted' => false],
            ['name' => 'Flufenacet',          'cas_no' => '142459-58-3',  'is_gazetted' => false],
            ['name' => 'Pendimethalin',       'cas_no' => '40487-42-1',   'is_gazetted' => false],
            ['name' => 'Tebuconazole',        'cas_no' => '107534-96-3',  'is_gazetted' => false],
            ['name' => 'Propiconazole',       'cas_no' => '60207-90-1',   'is_gazetted' => false],
            ['name' => 'Metalaxyl',           'cas_no' => '57837-19-1',   'is_gazetted' => false],
            ['name' => 'Iprodione',           'cas_no' => '36734-19-7',   'is_gazetted' => false],
            ['name' => 'Thiamethoxam',        'cas_no' => '153719-23-4',  'is_gazetted' => false],
            ['name' => 'Abamectin',           'cas_no' => '71751-41-2',   'is_gazetted' => false],
        ];

        foreach ($ingredients as $ingredient) {
            ActiveIngredient::firstOrCreate(
                ['cas_no' => $ingredient['cas_no']],
                $ingredient
            );
        }
    }
}
