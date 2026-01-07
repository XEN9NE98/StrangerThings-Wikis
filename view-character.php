<?php
$pageTitle = "View Character";
require_once 'config/database.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: characters.php");
    exit;
}

$id = $_GET['id'];
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM characters WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$character = $result->fetch_assoc();

if (!$character) {
    header("Location: characters.php");
    exit;
}
?>

<div class="container py-4">
    <!-- Back Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="characters.php" class="btn btn-outline-stranger btn-lg">
                <i class="fas fa-arrow-left"></i> Back to Characters
            </a>
        </div>
    </div>

    <!-- Character View -->
    <!-- Row 1: Image and Details -->
    <div class="row g-4 mb-4">
        <!-- Left Column: Image -->
        <div class="col-lg-4">
            <div class="card-custom h-100 p-0 overflow-hidden">
                <img src="<?php echo htmlspecialchars($character['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($character['name']); ?>" 
                     class="img-fluid w-100" style="object-fit: cover; height: 100%; min-height: 400px;">
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="col-lg-8">
            <div class="card-custom h-100">
                <div class="card-body p-4">
                    <h1 class="display-4 mb-4" style="color: var(--stranger-red); font-weight: bold;">
                        <?php echo htmlspecialchars($character['name']); ?>
                    </h1>

                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <h5 class="mb-2" style="color: var(--stranger-red); text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">
                            <i class="fas fa-user-circle me-2"></i>Portrayed By
                        </h5>
                        <p class="fs-5 mb-0"><?php echo htmlspecialchars($character['actor_name']); ?></p>
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3" style="color: var(--stranger-red); text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">
                            <i class="fas fa-book-open me-2"></i>About
                        </h5>
                        <p class="fs-6 lh-lg" style="text-align: justify;"><?php echo nl2br(htmlspecialchars($character['description'])); ?></p>
                    </div>

                    <?php if($character['age'] || $character['born_date'] || $character['height']): ?>
                    <div class="mt-4 pt-4 border-top border-secondary">
                        <h5 class="mb-3" style="color: var(--stranger-red); text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">
                            <i class="fas fa-info-circle me-2"></i>Character Details
                        </h5>
                        <div class="row g-3">
                            <?php if($character['age']): ?>
                            <div class="col-md-4">
                                <div class="p-3 rounded" style="background: rgba(229, 9, 20, 0.1); border-left: 3px solid var(--stranger-red);">
                                    <div class="text-muted mb-1" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Age</div>
                                    <div class="fs-5 fw-bold"><?php echo htmlspecialchars($character['age']); ?> years</div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($character['born_date']): ?>
                            <div class="col-md-4">
                                <div class="p-3 rounded" style="background: rgba(229, 9, 20, 0.1); border-left: 3px solid var(--stranger-red);">
                                    <div class="text-muted mb-1" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Born</div>
                                    <div class="fs-5 fw-bold"><?php echo date('F d, Y', strtotime($character['born_date'])); ?></div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if($character['height']): ?>
                            <div class="col-md-4">
                                <div class="p-3 rounded" style="background: rgba(229, 9, 20, 0.1); border-left: 3px solid var(--stranger-red);">
                                    <div class="text-muted mb-1" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Height</div>
                                    <div class="fs-5 fw-bold"><?php echo htmlspecialchars($character['height']); ?></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: YouTube Viewer (Full Width) -->
    <?php if($character['youtube_clip_url']): ?>
        <?php 
        $videoId = explode('v=', $character['youtube_clip_url'])[1] ?? '';
        $videoId = explode('&', $videoId)[0];
        if ($videoId): 
        ?>
    <div class="row">
        <div class="col-12">
            <div class="card-custom">
                <div class="card-body p-0">
                    <div class="ratio ratio-16x9" style="max-height: 600px;">
                        <iframe 
                            src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId); ?>" 
                            title="<?php echo htmlspecialchars($character['name']); ?> Clip" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
function deleteAndReturn(type, id) {
    if (confirm('Are you sure you want to delete this character?')) {
        $.ajax({
            url: 'actions/delete.php',
            type: 'POST',
            data: { type: type, id: id },
            success: function(response) {
                alert(response);
                window.location.href = 'characters.php';
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
