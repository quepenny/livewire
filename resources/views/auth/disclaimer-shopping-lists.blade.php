@if(Auth::guest() && user()->hasData())
    <p class="text-red-500 text-sm -mt-3 mb-6">
        {{ __('quepenny::auth.data-transfer-disclaimer') }}
    </p>
@endif
