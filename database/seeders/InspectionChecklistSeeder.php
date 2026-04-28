<?php

namespace Database\Seeders;

use App\Models\InspectionChecklistItem;
use Illuminate\Database\Seeder;

class InspectionChecklistSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Pelesenan
            ['code' => 'LIC-01', 'category' => 'Pelesenan', 'applies_to' => 'Premises', 'prompt_ms' => 'Lesen premis dipamerkan di tempat yang mudah dilihat.', 'prompt_en' => 'Premises license is displayed in a visible location.'],
            ['code' => 'LIC-02', 'category' => 'Pelesenan', 'applies_to' => 'Premises', 'prompt_ms' => 'Lesen premis masih dalam tempoh sah laku.', 'prompt_en' => 'Premises license is currently valid.'],
            ['code' => 'LIC-03', 'category' => 'Pelesenan', 'applies_to' => 'Both',    'prompt_ms' => 'Perakuan pendaftaran syarikat (SSM) masih sah.', 'prompt_en' => 'SSM company registration is valid.'],
            ['code' => 'LIC-04', 'category' => 'Pelesenan', 'applies_to' => 'Company', 'prompt_ms' => 'Sijil GMP atau amalan pengilangan yang baik dipamerkan.', 'prompt_en' => 'GMP certificate is displayed.'],

            // Penyimpanan
            ['code' => 'STR-01', 'category' => 'Penyimpanan', 'applies_to' => 'Both', 'prompt_ms' => 'Kawasan penyimpanan racun perosak dipisahkan daripada makanan dan barangan lain.', 'prompt_en' => 'Pesticide storage area is separated from food and other goods.'],
            ['code' => 'STR-02', 'category' => 'Penyimpanan', 'applies_to' => 'Both', 'prompt_ms' => 'Kawasan penyimpanan mempunyai pengudaraan yang mencukupi.', 'prompt_en' => 'Storage area has adequate ventilation.'],
            ['code' => 'STR-03', 'category' => 'Penyimpanan', 'applies_to' => 'Both', 'prompt_ms' => 'Alat pemadam api disediakan di kawasan penyimpanan.', 'prompt_en' => 'Fire extinguisher is available in the storage area.'],
            ['code' => 'STR-04', 'category' => 'Penyimpanan', 'applies_to' => 'Premises', 'prompt_ms' => 'Racun perosak disimpan mengikut kelas toksisiti.', 'prompt_en' => 'Pesticides are stored according to toxicity class.'],

            // Pelabelan
            ['code' => 'LBL-01', 'category' => 'Pelabelan', 'applies_to' => 'Both', 'prompt_ms' => 'Semua produk yang dijual / dikilang mempunyai label yang diluluskan oleh BKRPB.', 'prompt_en' => 'All products sold / manufactured have BKRPB-approved labels.'],
            ['code' => 'LBL-02', 'category' => 'Pelabelan', 'applies_to' => 'Both', 'prompt_ms' => 'Label produk mengandungi nombor pendaftaran yang sah.', 'prompt_en' => 'Product label contains a valid registration number.'],
            ['code' => 'LBL-03', 'category' => 'Pelabelan', 'applies_to' => 'Both', 'prompt_ms' => 'Label produk adalah dalam Bahasa Malaysia.', 'prompt_en' => 'Product label is in Bahasa Malaysia.'],
            ['code' => 'LBL-04', 'category' => 'Pelabelan', 'applies_to' => 'Premises', 'prompt_ms' => 'Tiada label yang rosak, pudar atau tidak boleh dibaca.', 'prompt_en' => 'No damaged, faded or unreadable labels.'],

            // Inventori
            ['code' => 'INV-01', 'category' => 'Inventori', 'applies_to' => 'Premises', 'prompt_ms' => 'Tiada produk racun perosak yang tidak berdaftar dijual.', 'prompt_en' => 'No unregistered pesticide products are sold.'],
            ['code' => 'INV-02', 'category' => 'Inventori', 'applies_to' => 'Premises', 'prompt_ms' => 'Tiada produk racun perosak yang telah tamat tempoh dijual.', 'prompt_en' => 'No expired pesticide products are for sale.'],
            ['code' => 'INV-03', 'category' => 'Inventori', 'applies_to' => 'Both',    'prompt_ms' => 'Rekod stok dan jualan dikemaskini dengan baik.', 'prompt_en' => 'Stock and sales records are well maintained.'],
            ['code' => 'INV-04', 'category' => 'Inventori', 'applies_to' => 'Company', 'prompt_ms' => 'Rekod pengeluaran dan pengedaran dikemaskini.', 'prompt_en' => 'Production and distribution records are updated.'],

            // Pelupusan
            ['code' => 'DIS-01', 'category' => 'Pelupusan', 'applies_to' => 'Both', 'prompt_ms' => 'Produk luput / rosak dilupuskan mengikut prosedur yang betul.', 'prompt_en' => 'Expired / damaged products are disposed according to proper procedures.'],
            ['code' => 'DIS-02', 'category' => 'Pelupusan', 'applies_to' => 'Both', 'prompt_ms' => 'Terdapat rekod pelupusan sisa racun perosak.', 'prompt_en' => 'Records of pesticide waste disposal are available.'],

            // Kakitangan
            ['code' => 'STF-01', 'category' => 'Kakitangan', 'applies_to' => 'Premises', 'prompt_ms' => 'Kakitangan yang mengendalikan racun perosak telah menerima latihan yang sesuai.', 'prompt_en' => 'Staff handling pesticides have received appropriate training.'],
            ['code' => 'STF-02', 'category' => 'Kakitangan', 'applies_to' => 'Premises', 'prompt_ms' => 'Alat pelindung diri (APD) disediakan untuk kakitangan.', 'prompt_en' => 'Personal protective equipment (PPE) is provided to staff.'],
        ];

        foreach ($items as $order => $item) {
            InspectionChecklistItem::firstOrCreate(
                ['code' => $item['code']],
                array_merge($item, ['display_order' => $order + 1, 'is_active' => true])
            );
        }
    }
}
