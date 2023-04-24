<a class="text-3xl font-bold leading-none" href="/">
  <span
      @class([
          'font-righteous tracking-wide text-center',
          'text-white' => $light ?? false
      ])
  >{{ env('APP_NAME') }}</span>
</a>
