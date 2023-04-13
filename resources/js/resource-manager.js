'use strict';

document.addEventListener('alpine:init', () => {
    Alpine.data('resourceManager', () => ({
        searching: false,

        openSearch() {
            this.searching = true;

            this.$nextTick(() => {
                this.$refs.searchBar.focus();
                this.$refs.searchBar.select();
            });
        },

        closeSearch() {
            this.$refs.searchBar.value = '';
            this.$wire.clearSearch();
            this.searching = false;
        },

        nextPage() {
            this.changePage('nextPage');
        },

        previousPage() {
            this.changePage('previousPage');
        },

        changePage(direction) {
            this.$wire.call(direction).then(() => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    }));
});
