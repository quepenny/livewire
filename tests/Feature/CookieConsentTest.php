<?php

namespace Quepenny\Livewire\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Lang;

class CookieConsentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_cookie_consent_banner_injected_on_guest_pages(): void
    {
        Lang::has('cookie-consent::texts.alert_settings') || $this->markTestSkipped();

        $this
            ->get('/')
            ->assertOk()
            ->assertSee('js-lcc-modal-alert')
            ->assertSee('js-lcc-accept');
    }

    public function test_cookie_consent_banner_not_injected_on_ignored_paths(): void
    {
        Lang::has('cookie-consent::texts.alert_settings') || $this->markTestSkipped();

        $this
            ->get('/login')
            ->assertOk()
            ->assertDontSee('js-lcc-modal-alert');
    }

    public function test_cookies_policy_page_renders(): void
    {
        $this
            ->get('/cookies')
            ->assertOk()
            ->assertSee(__('quepenny::legal.cookies.title'))
            ->assertSee('js-lcc-settings-toggle');
    }

    public function test_privacy_policy_page_renders(): void
    {
        $this
            ->get('/privacy')
            ->assertOk()
            ->assertSee(__('quepenny::legal.privacy.title'));
    }

    public function test_terms_of_service_page_renders(): void
    {
        $this
            ->get('/terms')
            ->assertOk()
            ->assertSee(__('quepenny::legal.terms.title'));
    }
}
