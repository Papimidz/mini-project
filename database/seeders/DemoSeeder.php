<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Area;
use App\Models\FireReport;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun demo
        $pelapor = User::firstOrCreate(
            ['email' => 'pelapor@karhutla.test'],
            [
                'name' => 'Demo Pelapor',
                'password' => 'password123',
            ]
        );

        $relawan = User::firstOrCreate(
            ['email' => 'relawan@karhutla.test'],
            [
                'name' => 'Demo Relawan',
                'password' => 'password123',
            ]
        );

        $koordinator = User::firstOrCreate(
            ['email' => 'koordinator@karhutla.test'],
            [
                'name' => 'Demo Koordinator',
                'password' => 'password123',
            ]
        );

        // Menetapkan role masing-masing akun
        $pelapor->forceFill(['role' => 'pelapor'])->save();
        $relawan->forceFill(['role' => 'relawan'])->save();
        $koordinator->forceFill(['role' => 'koordinator'])->save();

        // Membuat data wilayah
        $area1 = Area::firstOrCreate(
            ['name' => 'Kecamatan Malangbong'],
            ['description' => 'Wilayah pemantauan Malangbong']
        );

        $area2 = Area::firstOrCreate(
            ['name' => 'Kecamatan Cibatu'],
            ['description' => 'Wilayah pemantauan Cibatu']
        );

        $area3 = Area::firstOrCreate(
            ['name' => 'Kecamatan Limbangan'],
            ['description' => 'Wilayah pemantauan Limbangan']
        );

        // Membuat laporan dengan status berbeda
        $reports = [
            [
                'title' => 'Asap Terlihat di Area Perkebunan',
                'description' => 'Terlihat asap dari area perkebunan warga.',
                'area_id' => $area1->id,
                'incident_at' => '2026-11-01 08:00:00',
                'latitude' => -7.0000000,
                'longitude' => 108.0000000,
                'condition_level' => 'rendah',
                'status' => 'menunggu_peninjauan',
            ],
            [
                'title' => 'Kebakaran Lahan Dekat Hutan',
                'description' => 'Terlihat titik api di sekitar kawasan hutan.',
                'area_id' => $area2->id,
                'incident_at' => '2026-11-01 09:00:00',
                'latitude' => -7.1000000,
                'longitude' => 108.1000000,
                'condition_level' => 'tinggi',
                'status' => 'perlu_tindak_lanjut',
            ],
            [
                'title' => 'Asap di Area Lahan Kosong',
                'description' => 'Asap terlihat dari lahan kosong milik warga.',
                'area_id' => $area3->id,
                'incident_at' => '2026-11-01 10:00:00',
                'latitude' => -7.2000000,
                'longitude' => 108.2000000,
                'condition_level' => 'sedang',
                'status' => 'sedang_ditindaklanjuti',
            ],
            [
                'title' => 'Penanganan Laporan Selesai',
                'description' => 'Proses tindak lanjut laporan telah selesai.',
                'area_id' => $area1->id,
                'incident_at' => '2026-10-30 08:00:00',
                'latitude' => -7.0500000,
                'longitude' => 108.0500000,
                'condition_level' => 'rendah',
                'status' => 'selesai',
            ],
        ];

        foreach ($reports as $report) {
            FireReport::firstOrCreate(
                [
                    'user_id' => $pelapor->id,
                    'title' => $report['title'],
                ],
                $report + ['user_id' => $pelapor->id]
            );
        }
    }
}