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

## Deployment
1. Commit your changes.
2. Tag the latest commit using Semantic Versioning (explained below).
3. Push to remote.

### Semantic Versioning
Given a version number MAJOR.MINOR.PATCH (e.g. 1.0.15), increment the:

- MAJOR version when you make incompatible API changes.
- MINOR version when you add functionality in a backward compatible manner.
- PATCH version when you make backward compatible bug fixes.
