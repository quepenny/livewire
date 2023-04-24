<div class="pb-6 flex justify-center items-center" href="#">
    <a href="{{ route('social-login', ['driver' => 'facebook']) }}">
        <x-icon
            name="facebook"
            class="text-blue-600 mr-3"
            width="45"
            height="45"
        />
    </a>

    <a href="{{ route('social-login', ['driver' => 'google']) }}">
        <x-icon
            name="google"
            class="text-red-500"
            width="45"
            height="45"
        />
    </a>
</div>
