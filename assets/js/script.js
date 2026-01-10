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

/* Background music (YouTube IFrame) */
(function(){
    // Video ID from provided YouTube link
    const YT_VIDEO_ID = 'Jmv5pTyz--I';
    let player;
    let isPlaying = false;

    // Load YouTube IFrame API
    function loadYouTubeAPI(cb) {
        if (window.YT && window.YT.Player) return cb();
        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        window.onYouTubeIframeAPIReady = cb;
    }

    function createPlayer() {
        player = new YT.Player('yt-player', {
            height: '0',
            width: '0',
            videoId: YT_VIDEO_ID,
            playerVars: {
                autoplay: 1,
                controls: 0,
                loop: 1,
                modestbranding: 1,
                rel: 0,
                iv_load_policy: 3,
                playsinline: 1,
                playlist: YT_VIDEO_ID
            },
            events: {
                onReady: function(e) {
                    // Attempt to autoplay; many browsers block autoplay with sound.
                    const pref = localStorage.getItem('bgmEnabled');
                    const shouldPlay = pref === null ? true : (pref === '1');
                    if (shouldPlay) {
                        try {
                            e.target.playVideo();
                        } catch (err) {
                            // ignore
                        }
                    }
                    updateAudioIcon(shouldPlay && e.target.getPlayerState() === YT.PlayerState.PLAYING);
                },
                onStateChange: function(e) {
                    // If video ended, try to loop (safety in addition to playerVars.loop)
                    if (e.data === YT.PlayerState.ENDED) {
                        try { e.target.playVideo(); } catch (err) {}
                    }
                    // Update icon based on playing or paused
                    const playing = e.data === YT.PlayerState.PLAYING;
                    isPlaying = playing;
                    updateAudioIcon(playing);
                }
            }
        });
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
        if (!player) {
            loadYouTubeAPI(function(){ createPlayer(); });
            // wait a moment then set enabled flag
            localStorage.setItem('bgmEnabled', '1');
            return;
        }
        if (isPlaying) {
            player.pauseVideo();
            localStorage.setItem('bgmEnabled', '0');
        } else {
            player.playVideo();
            localStorage.setItem('bgmEnabled', '1');
        }
    }

    // Wire the navbar button
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('audioToggle');
        if (!btn) return;
        btn.addEventListener('click', function(e){
            e.preventDefault();
            toggleAudio();
        });

        // Initialize player if preference says enabled
        const pref = localStorage.getItem('bgmEnabled');
        const shouldAutoLoad = pref === null ? true : (pref === '1');
        if (shouldAutoLoad) {
            loadYouTubeAPI(function(){ createPlayer(); });
        } else {
            updateAudioIcon(false);
        }
    });
})();

