'use strict';

document.addEventListener('alpine:init', () => {
    Alpine.data('nav', () => ({
        showMobileMenu: false,

        toggleMobileMenu() {
            this.showMobileMenu = !this.showMobileMenu;
        },
    }));
});
