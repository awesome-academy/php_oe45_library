<?php

namespace Tests\Unit\Events;

use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class NotificationEventTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testDispatchEventNotification()
    {
        Event::fake();

        $data = [
            'user' => 'Minh Tung',
            'content' => 'Hello, Welcome to Library HMT',
            'time' => '2020-07-17',
            'title' => 'Your Borrow Request is checked',
            'link' => 'localhost:8000/request',
        ];

        event(new NotificationEvent($data));

        Event::assertDispatched(NotificationEvent::class);
    }
}
