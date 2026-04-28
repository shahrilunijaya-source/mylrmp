<?php

namespace Database\Seeders;

use App\Enums\MalaysianState;
use App\Models\Premises;
use Illuminate\Database\Seeder;

class DemoPremisesSeeder extends Seeder
{
    public function run(): void
    {
        $premises = [
            ['name' => 'Kedai Racun Tanaman Ah Fong',     'license_no' => 'DOA-JHR-2024-00101', 'address_line1' => 'No. 12, Jalan Bestari 3',       'district' => 'Johor Bahru',   'state' => MalaysianState::Johor,       'postcode' => '81300', 'pic_name' => 'Tan Ah Fong',       'pic_phone' => '017-3001122'],
            ['name' => 'Pertanian Maju Sdn Bhd',           'license_no' => 'DOA-JHR-2024-00118', 'address_line1' => 'Lot 45, Kawasan Perindustrian',  'district' => 'Kulai',         'state' => MalaysianState::Johor,       'postcode' => '81000', 'pic_name' => 'Mohd Rizal',        'pic_phone' => '019-7788990'],
            ['name' => 'Kedai Racun Makanan Yusuf & Sons', 'license_no' => 'DOA-SEL-2023-00215', 'address_line1' => 'No. 88, Jalan Meru',             'district' => 'Klang',         'state' => MalaysianState::Selangor,   'postcode' => '41050', 'pic_name' => 'Yusuf bin Hassan',  'pic_phone' => '012-4455667'],
            ['name' => 'Agro Supply Centre Shah Alam',     'license_no' => 'DOA-SEL-2024-00033', 'address_line1' => 'B-1-5, Jalan Plumbum',           'district' => 'Shah Alam',    'state' => MalaysianState::Selangor,   'postcode' => '40150', 'pic_name' => 'Lim Siew Peng',    'pic_phone' => '016-2233445'],
            ['name' => 'Ladang Bestari Agro Store',        'license_no' => 'DOA-PPG-2022-00077', 'address_line1' => '45, Lebuh Melayu',               'district' => 'Georgetown',    'state' => MalaysianState::PulauPinang,'postcode' => '10000', 'pic_name' => 'Ahmad Kamal',      'pic_phone' => '011-3344556'],
            ['name' => 'Kedai Racun Kim Huat',             'license_no' => 'DOA-PPG-2023-00092', 'address_line1' => 'No. 3, Jalan Butterworth',       'district' => 'Seberang Prai', 'state' => MalaysianState::PulauPinang,'postcode' => '12100', 'pic_name' => 'Kim Huat Ng',      'pic_phone' => '04-3981234'],
            ['name' => 'Pembekal Pertanian Ipoh Sdn Bhd',  'license_no' => 'DOA-PRK-2024-00051', 'address_line1' => 'Jalan Sultan Iskandar',          'district' => 'Ipoh',          'state' => MalaysianState::Perak,      'postcode' => '30000', 'pic_name' => 'Radziah binti Ali', 'pic_phone' => '05-5067890'],
            ['name' => 'Green Farm Supplies Kuching',      'license_no' => 'DOA-SWK-2023-00141', 'address_line1' => 'Jalan Simpang Tiga',             'district' => 'Kuching',       'state' => MalaysianState::Sarawak,    'postcode' => '93250', 'pic_name' => 'Dayangku Nuriah',  'pic_phone' => '082-431567'],
        ];

        foreach ($premises as $p) {
            Premises::firstOrCreate(['license_no' => $p['license_no']], array_merge($p, ['is_active' => true]));
        }
    }
}
