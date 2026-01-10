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

// Edit functions
function editCharacter(id) {
    $.get('actions/get_character.php', { id: id }, function(data) {
        const character = JSON.parse(data);
        const modalBody = `
            <input type="hidden" name="id" value="${character.id}">
            <div class="mb-3">
                <label for="name" class="form-label">Character Name *</label>
                <input type="text" class="form-control" name="name" value="${character.name}" required>
            </div>
            <div class="mb-3">
                <label for="actor_name" class="form-label">Actor Name *</label>
                <input type="text" class="form-control" name="actor_name" value="${character.actor_name}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control" name="description" rows="4" required>${character.description}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" name="age" value="${character.age}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="born_date" class="form-label">Born Date</label>
                    <input type="date" class="form-control" name="born_date" value="${character.born_date}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="height" class="form-label">Height</label>
                    <input type="text" class="form-control" name="height" value="${character.height}">
                </div>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL *</label>
                <input type="url" class="form-control" name="image_url" value="${character.image_url}" required>
            </div>
            <div class="mb-3">
                <label for="youtube_clip_url" class="form-label">YouTube Clip URL</label>
                <input type="url" class="form-control" name="youtube_clip_url" value="${character.youtube_clip_url}">
            </div>
        `;
        $('#editCharacterBody').html(modalBody);
        new bootstrap.Modal(document.getElementById('editCharacterModal')).show();
    });
}

function editEpisode(id) {
    $.get('actions/get_episode.php', { id: id }, function(data) {
        const episode = JSON.parse(data);
        const modalBody = `
            <input type="hidden" name="id" value="${episode.id}">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label">Episode Title *</label>
                    <input type="text" class="form-control" name="title" value="${episode.title}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="air_date" class="form-label">Air Date</label>
                    <input type="date" class="form-control" name="air_date" value="${episode.air_date}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="season" class="form-label">Season *</label>
                    <input type="number" class="form-control" name="season" min="1" value="${episode.season}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="episode_number" class="form-label">Episode Number *</label>
                    <input type="number" class="form-control" name="episode_number" min="1" value="${episode.episode_number}" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control" name="description" rows="4" required>${episode.description}</textarea>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL *</label>
                <input type="url" class="form-control" name="image_url" value="${episode.image_url}" required>
            </div>
            <div class="mb-3">
                <label for="youtube_clip_url" class="form-label">YouTube Clip URL</label>
                <input type="url" class="form-control" name="youtube_clip_url" value="${episode.youtube_clip_url}">
            </div>
        `;
        $('#editEpisodeBody').html(modalBody);
        new bootstrap.Modal(document.getElementById('editEpisodeModal')).show();
    });
}

function editLocation(id) {
    $.get('actions/get_location.php', { id: id }, function(data) {
        const location = JSON.parse(data);
        const modalBody = `
            <input type="hidden" name="id" value="${location.id}">
            <div class="mb-3">
                <label for="name" class="form-label">Location Name *</label>
                <input type="text" class="form-control" name="name" value="${location.name}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control" name="description" rows="4" required>${location.description}</textarea>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL *</label>
                <input type="url" class="form-control" name="image_url" value="${location.image_url}" required>
            </div>
            <div class="mb-3">
                <label for="maps_url" class="form-label">Real-life Location Maps URL</label>
                <input type="url" class="form-control" name="maps_url" value="${location.maps_url}">
            </div>
        `;
        $('#editLocationBody').html(modalBody);
        new bootstrap.Modal(document.getElementById('editLocationModal')).show();
    });
}

function editQuote(id) {
    // For quotes, we need to load lists of characters and episodes too
    // But since the modal structure is dynamic, we can just grab the current quote data
    // and let the user select char/episode from IDs if we build the select lists.
    // However, re-building the select lists inside JS is tedious.
    // A simpler way: The edit modal could be static in PHP with empty values,
    // and we just fill them.
    // CHECK quotes.php again: The edit modal body is empty: <div class="modal-body" id="editQuoteBody">
    // So we must reconstruct the form.
    
    // We need to fetch the quote data AND the lists of characters/episodes to populate the dropdowns.
    // Or, we can just fetch the quote, and rely on the fact that we might not easily change char/episode via JS without the lists.
    // Let's implement a robust version that fetches the quote, but maybe simplifies the dropdowns or we just reload the page content? 
    // No, standard way:
    
    $.get('actions/get_quote.php', { id: id }, function(data) {
        const quote = JSON.parse(data);
        
        // We need the options for characters and episodes. 
        // We can grab them from the "Add Quote" modal which is already on the page!
        const charOptions = document.getElementById('character_id').innerHTML;
        const epOptions = document.getElementById('episode_id').innerHTML;
        
        const modalBody = `
            <input type="hidden" name="id" value="${quote.id}">
            <div class="mb-3">
                <label for="quote_text" class="form-label">Quote Text *</label>
                <textarea class="form-control" name="quote_text" rows="3" required>${quote.quote_text}</textarea>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description/Context</label>
                <textarea class="form-control" name="description" rows="3">${quote.description || ''}</textarea>
            </div>
            <div class="mb-3">
                <label for="edit_character_id" class="form-label">Character</label>
                <select class="form-select" name="character_id" id="edit_character_id">
                    ${charOptions}
                </select>
            </div>
            <div class="mb-3">
                <label for="edit_episode_id" class="form-label">Episode</label>
                <select class="form-select" name="episode_id" id="edit_episode_id">
                    ${epOptions}
                </select>
            </div>
        `;
        
        $('#editQuoteBody').html(modalBody);
        
        // Set selected values
        if(quote.character_id) document.getElementById('edit_character_id').value = quote.character_id;
        if(quote.episode_id) document.getElementById('edit_episode_id').value = quote.episode_id;
        
        new bootstrap.Modal(document.getElementById('editQuoteModal')).show();
    });
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

