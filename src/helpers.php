<?php

use App\Models\Guest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

if (! function_exists('guest')) {
    /**
     * Return guest-member
     */
    function guest(): ?Guest
    {
        return session('guest');
    }
}

if (! function_exists('is_divisible')) {
    /**
     * Check if dividend is perfectly divisible by divisor
     */
    function is_divisible(float|int $dividend, float|int $divisor): bool
    {
        if (is_int($dividend) && is_int($divisor)) {
            return $dividend % $divisor === 0;
        }

        $division = $dividend / $divisor;

        // Confirm division is a whole number
        // Due to issues with float precision, direct comparison isn't ideal
        return round($division) == strval($division);
    }
}

if (! function_exists('str_to_num')) {
    /**
     * Create number from numeric string
     * Returns zero if non-numeric
     */
    function str_to_num(string $value): float|int
    {
        if (is_numeric($value)) {
            return $value + 0;
        }

        return 0;
    }
}

if (! function_exists('titleplace')) {
    /**
     * Convert text to title-case after replacing 'search' with 'replace'
     */
    function titleplace(string $text, string $search = '-', string $replace = ' '): string
    {
        return ucwords(str_replace($search, $replace, $text));
    }
}

if (! function_exists('user')) {
    /**
     * Return authenticated user or guest-member
     */
    function user(): Authenticatable|Guest
    {
        return Auth::user() ?? guest();
    }
}

if (! function_exists('resource_label')) {
    /**
     * Retrieve a localized resource string with the given key and resource name.
     */
    function resource_label(string $key, string $resource, array $params = []): string
    {
        return __("quepenny::resources.{$key}", [
            'resource' => $resource,
            ...$params,
        ]);
    }
}

if (! function_exists('enum_dropdown_options')) {
    /**
     * Convert an array of enums to an array of dropdown options.
     *
     * @param array<BackedEnum> $enums
     */
    function enum_dropdown_options(array $enums, string $placeholder = '', array $additional = []): array
    {
        $options = [
            [
                'label' => $placeholder ?: 'Select Option',
                'value' => '',
            ]
        ];

        foreach ($enums as $enum) {
            $options[] = [
                'label' => titleplace($enum->value),
                'value' => $enum->value,
                ...$additional
            ];
        }

        return $options;
    }
}

if (! function_exists('file_id')) {
    /**
     * Generate a unique identifier for a file upload.
     */
    function file_id(UploadedFile $file): ?string
    {
        // Build a reasonably unique, stable identifier for the temp upload.
        $parts = [
            method_exists($file, 'getRealPath') ? (string) $file->getRealPath() : '',
            method_exists($file, 'getPathname') ? $file->getPathname() : '',
            method_exists($file, 'getClientOriginalName') ? $file->getClientOriginalName() : '',
            method_exists($file, 'getSize') ? (string) $file->getSize() : '',
        ];

        return sha1(implode('|', $parts));
    }
}

if (! function_exists('uploaded_file_from_storage')) {
    /**
     * Create an UploadedFile instance from a stored file path.
     */
    function uploaded_file_from_storage(string $disk, string $storedPath): UploadedFile
    {
        $absolutePath = Storage::disk($disk)->path($storedPath);

        return new UploadedFile(
            $absolutePath,
            basename($absolutePath),
            mime_content_type($absolutePath) ?: null,
            null,      // $error
            true       // $test: important when not from real HTTP upload
        );
    }
}
