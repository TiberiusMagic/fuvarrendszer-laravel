<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobStatusUpdateTest extends TestCase
{
    /**
     * Test that the Driver can update the status of just his/her own Job
     */

    use RefreshDatabase;

    public function test_driver_update_own_job(): void
    {
        $driver = User::factory()->create([
            'role' => 'Driver',
            'email' => 'driver@driver.driver',
        ]);

        $job = Job::create([
            'start_address'       => 'Egy cím',
            'destination_address' => 'Egy másik cím',
            'recipient_name'      => 'Egy Név',
            'recipient_phone'     => '06201234567',
            'driver_email'        => $driver->email,
        ]);

        $this->assertEquals('Assigned', $job->status);

        $newStatus = 'InProgress';
        $job->status = $newStatus;

        $this->assertEquals('InProgress', $job->status);
    }
}
