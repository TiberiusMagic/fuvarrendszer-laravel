<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobCreationTest extends TestCase
{
    /**
     * Test that Job is created with the right values
     */
    use RefreshDatabase;

    public function test_job_creation_driver_email_pass_and_status_assigned()
    {
        $driver = User::create([
            'name'  => 'Driver Driver',
            'email' => 'driver@driver.driver',
            'password' => '93zhBKHf89zrwh',
            'role'  => 'Driver',
        ]);

        $job = Job::create([
            'start_address'       => 'Egy cím',
            'destination_address' => 'Egy másik cím',
            'recipient_name'      => 'Egy Név',
            'recipient_phone'     => '06201234567',
            'driver_email'        => $driver->email,
        ]);

        $this->assertNotNull($job->id);
        $this->assertEquals('driver@driver.driver', $job->driver_email);
        $this->assertEquals('Assigned', $job->status);
    }
    
}
