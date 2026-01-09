<?php
$pageTitle = "View Episode";
require_once 'config/database.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: episodes.php");
    exit;
}

$id = $_GET['id'];
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM episodes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$episode = $result->fetch_assoc();

if (!$episode) {
    header("Location: episodes.php");
    exit;
}
?>

<div class="container py-4">
    <!-- Back Button -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="episodes.php" class="btn btn-outline-stranger btn-lg">
                <i class="fas fa-arrow-left"></i> Back to Episodes
            </a>
        </div>
    </div>

    <!-- Episode View -->
    <!-- Row 1: Image and Details -->
    <div class="row g-4 mb-4">
        <!-- Left Column: Image -->
        <div class="col-lg-4">
            <div class="card-custom h-100 p-0 overflow-hidden">
                <img src="<?php echo htmlspecialchars($episode['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($episode['title']); ?>" 
                     class="img-fluid w-100" style="object-fit: cover; height: 100%; min-height: 400px;">
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="col-lg-8">
            <div class="card-custom h-100">
                <div class="card-body p-4">
                    <h1 class="display-5 mb-4" style="color: var(--stranger-red); font-weight: bold; line-height: 1.2;">
                        <?php echo htmlspecialchars($episode['title']); ?>
                    </h1>

                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: rgba(229, 9, 20, 0.1); border-left: 3px solid var(--stranger-red);">
                                    <div class="text-muted mb-1" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <i class="fas fa-layer-group me-2"></i>Season
                                    </div>
                                    <div class="fs-4 fw-bold"><?php echo htmlspecialchars($episode['season']); ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: rgba(229, 9, 20, 0.1); border-left: 3px solid var(--stranger-red);">
                                    <div class="text-muted mb-1" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <i class="fas fa-film me-2"></i>Episode
                                    </div>
                                    <div class="fs-4 fw-bold"><?php echo htmlspecialchars($episode['episode_number']); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($episode['air_date']): ?>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <h5 class="mb-2" style="color: var(--stranger-red); text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">
                            <i class="fas fa-calendar-alt me-2"></i>Air Date
                        </h5>
                        <p class="fs-5 mb-0"><?php echo date('F d, Y', strtotime($episode['air_date'])); ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <h5 class="mb-3" style="color: var(--stranger-red); text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">
                            <i class="fas fa-book-open me-2"></i>Synopsis
                        </h5>
                        <p class="fs-6 lh-lg" style="text-align: justify;"><?php echo nl2br(htmlspecialchars($episode['description'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: YouTube Viewer (Full Width) -->
    <?php if($episode['youtube_clip_url']): ?>
        <?php 
        $videoId = explode('v=', $episode['youtube_clip_url'])[1] ?? '';
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
                            title="<?php echo htmlspecialchars($episode['title']); ?>" 
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
    if (confirm('Are you sure you want to delete this episode?')) {
        $.ajax({
            url: 'actions/delete.php',
            type: 'POST',
            data: { type: type, id: id },
            success: function(response) {
                alert(response);
                window.location.href = 'episodes.php';
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
