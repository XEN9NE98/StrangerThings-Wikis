<?php
$pageTitle = "Episodes";
require_once 'config/database.php';
require_once 'includes/header.php';

// Get all episodes
$conn = getDBConnection();
$query = "SELECT * FROM episodes ORDER BY season ASC, episode_number ASC";
$result = $conn->query($query);
?>

<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1><i class="fas fa-film"></i> Episodes</h1>
                <p class="lead">Relive every thrilling moment from Stranger Things</p>
            </div>
        </div>
    </div>

    <!-- Add New Episode Button -->
    <div class="row mb-4">
        <div class="col-12 text-end">
            <button class="btn btn-stranger btn-lg" data-bs-toggle="modal" data-bs-target="#addEpisodeModal">
                <i class="fas fa-plus"></i> Add New Episode
            </button>
        </div>
    </div>

    <!-- Episodes Grid -->
    <div class="row">
        <?php while($episode = $result->fetch_assoc()): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card-custom">
                <img src="<?php echo htmlspecialchars($episode['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($episode['title']); ?>" 
                     class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($episode['title']); ?></h5>
                    <p class="card-text">
                        <strong style="color: var(--stranger-red);">Season:</strong> <?php echo $episode['season']; ?> | 
                        <strong style="color: var(--stranger-red);">Episode:</strong> <?php echo $episode['episode_number']; ?>
                    </p>
                    <?php if($episode['air_date']): ?>
                    <p class="card-text">
                        <strong style="color: var(--stranger-red);">Air Date:</strong> 
                        <?php echo date('F d, Y', strtotime($episode['air_date'])); ?>
                    </p>
                    <?php endif; ?>
                    <p class="card-text">
                        <?php echo htmlspecialchars(substr($episode['description'], 0, 100)) . '...'; ?>
                    </p>
                    <div class="action-buttons d-flex flex-wrap justify-content-center">
                        <a href="view-episode.php?id=<?php echo $episode['id']; ?>" class="btn btn-sm btn-outline-stranger">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <button class="btn btn-sm btn-outline-stranger" 
                                onclick="editEpisode(<?php echo $episode['id']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="deleteItem('episode', <?php echo $episode['id']; ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Add Episode Modal -->
<div class="modal fade" id="addEpisodeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Episode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/add_episode.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="title" class="form-label">Episode Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="air_date" class="form-label">Air Date</label>
                            <input type="date" class="form-control" id="air_date" name="air_date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="season" class="form-label">Season *</label>
                            <input type="number" class="form-control" id="season" name="season" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="episode_number" class="form-label">Episode Number *</label>
                            <input type="number" class="form-control" id="episode_number" name="episode_number" min="1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL *</label>
                        <input type="url" class="form-control" id="image_url" name="image_url" required>
                    </div>
                    <div class="mb-3">
                        <label for="youtube_clip_url" class="form-label">YouTube Clip URL</label>
                        <input type="url" class="form-control" id="youtube_clip_url" name="youtube_clip_url">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-stranger">Add Episode</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Episode Modal -->
<div class="modal fade" id="viewEpisodeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewEpisodeTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewEpisodeBody">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Episode Modal -->
<div class="modal fade" id="editEpisodeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Episode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/edit_episode.php" method="POST">
                <div class="modal-body" id="editEpisodeBody">
                    <!-- Content loaded via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-stranger">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function viewEpisode(id) {
    $.ajax({
        url: 'actions/get_episode.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const episode = JSON.parse(data);
            $('#viewEpisodeTitle').html('<i class="fas fa-film"></i> ' + episode.title);
            let youtubeEmbed = '';
            if (episode.youtube_clip_url) {
                const videoId = episode.youtube_clip_url.split('v=')[1]?.split('&')[0];
                if (videoId) {
                    youtubeEmbed = `<div class="mb-3"><iframe width="100%" height="400" src="https://www.youtube.com/embed/${videoId}" title="${episode.title}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`;
                }
            }
            $('#viewEpisodeBody').html(`
                <div class="row">
                    <div class="col-md-5">
                        <img src="${episode.image_url}" class="img-fluid rounded" alt="${episode.title}">
                    </div>
                    <div class="col-md-7">
                        <p><strong style="color: var(--stranger-red);">Season:</strong> ${episode.season}</p>
                        <p><strong style="color: var(--stranger-red);">Episode:</strong> ${episode.episode_number}</p>
                        ${episode.air_date ? `<p><strong style="color: var(--stranger-red);">Air Date:</strong> ${new Date(episode.air_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>` : ''}
                        <p><strong style="color: var(--stranger-red);">Description:</strong></p>
                        <p>${episode.description}</p>
                    </div>
                </div>
                ${youtubeEmbed}
            `);
            $('#viewEpisodeModal').modal('show');
        }
    });
}

function editEpisode(id) {
    $.ajax({
        url: 'actions/get_episode.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const episode = JSON.parse(data);
            $('#editEpisodeBody').html(`
                <input type="hidden" name="id" value="${episode.id}">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="edit_title" class="form-label">Episode Title *</label>
                        <input type="text" class="form-control" id="edit_title" name="title" value="${episode.title}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_air_date" class="form-label">Air Date</label>
                        <input type="date" class="form-control" id="edit_air_date" name="air_date" value="${episode.air_date || ''}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_season" class="form-label">Season *</label>
                        <input type="number" class="form-control" id="edit_season" name="season" value="${episode.season}" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_episode_number" class="form-label">Episode Number *</label>
                        <input type="number" class="form-control" id="edit_episode_number" name="episode_number" value="${episode.episode_number}" min="1" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="edit_description" class="form-label">Description *</label>
                    <textarea class="form-control" id="edit_description" name="description" rows="4" required>${episode.description}</textarea>
                </div>
                <div class="mb-3">
                    <label for="edit_image_url" class="form-label">Image URL *</label>
                    <input type="url" class="form-control" id="edit_image_url" name="image_url" value="${episode.image_url}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_youtube_clip_url" class="form-label">YouTube Clip URL</label>
                    <input type="url" class="form-control" id="edit_youtube_clip_url" name="youtube_clip_url" value="${episode.youtube_clip_url || ''}">
                </div>
            `);
            $('#editEpisodeModal').modal('show');
        }
    });
}
</script>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>
