<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Area;
use App\Models\FireReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelapor_cannot_change_report_status(): void
    {

        $pelapor = User::create([
            'name' => 'Pelapor Testing',
            'email' => 'pelapor@test.com',
            'password' => bcrypt('password123'),
        ]);

        $pelapor->forceFill([
            'role' => 'pelapor',
        ])->save();

        $area = Area::create([
            'name' => 'Wilayah Testing',
            'description' => 'Wilayah untuk pengujian',
        ]);

        $report = FireReport::create([
            'user_id' => $pelapor->id,
            'area_id' => $area->id,
            'title' => 'Laporan Testing',
            'description' => 'Pengujian hak akses perubahan status',
            'incident_at' => now(),
            'latitude' => -7.1234567,
            'longitude' => 108.1234567,
            'condition_level' => 'sedang',
            'status' => 'menunggu_peninjauan',
        ]);

        $response = $this->actingAs($pelapor)
            ->patch(route('fire-reports.status.update', $report->id), [
                'status' => 'perlu_tindak_lanjut',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('fire_reports', [
            'id' => $report->id,
            'status' => 'menunggu_peninjauan',
        ]);
    }
    public function test_relawan_cannot_skip_report_status(): void
    {
        $relawan = User::create([
            'name' => 'Relawan Testing',
            'email' => 'relawan@test.com',
            'password' => bcrypt('password123'),
            'role' => 'relawan',
        ]);

        $area = Area::create([
            'name' => 'Wilayah Testing',
            'description' => 'Wilayah untuk pengujian',
        ]);

        $report = FireReport::create([
            'user_id' => $relawan->id,
            'area_id' => $area->id,
            'title' => 'Laporan Testing',
            'description' => 'Pengujian perubahan status',
            'incident_at' => now(),
            'latitude' => -7.1234567,
            'longitude' => 108.1234567,
            'condition_level' => 'sedang',
            'status' => 'menunggu_peninjauan',
        ]);

        $response = $this->actingAs($relawan)
            ->patch(route('fire-reports.status.update', $report->id), [
                'status' => 'selesai',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('fire_reports', [
            'id' => $report->id,
            'status' => 'menunggu_peninjauan',
        ]);
    }
    public function test_koordinator_cannot_move_report_status_backward(): void
    {
        $koordinator = User::create([
            'name' => 'Koordinator Testing',
            'email' => 'koordinator@test.com',
            'password' => bcrypt('password123'),
            'role' => 'koordinator',
        ]);

        $area = Area::create([
            'name' => 'Wilayah Testing',
            'description' => 'Wilayah untuk pengujian',
        ]);

        $report = FireReport::create([
            'user_id' => $koordinator->id,
            'area_id' => $area->id,
            'title' => 'Laporan Testing',
            'description' => 'Pengujian perubahan status mundur',
            'incident_at' => now(),
            'latitude' => -7.1234567,
            'longitude' => 108.1234567,
            'condition_level' => 'sedang',
            'status' => 'sedang_ditindaklanjuti',
        ]);

        $response = $this->actingAs($koordinator)
            ->patch(route('fire-reports.status.update', $report->id), [
                'status' => 'perlu_tindak_lanjut',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('fire_reports', [
            'id' => $report->id,
            'status' => 'sedang_ditindaklanjuti',
        ]);
    }
    public function test_relawan_cannot_add_review_after_status_changes(): void
    {
        $relawan = User::create([
            'name' => 'Relawan Testing',
            'email' => 'relawan-review@test.com',
            'password' => bcrypt('password123'),
        ]);

        $relawan->forceFill([
            'role' => 'relawan',
        ])->save();

        $area = Area::create([
            'name' => 'Wilayah Testing',
            'description' => 'Wilayah untuk pengujian',
        ]);

        $report = FireReport::create([
            'user_id' => $relawan->id,
            'area_id' => $area->id,
            'title' => 'Laporan Testing',
            'description' => 'Pengujian catatan peninjauan',
            'incident_at' => now(),
            'latitude' => -7.1234567,
            'longitude' => 108.1234567,
            'condition_level' => 'sedang',
            'status' => 'perlu_tindak_lanjut',
        ]);

        $response = $this->actingAs($relawan)
            ->post(route('report-reviews.store', $report->id), [
                'note' => 'Catatan pengujian',
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('report_reviews', [
            'fire_report_id' => $report->id,
            'note' => 'Catatan pengujian',
        ]);
    }
}
