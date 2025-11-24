/**
 * Video Controls JavaScript
 * Handles hero video sound toggle
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initVideoControls();
    });

    function initVideoControls() {
        const videos = document.querySelectorAll('.tk-hero-video__video');
        
        videos.forEach(video => {
            const container = video.closest('.tk-hero-video');
            if (!container) return;

            const soundToggle = container.querySelector('.tk-video-sound-toggle');
            if (!soundToggle) return;

            // Ensure video starts muted
            video.muted = true;

            // Add click handler for sound toggle
            soundToggle.addEventListener('click', function() {
                toggleVideoSound(video, soundToggle);
            });

            // Handle video load errors
            video.addEventListener('error', function() {
                console.error('Video failed to load');
                container.classList.add('video-error');
            });

            // Update button state on load
            updateButtonState(video, soundToggle);
        });
    }

    function toggleVideoSound(video, button) {
        video.muted = !video.muted;
        updateButtonState(video, button);
    }

    function updateButtonState(video, button) {
        if (video.muted) {
            button.setAttribute('aria-label', 'Unmute video');
            button.classList.remove('unmuted');
            button.classList.add('muted');
            button.textContent = '🔇';
        } else {
            button.setAttribute('aria-label', 'Mute video');
            button.classList.remove('muted');
            button.classList.add('unmuted');
            button.textContent = '🔊';
        }
    }

})();
