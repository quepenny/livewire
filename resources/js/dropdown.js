'use strict';

document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', () => ({
        showDropdown: false,

        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        },

        selectItem() {
            this.$dispatch('item-selected');
            this.toggleDropdown();
        },
    }));
});
