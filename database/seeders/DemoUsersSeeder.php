<?php

namespace Database\Seeders;

use App\Enums\CompanyStatus;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('Password123!');

        $this->seedOfficers($password);
        $this->seedIndustryCompaniesAndUsers($password);
    }

    private function seedOfficers(string $password): void
    {
        $officers = [
            // Pendaftar
            ['name' => 'Ahmad Fadzillah bin Ramli',      'email' => 'ahmad.fadzillah@doa.gov.my', 'role' => 'Pendaftar'],
            ['name' => 'Noraini binti Hassan',            'email' => 'noraini.hassan@doa.gov.my',  'role' => 'Pendaftar'],
            // Penilai Teknikal
            ['name' => 'Dr. Mohd Zulkifli bin Osman',    'email' => 'zulkifli.osman@doa.gov.my',  'role' => 'Penilai Teknikal'],
            ['name' => 'Nur Azwani binti Abdul Aziz',     'email' => 'azwani.aziz@doa.gov.my',     'role' => 'Penilai Teknikal'],
            ['name' => 'Hazrul bin Mahmud',               'email' => 'hazrul.mahmud@doa.gov.my',   'role' => 'Penilai Teknikal'],
            // Penilai Label
            ['name' => 'Faridah binti Yusuf',             'email' => 'faridah.yusuf@doa.gov.my',   'role' => 'Penilai Label'],
            ['name' => 'Mohd Akmal bin Kamarudin',        'email' => 'akmal.kamarudin@doa.gov.my', 'role' => 'Penilai Label'],
            // Pegawai Pendaftaran
            ['name' => 'Siti Aisyah binti Mohd Ali',     'email' => 'aisyah.ali@doa.gov.my',      'role' => 'Pegawai Pendaftaran'],
            ['name' => 'Razif bin Ibrahim',               'email' => 'razif.ibrahim@doa.gov.my',   'role' => 'Pegawai Pendaftaran'],
            ['name' => 'Lim Wei Ching',                   'email' => 'wei.ching@doa.gov.my',       'role' => 'Pegawai Pendaftaran'],
            // Pegawai Pemeriksaan
            ['name' => 'Hashim bin Othman',               'email' => 'hashim.othman@doa.gov.my',   'role' => 'Pegawai Pemeriksaan'],
            ['name' => 'Nurul Huda binti Zainudin',       'email' => 'nurul.huda@doa.gov.my',      'role' => 'Pegawai Pemeriksaan'],
        ];

        foreach ($officers as $officer) {
            $user = User::firstOrCreate(
                ['email' => $officer['email']],
                [
                    'name'      => $officer['name'],
                    'password'  => $password,
                    'is_active' => true,
                ]
            );
            $user->syncRoles([$officer['role']]);
        }
    }

    private function seedIndustryCompaniesAndUsers(string $password): void
    {
        $companies = [
            [
                'company' => [
                    'name'           => 'Syarikat Kimia Pertanian Sdn Bhd',
                    'ssm_no'         => '199501234567',
                    'address'        => 'Malaysia',
                    'status'         => CompanyStatus::Active,
                    'contact_person' => 'Tan Ah Kow',
                ],
                'users' => [
                    ['name' => 'Tan Ah Kow', 'email' => 'tan.ahkow@skpsb.com.my'],
                ],
            ],
            [
                'company' => [
                    'name'           => 'AgroProtect Malaysia Sdn Bhd',
                    'ssm_no'         => '200112345678',
                    'address'        => 'Malaysia',
                    'status'         => CompanyStatus::Active,
                    'contact_person' => 'Fatimah binti Jaafar',
                ],
                'users' => [
                    ['name' => 'Fatimah binti Jaafar', 'email' => 'fatimah@agroprotect.com.my'],
                    ['name' => 'Accounts AgroProtect',  'email' => 'accounts@agroprotect.com.my'],
                ],
            ],
            [
                'company' => [
                    'name'           => 'GlobalChem Trading Sdn Bhd',
                    'ssm_no'         => '199823456789',
                    'address'        => 'Malaysia',
                    'status'         => CompanyStatus::Active,
                    'contact_person' => 'Wong Kam Fatt',
                ],
                'users' => [
                    ['name' => 'Wong Kam Fatt', 'email' => 'kam.fatt@globalchem.com.my'],
                ],
            ],
            [
                'company' => [
                    'name'           => 'Bio-Agri Resources Sdn Bhd',
                    'ssm_no'         => '201534567890',
                    'address'        => 'Malaysia',
                    'status'         => CompanyStatus::Active,
                    'contact_person' => 'Mohd Redzuan bin Nordin',
                ],
                'users' => [
                    ['name' => 'Mohd Redzuan bin Nordin', 'email' => 'redzuan@bioagri.com.my'],
                ],
            ],
            [
                'company' => [
                    'name'           => 'Pesticide Holdings Malaysia Sdn Bhd',
                    'ssm_no'         => '200045678901',
                    'address'        => 'Malaysia',
                    'status'         => CompanyStatus::Suspended,
                    'contact_person' => 'Ramasamy a/l Krishnan',
                ],
                'users' => [
                    ['name' => 'Ramasamy a/l Krishnan', 'email' => 'ramasamy@phmsb.com.my'],
                ],
            ],
        ];

        foreach ($companies as $entry) {
            $company = Company::firstOrCreate(
                ['ssm_no' => $entry['company']['ssm_no']],
                $entry['company']
            );

            foreach ($entry['users'] as $userData) {
                $user = User::firstOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name'       => $userData['name'],
                        'password'   => $password,
                        'is_active'  => true,
                        'company_id' => $company->id,
                    ]
                );
                $user->syncRoles(['Industri']);
            }
        }
    }
}
