# Quepenny Livewire
Livewire starter-kit for Quepenny projects

## Installation
Add this to the projects `composer.json` (with the latest package version):
```
"require": {
    "quepenny/livewire": "1.5.3",
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
        "url": "/path/to/quepenny/livewire",
        "type": "path",
        "options": {
            "symlink": true
        }
    }
],
```
Then `composer install`.

Add this volume to the `laravel-test` service on `docker-compose.yml`:
```
services:
    laravel.test:
        volumes:
            - 'path/to/quepenny/livewire:/var/www/quepenny/livewire'
```
This creates a folder on the docker image for quepenny/livewire.

Then create a `Dockerfile` on the project root like this:
```
# Dockerfile

FROM sail-8.2/app

# Create a symbolic link to the local package
RUN ln -s /var/www/quepenny/livewire /var/www/html/vendor/quepenny/livewire
```
This creates a symlink to the local quepenny/livewire package on the docker container (so you can view your live changes).

Finally run
```
sail build --no-cache
sail up -d
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