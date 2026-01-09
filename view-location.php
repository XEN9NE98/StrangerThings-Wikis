<?php
$pageTitle = "View Location";
require_once 'config/database.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: locations.php");
    exit;
}

$id = $_GET['id'];
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM locations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$location = $result->fetch_assoc();

if (!$location) {
    header("Location: locations.php");
    exit;
}
?>

<div class="container">
    <!-- Back Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="locations.php" class="btn btn-outline-stranger btn-lg">
                <i class="fas fa-arrow-left"></i> Back to Locations
            </a>
        </div>
    </div>

    <!-- Location View -->
    <!-- Row 1: Image and Details -->
    <div class="row g-4 mb-4">
        <!-- Left Column: Image -->
        <div class="col-lg-4">
            <div class="card-custom h-100 p-0 overflow-hidden">
                <img src="<?php echo htmlspecialchars($location['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($location['name']); ?>" 
                     class="img-fluid w-100" style="object-fit: cover; height: 100%; min-height: 400px;">
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="col-lg-8">
            <div class="card-custom h-100">
                <div class="card-body p-4">
                    <h1 class="display-5 mb-4" style="color: var(--stranger-red); font-weight: bold; line-height: 1.2;">
                        <?php echo htmlspecialchars($location['name']); ?>
                    </h1>

                    <div class="mb-4">
                        <h5 class="mb-3" style="color: var(--stranger-red); text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">
                            <i class="fas fa-map-marker-alt me-2"></i>Description
                        </h5>
                        <p class="fs-6 lh-lg" style="text-align: justify;"><?php echo nl2br(htmlspecialchars($location['description'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Real-Life Location Button (Full Width) -->
    <?php if(!empty($location['maps_url'])): ?>
    <div class="row">
        <div class="col-12">
            <a href="<?php echo htmlspecialchars($location['maps_url']); ?>" target="_blank" rel="noopener" class="btn btn-outline-stranger btn-lg w-100">
                <i class="fas fa-map-location-dot me-2"></i> View Real-Life Location
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function deleteAndReturn(type, id) {
    if (confirm('Are you sure you want to delete this location?')) {
        $.ajax({
            url: 'actions/delete.php',
            type: 'POST',
            data: { type: type, id: id },
            success: function(response) {
                alert(response);
                window.location.href = 'locations.php';
            },
            error: function() {
                alert('Error deleting item');
            }
        });
    }
}
</script>

<?php 
$stmt->close();
$conn->close();
require_once 'includes/footer.php'; 
?>
