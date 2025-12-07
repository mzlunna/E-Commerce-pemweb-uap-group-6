/**
 * Buyer JavaScript - Global Scripts
 * File: resources/js/buyer.js
 * 
 * Contains:
 * - Profile Dropdown functionality
 * - Other buyer-related scripts
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== PROFILE DROPDOWN =====
    initProfileDropdown();
    
    // ===== AUTO DISMISS ALERTS =====
    autoHideAlerts();
    
});

/**
 * Initialize Profile Dropdown
 */
function initProfileDropdown() {
    const profileDropdown = document.getElementById('profileDropdown');
    const dropdownOverlay = document.getElementById('dropdownOverlay');
    
    if (!profileDropdown) return; // Exit if not found
    
    const trigger = profileDropdown.querySelector('.profile-trigger');
    
    // Toggle dropdown when clicking trigger
    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleDropdown();
    });
    
    // Close dropdown when clicking overlay
    dropdownOverlay.addEventListener('click', function() {
        closeDropdown();
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!profileDropdown.contains(e.target)) {
            closeDropdown();
        }
    });
    
    // Close dropdown when pressing ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDropdown();
        }
    });
    
    // Helper functions
    function toggleDropdown() {
        profileDropdown.classList.toggle('active');
        dropdownOverlay.classList.toggle('active');
    }
    
    function closeDropdown() {
        profileDropdown.classList.remove('active');
        dropdownOverlay.classList.remove('active');
    }
}

/**
 * Auto hide alerts after 5 seconds
 */
function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
}

