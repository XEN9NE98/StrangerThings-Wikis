// Delete functionality
function deleteItem(type, id) {
    if (confirm('Are you sure you want to delete this item?')) {
        $.ajax({
            url: 'actions/delete.php',
            type: 'POST',
            data: { type: type, id: id },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function() {
                alert('Error deleting item');
            }
        });
    }
}

// Watch clip functionality
function watchClip(url) {
    if (url && url.trim() !== '') {
        window.open(url, '_blank');
    } else {
        alert('No clip URL available');
    }
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to counter numbers
    const counters = document.querySelectorAll('.counter-number');
    counters.forEach(counter => {
        const target = parseInt(counter.innerText);
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.innerText = target;
                clearInterval(timer);
            } else {
                counter.innerText = Math.floor(current);
            }
        }, 20);
    });
});
