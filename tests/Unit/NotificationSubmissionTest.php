<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class NotificationSubmissionTest extends TestCase
{
    /** @test */
    public function it_measures_execution_time_of_getNotificationSubmissionTest()
    {
        // Mocking authentication if needed
        Auth::shouldReceive('guard')->with('web')->andReturnSelf();
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn((object) ['id' => 1]);

        // Start time
        $startTime = microtime(true);

        // Call your function
        getNotificationSubmissionTest();

        // End time
        $endTime = microtime(true);

        // Calculate the duration
        $duration = $endTime - $startTime;

        // Output the duration (or assert that to fail if it exceeds a certain threshold)
        $this->assertLessThan(120, $duration, "The function took too long to execute.");

        // Alternatively, just log the time
        echo "Execution time: " . $duration . " seconds\n";
    }
}
