/**
 * Package Overlay JavaScript
 * Handles opening package details in an overlay
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initPackageOverlay();
    });

    function initPackageOverlay() {
        // Use event delegation for package cards
        document.addEventListener('click', function(e) {
            const packageCard = e.target.closest('.tk-package-card');
            if (packageCard) {
                const packageUrl = packageCard.dataset.packageUrl;
                if (packageUrl) {
                    window.location.href = packageUrl;
                    return;
                }
                e.preventDefault();
                const packageId = packageCard.dataset.packageId;
                if (packageId) {
                    openPackageOverlay(packageId);
                }
            }
        });
    }

    function openPackageOverlay(packageId) {
        // Show loading state
        showLoadingOverlay();

        // Fetch package data from REST API
        const apiUrl = window.tripKailashData?.restUrl || '/wp-json';
        fetch(`${apiUrl}/tripkailash/v1/package/${packageId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Package not found');
                }
                return response.json();
            })
            .then(data => {
                renderPackageOverlay(data);
            })
            .catch(error => {
                console.error('Error loading package:', error);
                showErrorOverlay();
            });
    }

    function showLoadingOverlay() {
        const overlay = createOverlayStructure();
        overlay.querySelector('.tk-overlay__body').innerHTML = `
            <div class="tk-loading-container">
                <div class="tk-loading"></div>
                <p>Loading package details...</p>
            </div>
        `;
        document.body.appendChild(overlay);
        setTimeout(() => overlay.classList.add('active'), 10);
        lockBodyScroll();
    }

    function showErrorOverlay() {
        const overlay = document.querySelector('.tk-package-overlay');
        if (overlay) {
            overlay.querySelector('.tk-overlay__body').innerHTML = `
                <div class="tk-error-message">
                    <p>Sorry, we couldn't load this package. Please try again later.</p>
                </div>
            `;
        }
    }

    function renderPackageOverlay(packageData) {
        const overlay = document.querySelector('.tk-package-overlay');
        if (!overlay) return;

        const meta = packageData.meta;
        const icons = generateIconsHTML(meta);
        const keyStops = generateKeyStopsHTML(meta.key_stops);

        const content = `
            <div class="tk-overlay__header">
                ${packageData.featured_image ? `<img src="${packageData.featured_image}" alt="${packageData.title}">` : ''}
            </div>
            <div class="tk-overlay__details">
                <h2>${packageData.title}</h2>
                ${meta.trip_length ? `<p class="tk-overlay__duration">${meta.trip_length}</p>` : ''}
                <div class="tk-overlay__icons">${icons}</div>
                ${meta.difficulty ? `<p class="tk-overlay__difficulty"><strong>Difficulty:</strong> ${meta.difficulty}</p>` : ''}
                ${meta.best_months ? `<p class="tk-overlay__best-months"><strong>Best Time:</strong> ${meta.best_months}</p>` : ''}
                ${meta.price_from ? `<p class="tk-overlay__price"><strong>Starting from:</strong> ₹${meta.price_from.toLocaleString()}</p>` : ''}
                ${keyStops}
                <div class="tk-overlay__content">${packageData.content}</div>
            </div>
            <div class="tk-overlay__sticky-cta">
                <a href="#contact" class="tk-btn tk-btn-gold">Book This Yatra</a>
            </div>
        `;

        overlay.querySelector('.tk-overlay__body').innerHTML = content;
    }

    function generateIconsHTML(meta) {
        return `
            <span class="tk-icon ${meta.has_lodge ? 'tk-icon--active' : 'tk-icon--inactive'}" title="${meta.has_lodge ? 'Lodge Included' : 'No Lodge'}">🛏️</span>
            <span class="tk-icon ${meta.has_helicopter ? 'tk-icon--active' : 'tk-icon--inactive'}" title="${meta.has_helicopter ? 'Helicopter Available' : 'No Helicopter'}">🚁</span>
            <span class="tk-icon ${meta.includes_meals ? 'tk-icon--active' : 'tk-icon--inactive'}" title="${meta.includes_meals ? 'Meals Included' : 'No Meals'}">🍛</span>
            <span class="tk-icon ${meta.includes_rituals ? 'tk-icon--active' : 'tk-icon--inactive'}" title="${meta.includes_rituals ? 'Rituals Included' : 'No Rituals'}">🙏</span>
        `;
    }

    function generateKeyStopsHTML(keyStops) {
        if (!keyStops || !Array.isArray(keyStops) || keyStops.length === 0) {
            return '';
        }

        const stopsHTML = keyStops.map(stop => `<li>${stop}</li>`).join('');
        return `
            <div class="tk-overlay__key-stops">
                <h3>Key Stops</h3>
                <ul>${stopsHTML}</ul>
            </div>
        `;
    }

    function createOverlayStructure() {
        const overlay = document.createElement('div');
        overlay.className = 'tk-overlay tk-package-overlay';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.setAttribute('aria-labelledby', 'overlay-title');
        overlay.innerHTML = `
            <div class="tk-overlay__content">
                <button class="tk-overlay__close" aria-label="Close overlay">×</button>
                <div class="tk-overlay__body"></div>
            </div>
        `;

        // Add close button handler
        overlay.querySelector('.tk-overlay__close').addEventListener('click', closeOverlay);

        // Add click outside to close
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeOverlay();
            }
        });

        // Add ESC key listener
        document.addEventListener('keydown', handleEscapeKey);

        // Setup focus trap
        setupFocusTrap(overlay);

        return overlay;
    }

    function handleEscapeKey(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            closeOverlay();
        }
    }

    function setupFocusTrap(overlay) {
        const focusableElements = overlay.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        if (focusableElements.length === 0) return;

        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        // Focus first element
        setTimeout(() => firstFocusable.focus(), 100);

        // Trap focus
        overlay.addEventListener('keydown', function(e) {
            if (e.key !== 'Tab' && e.keyCode !== 9) return;

            if (e.shiftKey) {
                // Shift + Tab
                if (document.activeElement === firstFocusable) {
                    e.preventDefault();
                    lastFocusable.focus();
                }
            } else {
                // Tab
                if (document.activeElement === lastFocusable) {
                    e.preventDefault();
                    firstFocusable.focus();
                }
            }
        });
    }

    function closeOverlay() {
        const overlay = document.querySelector('.tk-package-overlay');
        if (overlay) {
            overlay.classList.remove('active');
            // Remove ESC key listener
            document.removeEventListener('keydown', handleEscapeKey);
            setTimeout(() => {
                overlay.remove();
                unlockBodyScroll();
                restoreFocus();
            }, 300);
        }
    }

    function lockBodyScroll() {
        document.body.style.overflow = 'hidden';
        // Store currently focused element
        window.tkPreviousFocus = document.activeElement;
    }

    function unlockBodyScroll() {
        document.body.style.overflow = '';
    }

    function restoreFocus() {
        if (window.tkPreviousFocus) {
            window.tkPreviousFocus.focus();
            window.tkPreviousFocus = null;
        }
    }

    // Export for use in other scripts
    window.tripKailashOverlay = {
        open: openPackageOverlay,
        close: closeOverlay
    };

})();
