<?php

namespace Quepenny\Livewire\Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Tests\TestCase;

class CreateApiTokenTest extends TestCase
{
    use DatabaseTransactions;

    public function test_api_tokens_can_be_created()
    {
        if (! Features::hasApiFeatures()) {
            $this->markTestSkipped('API support is not enabled.');
        }

        if (Features::hasTeamFeatures()) {
            $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        } else {
            $this->actingAs($user = User::factory()->create());
        }

        Livewire::test(ApiTokenManager::class)
                    ->set(['createApiTokenForm' => [
                        'name' => 'Test Token',
                        'permissions' => [
                            'read',
                            'update',
                        ],
                    ]])
                    ->call('createApiToken');

        $this->assertCount(1, $user->fresh()->tokens);
        $this->assertEquals('Test Token', $user->fresh()->tokens->first()->name);
        $this->assertTrue($user->fresh()->tokens->first()->can('read'));
        $this->assertFalse($user->fresh()->tokens->first()->can('delete'));
    }
}