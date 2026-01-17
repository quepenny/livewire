<x-content.title-subtitle
    :title="__('quepenny::legal.cookies.title')"
    :subtitle="__('quepenny::legal.cookies.subtitle', ['date' => '13/01/2025'])"
>
    <p class="mb-4">
        <a
            href="javascript:void(0)"
            class="js-lcc-settings-toggle text-teal-600"
        >
            @lang('cookie-consent::texts.alert_settings')
        </a>
    </p>

    @include(__('quepenny::legal.cookies.view'))
</x-content.title-subtitle>
