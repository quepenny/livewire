<?php

namespace Quepenny\Livewire\Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GuestTokenTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
    }

    public function testCancellation()
    {
        $this->assertEquals(3, 1 + 2);
    }
}
