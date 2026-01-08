<?php
$pageTitle = "Home";
require_once 'config/database.php';
require_once 'includes/header.php';

// Get counts
$characterCount = getCount('characters');
$episodeCount = getCount('episodes');
$quoteCount = getCount('quotes');
$locationCount = getCount('locations');

// Get quote of the day
$quoteOfDay = getQuoteOfTheDay();
?>

<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <img src="assets/image/Stranger_Things_logo.png" alt="Stranger Things Logo" class="page-header-logo mb-4">
                <h1>Welcome to Stranger Things Wiki</h1>
                <p class="lead">Your ultimate guide to the Upside Down and beyond!</p>
            </div>
        </div>
    </div>

    <!-- Counters Section -->
    <div class="row mb-5">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="counter-card">
                <i class="fas fa-users fa-3x mb-3" style="color: var(--stranger-red);"></i>
                <div class="counter-number"><?php echo $characterCount; ?></div>
                <div class="counter-label">Characters</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="counter-card">
                <i class="fas fa-film fa-3x mb-3" style="color: var(--stranger-red);"></i>
                <div class="counter-number"><?php echo $episodeCount; ?></div>
                <div class="counter-label">Episodes</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="counter-card">
                <i class="fas fa-quote-left fa-3x mb-3" style="color: var(--stranger-red);"></i>
                <div class="counter-number"><?php echo $quoteCount; ?></div>
                <div class="counter-label">Quotes</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="counter-card">
                <i class="fas fa-map-marker-alt fa-3x mb-3" style="color: var(--stranger-red);"></i>
                <div class="counter-number"><?php echo $locationCount; ?></div>
                <div class="counter-label">Locations</div>
            </div>
        </div>
    </div>

    <!-- Quote of the Day Section -->
    <?php if ($quoteOfDay): ?>
    <div class="row">
        <div class="col-12">
            <div class="quote-of-day">
                <h2 class="mb-4" style="color: var(--stranger-red);">
                    <i class="fas fa-quote-left"></i> Quote of the Day
                </h2>
                <p class="quote-text">"<?php echo htmlspecialchars($quoteOfDay['quote_text']); ?>"</p>
                <p class="quote-author">
                    — <?php echo $quoteOfDay['character_name'] ? htmlspecialchars($quoteOfDay['character_name']) : 'Unknown'; ?>
                    <?php if ($quoteOfDay['episode_title']): ?>
                        <small>(<?php echo htmlspecialchars($quoteOfDay['episode_title']); ?>)</small>
                    <?php endif; ?>
                </p>
                <?php if ($quoteOfDay['description']): ?>
                    <p class="mt-3" style="color: #ccc;">
                        <i class="fas fa-info-circle"></i> <?php echo htmlspecialchars($quoteOfDay['description']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Links Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4" style="color: var(--stranger-red);">
                <i class="fas fa-compass"></i> Explore the Wiki
            </h2>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="characters.php" class="text-decoration-none">
                <div class="counter-card">
                    <i class="fas fa-users fa-4x mb-3" style="color: var(--stranger-red);"></i>
                    <h4 style="color: var(--stranger-light);">Characters</h4>
                    <p style="color: #aaa;">Discover all the heroes and villains</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="episodes.php" class="text-decoration-none">
                <div class="counter-card">
                    <i class="fas fa-film fa-4x mb-3" style="color: var(--stranger-red);"></i>
                    <h4 style="color: var(--stranger-light);">Episodes</h4>
                    <p style="color: #aaa;">Relive every thrilling moment</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="quotes.php" class="text-decoration-none">
                <div class="counter-card">
                    <i class="fas fa-quote-left fa-4x mb-3" style="color: var(--stranger-red);"></i>
                    <h4 style="color: var(--stranger-light);">Quotes</h4>
                    <p style="color: #aaa;">Memorable lines from the show</p>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="locations.php" class="text-decoration-none">
                <div class="counter-card">
                    <i class="fas fa-map-marker-alt fa-4x mb-3" style="color: var(--stranger-red);"></i>
                    <h4 style="color: var(--stranger-light);">Locations</h4>
                    <p style="color: #aaa;">Visit iconic Hawkins locations</p>
                </div>
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>