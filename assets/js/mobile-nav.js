/**
 * Mobile Navigation JavaScript
 * Handles mobile menu toggle and interactions
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initMobileNav();
    });

    function initMobileNav() {
        const hamburger = document.querySelector('.tk-hamburger');
        const mobileMenu = document.querySelector('.tk-mobile-menu');
        const closeBtn = document.querySelector('.tk-mobile-menu__close');

        if (!hamburger || !mobileMenu) return;

        // Hamburger click handler
        hamburger.addEventListener('click', openMobileMenu);

        // Close button handler
        if (closeBtn) {
            closeBtn.addEventListener('click', closeMobileMenu);
        }

        // Click outside to close
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                closeMobileMenu();
            }
        });

        // ESC key to close
        document.addEventListener('keydown', function(e) {
            if ((e.key === 'Escape' || e.keyCode === 27) && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        // Close menu when clicking on menu links
        const menuLinks = mobileMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMobileMenu();
            });
        });
    }

    function openMobileMenu() {
        const mobileMenu = document.querySelector('.tk-mobile-menu');
        if (!mobileMenu) return;

        mobileMenu.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Store previously focused element
        window.tkMobileNavPreviousFocus = document.activeElement;

        // Focus first menu item
        const firstLink = mobileMenu.querySelector('a');
        if (firstLink) {
            setTimeout(() => firstLink.focus(), 300);
        }
    }

    function closeMobileMenu() {
        const mobileMenu = document.querySelector('.tk-mobile-menu');
        if (!mobileMenu) return;

        mobileMenu.classList.remove('active');
        document.body.style.overflow = '';

        // Restore focus
        if (window.tkMobileNavPreviousFocus) {
            window.tkMobileNavPreviousFocus.focus();
            window.tkMobileNavPreviousFocus = null;
        }
    }

    // Export for use in other scripts
    window.tripKailashMobileNav = {
        open: openMobileMenu,
        close: closeMobileMenu
    };

})();
