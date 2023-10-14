# Quepenny Livewire
Livewire starter-kit for Quepenny projects

## Installation
Add this to the projects `composer.json`:
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
Then `composer install`.

## Testing
When developing this package locally, test your changes on the
ACTUAL parent (Laravel) project (and not this package).

Add this to the project's `composer.json`:
```
"require": {
   "quepenny/livewire": "dev-main"
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

## Deployment
1. Commit your changes.
2. Tag the latest commit using Semantic Versioning (explained below).
3. Push to remote.

### Semantic Versioning
Given a version number MAJOR.MINOR.PATCH (e.g. 1.0.15), increment the:

- MAJOR version when you make incompatible API changes.
- MINOR version when you add functionality in a backward compatible manner.
- PATCH version when you make backward compatible bug fixes.