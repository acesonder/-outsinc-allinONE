/**
 * Form Validation and UI Enhancements
 * ES6+ JavaScript
 */

// Password strength indicator
const checkPasswordStrength = (password) => {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    return strength;
};

// Form validation on submit
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const passwordField = form.querySelector('input[name="password"]');
            const confirmPasswordField = form.querySelector('input[name="confirm_password"]');
            
            // Validate password match if both fields exist
            if (passwordField && confirmPasswordField) {
                if (passwordField.value !== confirmPasswordField.value) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    confirmPasswordField.focus();
                    return false;
                }
                
                // Check password strength
                const strength = checkPasswordStrength(passwordField.value);
                if (strength < 2) {
                    const proceed = confirm('Your password is weak. Are you sure you want to continue?');
                    if (!proceed) {
                        e.preventDefault();
                        passwordField.focus();
                        return false;
                    }
                }
            }
        });
    });
    
    // Real-time password match validation
    const confirmPasswordFields = document.querySelectorAll('input[name="confirm_password"]');
    confirmPasswordFields.forEach(field => {
        field.addEventListener('input', function() {
            const passwordField = this.form.querySelector('input[name="password"]');
            if (this.value !== passwordField.value) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#28a745';
            }
        });
    });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});

// Confirmation for destructive actions
const confirmAction = (message) => {
    return confirm(message);
};

// Export functions for use in other scripts
export { checkPasswordStrength, confirmAction };
