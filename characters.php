<?php
$pageTitle = "Characters";
require_once 'config/database.php';
require_once 'includes/header.php';

// Get all characters
$conn = getDBConnection();
$query = "SELECT * FROM characters ORDER BY name ASC";
$result = $conn->query($query);
?>

<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1><i class="fas fa-users"></i> Characters</h1>
                <p class="lead">Meet the heroes and villains of Hawkins</p>
            </div>
        </div>
    </div>

    <!-- Add New Character Button -->
    <div class="row mb-4">
        <div class="col-12 text-end">
            <?php if (!empty($currentUser)): ?>
            <button class="btn btn-stranger btn-lg" data-bs-toggle="modal" data-bs-target="#addCharacterModal">
                <i class="fas fa-plus"></i> Add New Character
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Characters Grid -->
    <div class="row">
        <?php while($character = $result->fetch_assoc()): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card-custom">
                <img src="<?php echo htmlspecialchars($character['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($character['name']); ?>" 
                     class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($character['name']); ?></h5>
                    <p class="card-text">
                        <strong style="color: var(--stranger-red);">Actor:</strong> 
                        <?php echo htmlspecialchars($character['actor_name']); ?>
                    </p>
                    <p class="card-text">
                        <?php echo htmlspecialchars(substr($character['description'], 0, 100)) . '...'; ?>
                    </p>
                    <div class="action-buttons d-flex flex-wrap justify-content-center">
                        <a href="view-character.php?id=<?php echo $character['id']; ?>" class="btn btn-sm btn-outline-stranger">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <?php if (!empty($currentUser)): ?>
                        <button class="btn btn-sm btn-outline-stranger" 
                                onclick="editCharacter(<?php echo $character['id']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="deleteItem('character', <?php echo $character['id']; ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php if (!empty($currentUser)): ?>
<!-- Add Character Modal -->
<div class="modal fade" id="addCharacterModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-plus"></i> Add New Character</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/add_character.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Character Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="actor_name" class="form-label">Actor Name *</label>
                        <input type="text" class="form-control" id="actor_name" name="actor_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="born_date" class="form-label">Born Date</label>
                            <input type="date" class="form-control" id="born_date" name="born_date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="height" class="form-label">Height</label>
                            <input type="text" class="form-control" id="height" name="height" placeholder="e.g., 5'10&quot;">
                        </div>
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
                    <button type="submit" class="btn btn-stranger">Add Character</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Character Modal -->
<div class="modal fade" id="viewCharacterModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCharacterTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewCharacterBody">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Character Modal -->
<div class="modal fade" id="editCharacterModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Character</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/edit_character.php" method="POST">
                <div class="modal-body" id="editCharacterBody">
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

        <?php endif; ?>

        <script>
function viewCharacter(id) {
    $.ajax({
        url: 'actions/get_character.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const character = JSON.parse(data);
            $('#viewCharacterTitle').html('<i class="fas fa-user"></i> ' + character.name);
            let youtubeEmbed = '';
            if (character.youtube_clip_url) {
                const videoId = character.youtube_clip_url.split('v=')[1]?.split('&')[0];
                if (videoId) {
                    youtubeEmbed = `<div class="mb-3"><iframe width="100%" height="400" src="https://www.youtube.com/embed/${videoId}" title="${character.name} Clip" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`;
                }
            }
            $('#viewCharacterBody').html(`
                <div class="row">
                    <div class="col-md-4">
                        <img src="${character.image_url}" class="img-fluid rounded" alt="${character.name}">
                    </div>
                    <div class="col-md-8">
                        <p><strong style="color: var(--stranger-red);">Actor:</strong> ${character.actor_name}</p>
                        <p><strong style="color: var(--stranger-red);">Description:</strong></p>
                        <p>${character.description}</p>
                    </div>
                </div>
                ${youtubeEmbed}
            `);
            $('#viewCharacterModal').modal('show');
        }
    });
}

function editCharacter(id) {
    $.ajax({
        url: 'actions/get_character.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const character = JSON.parse(data);
            $('#editCharacterBody').html(`
                <input type="hidden" name="id" value="${character.id}">
                <div class="mb-3">
                    <label for="edit_name" class="form-label">Character Name *</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="${character.name}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_actor_name" class="form-label">Actor Name *</label>
                    <input type="text" class="form-control" id="edit_actor_name" name="actor_name" value="${character.actor_name}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_description" class="form-label">Description *</label>
                    <textarea class="form-control" id="edit_description" name="description" rows="4" required>${character.description}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="edit_age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="edit_age" name="age" value="${character.age || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_born_date" class="form-label">Born Date</label>
                        <input type="date" class="form-control" id="edit_born_date" name="born_date" value="${character.born_date || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_height" class="form-label">Height</label>
                        <input type="text" class="form-control" id="edit_height" name="height" value="${character.height || ''}" placeholder="e.g., 5'10&quot;">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="edit_image_url" class="form-label">Image URL *</label>
                    <input type="url" class="form-control" id="edit_image_url" name="image_url" value="${character.image_url}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_youtube_clip_url" class="form-label">YouTube Clip URL</label>
                    <input type="url" class="form-control" id="edit_youtube_clip_url" name="youtube_clip_url" value="${character.youtube_clip_url || ''}">
                </div>
            `);
            $('#editCharacterModal').modal('show');
        }
    });
}
</script>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>
