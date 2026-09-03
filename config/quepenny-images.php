<?php

use Quepenny\Livewire\Services\Images\Encoders\AvifEncoder;
use Quepenny\Livewire\Services\Images\Encoders\WebpEncoder;

return [

    /*
    |--------------------------------------------------------------------------
    | Source Directory
    |--------------------------------------------------------------------------
    |
    | The directory, relative to the application's public path, that holds the
    | image profile folders. Each sub-folder beneath this directory is treated
    | as an image profile (see "profiles" below).
    |
    */

    'base_path' => 'images',

    /*
    |--------------------------------------------------------------------------
    | Public URL Prefix
    |--------------------------------------------------------------------------
    |
    | The public URL prefix that maps to the source directory above. The Blade
    | helper (qp_image / @qpImage) uses this to build asset URLs.
    |
    */

    'public_url' => '/images',

    /*
    |--------------------------------------------------------------------------
    | Fingerprint Length
    |--------------------------------------------------------------------------
    |
    | The number of hexadecimal characters kept from the content hash that is
    | appended to generated filenames (e.g. step-1.a7f8c2b1.webp). The hash is
    | derived from the original file contents plus the resolved profile so any
    | change to either produces a new filename.
    |
    */

    'hash_length' => 8,

    /*
    |--------------------------------------------------------------------------
    | Supported Source Formats
    |--------------------------------------------------------------------------
    |
    | Only files with these extensions are considered for processing. Anything
    | else in a profile folder is ignored.
    |
    */

    'source_formats' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],

    /*
    |--------------------------------------------------------------------------
    | Default Profile
    |--------------------------------------------------------------------------
    |
    | Settings merged beneath every profile. Individual profiles only need to
    | declare the keys they wish to override. A folder with no matching profile
    | is skipped entirely unless a "default" profile is defined here.
    |
    */

    'defaults' => [
        'quality' => 80,
        'format' => 'webp',
        'delete_originals' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Profiles
    |--------------------------------------------------------------------------
    |
    | Each key corresponds to a folder beneath the source directory. When a
    | folder shares its name with a profile, that profile is applied
    | automatically.
    |
    |   width            - target width in pixels (aspect ratio is preserved,
    |                       images are never upscaled)
    |   quality          - encoder quality (1-100)
    |   format           - output format; must map to a registered encoder
    |   delete_originals - remove the source file once processed
    |
    */

    'profiles' => [

        'how-it-works' => [
            'width' => 480,
            'quality' => 75,
            'format' => 'webp',
            'delete_originals' => true,
        ],

        'team' => [
            'width' => 300,
            'quality' => 80,
            'format' => compressed(),
            'delete_originals' => true,
        ],

        'hero' => [
            'width' => 1920,
            'quality' => 85,
            'format' => 'webp',
            'delete_originals' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Encoders
    |--------------------------------------------------------------------------
    |
    | Maps a profile "format" to the encoder class responsible for producing
    | it. Encoders implement Quepenny\Livewire\Services\Images\Encoders\
    | ImageEncoder and wrap an underlying Intervention encoder. Add an "avif"
    | entry here to enable AVIF output once desired - no other changes needed.
    |
    */

    'encoders' => [
        'webp' => WebpEncoder::class,
        'avif' => AvifEncoder::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Manifest Filename
    |--------------------------------------------------------------------------
    |
    | The per-folder manifest that records generated assets so unchanged files
    | are not reprocessed and helpers can resolve fingerprinted URLs.
    |
    */

    'manifest' => '.qp-images-manifest.json',

];
