/**
 * Header Navigation
 * Handles mobile menu toggle
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenuToggle();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenuToggle() {
        const toggle = document.querySelector('.tk-mobile-menu-toggle');
        const nav = document.querySelector('.tk-header__nav');
        
        if (!toggle || !nav) return;

        toggle.addEventListener('click', function() {
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            
            toggle.setAttribute('aria-expanded', !isExpanded);
            toggle.classList.toggle('active');
            nav.classList.toggle('active');
            
            // Prevent body scroll when menu is open
            if (!isExpanded) {
                document.body.classList.add('tk-scroll-locked');
            } else {
                document.body.classList.remove('tk-scroll-locked');
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!toggle.contains(e.target) && !nav.contains(e.target)) {
                if (nav.classList.contains('active')) {
                    toggle.setAttribute('aria-expanded', 'false');
                    toggle.classList.remove('active');
                    nav.classList.remove('active');
                    document.body.classList.remove('tk-scroll-locked');
                }
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && nav.classList.contains('active')) {
                toggle.setAttribute('aria-expanded', 'false');
                toggle.classList.remove('active');
                nav.classList.remove('active');
                document.body.classList.remove('tk-scroll-locked');
            }
        });
    }

})();
