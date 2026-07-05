<?php

namespace Tests\Feature;

use App\Models\Leave;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PendingLeaveCountTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function api_tra_ve_so_don_nghi_phep_dang_cho_duyet(): void
    {
        Leave::create([
            'emp_id' => '1',
            'emp_name' => 'Nhân Viên Một',
            'leave_type' => 'annual',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
            'days' => 1,
            'reason' => 'Nghỉ phép',
            'status' => 'pending',
        ]);

        Leave::create([
            'emp_id' => '2',
            'emp_name' => 'Nhân Viên Hai',
            'leave_type' => 'sick',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
            'days' => 1,
            'reason' => 'Nghỉ ốm',
            'status' => 'approved',
        ]);

        $response = $this->withSession([
            'user_id' => 99,
            'user_role' => 'admin',
        ])->getJson('/api/leaves/pending-count');

        $response->assertOk();
        $response->assertJson(['count' => 1]);
    }
}
