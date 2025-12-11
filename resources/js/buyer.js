/**
 * Buyer JavaScript - FIXED RELOAD LOOP
 * File: resources/js/buyer.js
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Profile Dropdown
    initProfileDropdown();
    
    // Alert Close Buttons
    initAlertButtons();
    
    // Active Nav Link
    setActiveNavLink();
    
    // Prevent All Default Link Behaviors
    preventDefaultLinks();
    
});

/**
 * Profile Dropdown - INSTANT (No Animation)
 */
function initProfileDropdown() {
    const dropdown = document.querySelector('.profile-dropdown');
    
    if (!dropdown) return;
    
    const trigger = dropdown.querySelector('.profile-trigger');
    
    if (!trigger) return;
    
    // Toggle dropdown INSTANTLY
    trigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropdown.classList.toggle('active');
    });
    
    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
    
    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            dropdown.classList.remove('active');
        }
    });
}

/**
 * Alert Close Buttons - INSTANT REMOVE (No Animation)
 */
function initAlertButtons() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(function(alert) {
        const closeBtn = alert.querySelector('.alert-close');
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                alert.remove();
            });
        }
        
        // Auto-hide success alerts after 5 seconds
        if (alert.classList.contains('alert-success')) {
            setTimeout(function() {
                if (alert.parentElement) {
                    alert.remove();
                }
            }, 5000);
        }
    });
}

/**
 * Set Active Nav Link
 */
function setActiveNavLink() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(function(link) {
        const href = link.getAttribute('href');
        if (href && (href === currentPath || (currentPath.includes(href) && href !== '/'))) {
            link.classList.add('active');
        }
    });
}

/**
 * Prevent # Links from Reloading
 */
function preventDefaultLinks() {
    // Prevent empty href links
    document.querySelectorAll('a[href="#"], a[href=""]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
        });
    });
}