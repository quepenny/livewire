# Quepenny Livewire
Livewire starter-kit for Quepenny projects

## Installation
Add this to the projects `composer.json` (with the latest package version):
```
"require": {
    "quepenny/livewire": "*",
},
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:quepenny/livewire.git"
    }
],
```
Then run:

```
composer install
php artisan vendor:publish --tag=quepenny
npm i
vite build
```

go through files and remove unnecessary ones
copy suitable view blade templates from vendor/quepenny (e.g. vendor/quepenny/layouts/app.blade.php)

## Testing
When developing this package locally, test your changes on the
ACTUAL parent (Laravel) project (and not this package).

Add this to the project's `composer.json`:
```
"require": {
   "quepenny/livewire": "@dev"
},
"repositories": [
    {
        "url": "/home/paul-ogbeiwi/Projects/quepenny/livewire",
        "type": "path",
        "options": { "symlink": true }
    }
],
```
Then `composer update quepenny/livewire`.

Add this volume to the `laravel-test` service on `docker-compose.yml`:
```
services:
    laravel.test:
        volumes:
            - 'path/to/local/quepenny/livewire:/var/www/quepenny/livewire'
```
This creates a folder on the docker image for quepenny/livewire.

Then run the following:
```
sail stop && sail build --no-cache && sail up -d && sail shell
rm /var/www/html/vendor/quepenny/livewire && ln -s /var/www/quepenny/livewire /var/www/html/vendor/quepenny/livewire
exit
sail stop && sail up -d
```
This creates a symlink to the local quepenny/livewire package on the docker container
(so you can view your live changes).

## Image Processing
A reusable, folder-driven image pipeline that replaces manual tools such as
iloveimg.com. Consuming applications drop images into `public/images/<profile>/`
and the package resizes, encodes (WebP by default) and content-fingerprints them
for long-term browser caching.

### Publishing the config
```
php artisan vendor:publish --tag=quepenny-images
```
This publishes `config/quepenny-images.php`, which the consuming application can freely
edit. The package config is merged underneath it, so you only need to declare the
keys you want to override.

### Profiles
Each folder beneath `public/images/` is an **image profile**. A folder is only
processed when its name matches a profile defined in config:

```php
// config/quepenny-images.php
'profiles' => [
    'how-it-works' => ['width' => 480,  'quality' => 75, 'format' => 'webp', 'delete_originals' => true],
    'team'         => ['width' => 300,  'quality' => 80, 'format' => 'webp', 'delete_originals' => true],
    'hero'         => ['width' => 1920, 'quality' => 85, 'format' => 'webp', 'delete_originals' => false],
],
```

```
public/images/
├── how-it-works/
├── team/
└── hero/
```

Per-profile settings:

| Key                | Meaning                                                        |
|--------------------|----------------------------------------------------------------|
| `width`            | Target width in px. Aspect ratio is preserved; never upscaled. |
| `quality`          | Encoder quality (1–100).                                       |
| `format`           | Output format; must map to a registered encoder (`webp`).     |
| `delete_originals` | Remove the source file after a successful render.             |

Values under `defaults` in the config are merged beneath every profile, so a
profile only needs to declare what differs.

### Processing workflow
```
php artisan qp:images:process                 # process every profile folder
php artisan qp:images:process how-it-works     # process a single folder
php artisan qp:images:process --force          # ignore the manifest, rebuild all
php artisan qp:images:process --dry-run        # report without writing anything
php artisan qp:images:clean                    # remove orphaned generated files
```

A `--dry-run` prints a summary:

```
Found Images: 12
Would Process: 4
Would Skip: 8
Estimated Savings: 3.2 MB
```

### Idempotency & cache-busting
Every generated file is fingerprinted from **its contents + the resolved profile**,
producing names like `step-1.a7f8c2b1.webp`. Each profile folder keeps a
`.qp-images-manifest.json`:

```json
{
    "step-1.png": { "output": "step-1.a7f8c2b1.webp", "hash": "a7f8c2b1" }
}
```

On each run the command loads the manifest, recomputes hashes and **skips
unchanged files**. When an image or its profile changes the hash changes, a new
file is written and the obsolete one is removed — no orphaned assets accumulate.

Because filenames are content-hashed, generated assets can be served with
immutable caching (no query strings needed):

```
Cache-Control: public, max-age=31536000, immutable
```

### Helper usage
Resolve a source path to its fingerprinted URL in Blade or PHP:

```php
qp_image('how-it-works/step-1.png');
// => /images/how-it-works/step-1.a7f8c2b1.webp
```

```blade
<img src="@qpImage('how-it-works/step-1.png')" alt="Step 1">
{{-- or --}}
<img src="{{ qp_image('how-it-works/step-1.png') }}" alt="Step 1">
```

If the manifest or entry is missing the helper falls back to the original path so
views never break.

### Extending: pluggable encoders (AVIF-ready)
Output formats are pluggable. Each encoder implements
`Quepenny\Livewire\Services\Images\Encoders\ImageEncoder` and is registered in the
`encoders` config map. WebP and AVIF encoders ship with the package; enabling AVIF
is a config change only:

```php
'encoders' => [
    'webp' => Quepenny\Livewire\Services\Images\Encoders\WebpEncoder::class,
    'avif' => Quepenny\Livewire\Services\Images\Encoders\AvifEncoder::class,
],
// then set 'format' => 'avif' on any profile (requires PHP AVIF support).
```

## Deployment
1. Commit your changes.
2. Tag the latest commit using Semantic Versioning (explained below).
3. Push to remote.

### Semantic Versioning
Given a version number MAJOR.MINOR.PATCH (e.g. 1.0.15), increment the:

- MAJOR version when you make incompatible API changes.
- MINOR version when you add functionality in a backward compatible manner.
- PATCH version when you make backward compatible bug fixes.
