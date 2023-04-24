'use strict';

document.addEventListener('alpine:init', () => {
    Alpine.data('importItems', ($wire) => ({
        importList: $wire.entangle('importList').defer,
        importFile: $wire.entangle('importFile').defer,
        importFromFile: $wire.entangle('importFromFile').defer,

        toggleFileImport(e) {
            if (this.importFromFile) {
                this.importFile = null;
            }

            this.importFromFile = e.target.value === '0';
        },
    }));
});

