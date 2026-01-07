<?php
$pageTitle = "Locations";
require_once 'config/database.php';
require_once 'includes/header.php';

// Get all locations
$conn = getDBConnection();
$query = "SELECT * FROM locations ORDER BY name ASC";
$result = $conn->query($query);
?>

<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1><i class="fas fa-map-marker-alt"></i> Locations</h1>
                <p class="lead">Explore the iconic places of Hawkins and beyond</p>
            </div>
        </div>
    </div>

    <!-- Add New Location Button -->
    <div class="row mb-4">
        <div class="col-12 text-end">
            <button class="btn btn-stranger btn-lg" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                <i class="fas fa-plus"></i> Add New Location
            </button>
        </div>
    </div>

    <!-- Locations Grid -->
    <div class="row">
        <?php while($location = $result->fetch_assoc()): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card-custom">
                <img src="<?php echo htmlspecialchars($location['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($location['name']); ?>" 
                     class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($location['name']); ?></h5>
                    <p class="card-text">
                        <?php echo htmlspecialchars(substr($location['description'], 0, 120)) . '...'; ?>
                    </p>
                    <div class="action-buttons d-flex flex-wrap justify-content-center">
                        <a href="view-location.php?id=<?php echo $location['id']; ?>" class="btn btn-sm btn-outline-stranger">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <button class="btn btn-sm btn-outline-stranger" 
                                onclick="editLocation(<?php echo $location['id']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="deleteItem('location', <?php echo $location['id']; ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/add_location.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Location Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
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
                        <label for="maps_url" class="form-label">Real-life Location Maps URL</label>
                        <input type="url" class="form-control" id="maps_url" name="maps_url" placeholder="Google Maps link">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-stranger">Add Location</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Location Modal -->
<div class="modal fade" id="viewLocationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewLocationTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewLocationBody">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Location Modal -->
<div class="modal fade" id="editLocationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/edit_location.php" method="POST">
                <div class="modal-body" id="editLocationBody">
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
function viewLocation(id) {
    $.ajax({
        url: 'actions/get_location.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const location = JSON.parse(data);
            $('#viewLocationTitle').html('<i class="fas fa-map-marker-alt"></i> ' + location.name);
            $('#viewLocationBody').html(`
                <div class="row">
                    <div class="col-md-5">
                        <img src="${location.image_url}" class="img-fluid rounded" alt="${location.name}">
                    </div>
                    <div class="col-md-7">
                        <p><strong style="color: var(--stranger-red);">Description:</strong></p>
                        <p>${location.description}</p>
                    </div>
                </div>
            `);
            $('#viewLocationModal').modal('show');
        }
    });
}

function editLocation(id) {
    $.ajax({
        url: 'actions/get_location.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const location = JSON.parse(data);
            $('#editLocationBody').html(`
                <input type="hidden" name="id" value="${location.id}">
                <div class="mb-3">
                    <label for="edit_name" class="form-label">Location Name *</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="${location.name}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_description" class="form-label">Description *</label>
                    <textarea class="form-control" id="edit_description" name="description" rows="4" required>${location.description}</textarea>
                </div>
                <div class="mb-3">
                    <label for="edit_image_url" class="form-label">Image URL *</label>
                    <input type="url" class="form-control" id="edit_image_url" name="image_url" value="${location.image_url}" required>
                </div>
                
                <div class="mb-3">
                    <label for="edit_maps_url" class="form-label">Real-life Location Maps URL</label>
                    <input type="url" class="form-control" id="edit_maps_url" name="maps_url" value="${location.maps_url || ''}" placeholder="Google Maps link">
                </div>
            `);
            $('#editLocationModal').modal('show');
        }
    });
}
</script>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>
