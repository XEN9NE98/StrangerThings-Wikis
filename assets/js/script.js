// Delete functionality
function deleteItem(type, id) {
    if (confirm('Are you sure you want to delete this item?')) {
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
        
        $.ajax({
            url: 'actions/delete.php',
            type: 'POST',
            data: { 
                type: type, 
                id: id,
                csrf_token: csrfToken 
            },
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

// Reusable initialization function for page content
function initPage() {
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
}

/* Background music (HTML5 Audio) + SPA Navigation */
(function(){
    const AUDIO_SRC = 'assets/audio/Stranger Things Main Theme [01qStKYB7ts].mp3';
    let audio = new Audio(AUDIO_SRC);
    audio.loop = true;
    let isPlaying = false;

    // --- Audio Logic ---

    function initAudio() {
        // Retrieve saved time only on full reload
        // Check if page was reloaded
        let isReload = false;
        try {
            if (performance.getEntriesByType) {
                const entries = performance.getEntriesByType("navigation");
                if (entries.length > 0 && entries[0].type === 'reload') {
                    isReload = true;
                }
            } else if (window.performance && window.performance.navigation) {
                if (window.performance.navigation.type === 1) isReload = true;
            }
        } catch(e) {}

        let savedTime = 0;
        if (!isReload) {
            try {
                const t = localStorage.getItem('bgmTime');
                if (t) savedTime = parseFloat(t);
            } catch(e){}
        }
        
        if (savedTime && !isNaN(savedTime)) {
            audio.currentTime = savedTime;
        }

        const pref = localStorage.getItem('bgmEnabled');
        // Default to true ('1') if null, OR if explicitly '1'
        const shouldPlay = pref === null ? true : (pref === '1');

        if (pref === null) {
            localStorage.setItem('bgmEnabled', '1');
        }

        if (shouldPlay) {
            playAudio();
        } else {
            updateAudioIcon(false);
        }
    }

    function playAudio() {
        const playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(_ => {
                isPlaying = true;
                updateAudioIcon(true);
            }).catch(error => {
                console.log("Autoplay prevented:", error);
                isPlaying = false;
                updateAudioIcon(false);
            });
        }
    }

    function pauseAudio() {
        audio.pause();
        isPlaying = false;
        updateAudioIcon(false);
    }

    function updateAudioIcon(playing) {
        const icon = document.getElementById('audioIcon');
        if (!icon) return;
        if (playing) {
            icon.classList.remove('fa-volume-mute');
            icon.classList.add('fa-volume-up');
        } else {
            icon.classList.remove('fa-volume-up');
            icon.classList.add('fa-volume-mute');
        }
    }

    function toggleAudio() {
        if (isPlaying) {
            pauseAudio();
            localStorage.setItem('bgmEnabled', '0');
        } else {
            playAudio();
            localStorage.setItem('bgmEnabled', '1');
        }
    }

    function bindAudioToggle() {
        const btn = document.getElementById('audioToggle');
        if (btn) {
            // Remove old listeners to be safe (though swapping DOM usually clears them)
            const newBtn = btn.cloneNode(true); 
            btn.parentNode.replaceChild(newBtn, btn);
            
            newBtn.addEventListener('click', function(e){
                e.preventDefault();
                toggleAudio();
            });
            // Update icon state on new button
            updateAudioIcon(isPlaying);
        }
    }

    // --- SPA Navigation Logic ---

    function handleNavigation(url) {
        // Show loading state if desired (optional)
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Update Title
                document.title = doc.title;

                // Replace Navbar (to update active states)
                const newNav = doc.querySelector('nav.navbar');
                const oldNav = document.querySelector('nav.navbar');
                if (newNav && oldNav) {
                    oldNav.replaceWith(newNav);
                }

                // Replace Main Content
                // Note: header.php starts .container-fluid, footer.php ends it. 
                // We assume the main layout is consistent.
                const newContent = doc.querySelector('.container-fluid.py-4');
                const oldContent = document.querySelector('.container-fluid.py-4');
                
                if (newContent && oldContent) {
                    oldContent.innerHTML = newContent.innerHTML;
                }

                // Re-bind Audio Toggle (since navbar changed)
                bindAudioToggle();

                // Re-init Page Scripts (counters, etc)
                initPage();
                
                // Scroll to top
                window.scrollTo(0, 0);
            })
            .catch(err => {
                console.error('Navigation failed', err);
                // Fallback to full reload
                window.location.href = url;
            });
    }

    // --- Initialization ---

    document.addEventListener('DOMContentLoaded', function() {
        initPage();
        initAudio();
        bindAudioToggle();

        // Intercept Link Clicks
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link) {
                const href = link.getAttribute('href');
                
                if (href && 
                    href.indexOf('#') !== 0 && 
                    !link.target && 
                    !href.startsWith('http') && // Assuming relative links
                    !href.includes('actions/') && 
                    !link.hasAttribute('data-no-spa')) 
                {
                    e.preventDefault();
                    history.pushState(null, '', href);
                    handleNavigation(href);
                }
            }
        });

        // Handle Back/Forward buttons
        window.addEventListener('popstate', function() {
            handleNavigation(window.location.pathname);
        });
    });

    // Save time on actual unload (tab close/refresh)
    window.addEventListener('beforeunload', function() {
        if (audio && !audio.paused) {
            try {
                localStorage.setItem('bgmTime', audio.currentTime);
            } catch(e) {}
        }
    });

})();

