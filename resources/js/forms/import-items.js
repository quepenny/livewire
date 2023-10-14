'use strict';

document.addEventListener('alpine:init', () => {
    Alpine.data('importItems', ($wire) => ({
        importList: $wire.entangle('importList'),
        importFile: $wire.entangle('importFile'),
        importFromFile: $wire.entangle('importFromFile'),

        toggleFileImport(e) {
            if (this.importFromFile) {
                this.importFile = null;
            }

            this.importFromFile = e.target.value === '0';
        },
    }));
});

