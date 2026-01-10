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
            <?php if (!empty($currentUser)): ?>
            <button class="btn btn-stranger btn-lg" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                <i class="fas fa-plus"></i> Add New Location
            </button>
            <?php endif; ?>
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
                    <p class="card-text description-preview">
                        <?php echo htmlspecialchars($location['description']); ?>
                    </p>
                    <div class="action-buttons d-flex flex-wrap justify-content-center">
                        <a href="view-location.php?id=<?php echo $location['id']; ?>" class="btn btn-sm btn-outline-stranger">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <?php if (!empty($currentUser)): ?>
                        <button class="btn btn-sm btn-outline-stranger" 
                                onclick="editLocation(<?php echo $location['id']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="deleteItem('location', <?php echo $location['id']; ?>)">
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

        <?php endif; ?>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>
