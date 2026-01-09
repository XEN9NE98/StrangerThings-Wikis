<?php
$pageTitle = "Quotes";
require_once 'config/database.php';
require_once 'includes/header.php';

// Get all quotes with character and episode info
$conn = getDBConnection();
$query = "SELECT q.*, c.name as character_name, e.title as episode_title 
          FROM quotes q 
          LEFT JOIN characters c ON q.character_id = c.id 
          LEFT JOIN episodes e ON q.episode_id = e.id 
          ORDER BY q.created_at DESC";
$result = $conn->query($query);

// Get all characters for dropdown
$charactersQuery = "SELECT id, name FROM characters ORDER BY name ASC";
$charactersResult = $conn->query($charactersQuery);
$characters = [];
while($char = $charactersResult->fetch_assoc()) {
    $characters[] = $char;
}

// Get all episodes for dropdown
$episodesQuery = "SELECT id, title, season, episode_number FROM episodes ORDER BY season ASC, episode_number ASC";
$episodesResult = $conn->query($episodesQuery);
$episodes = [];
while($ep = $episodesResult->fetch_assoc()) {
    $episodes[] = $ep;
}
?>

<div class="container">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1><i class="fas fa-quote-left"></i> Quotes</h1>
                <p class="lead">Memorable lines from Stranger Things</p>
            </div>
        </div>
    </div>

    <!-- Add New Quote Button -->
    <div class="row mb-4">
        <div class="col-12 text-end">
            <?php if (!empty($currentUser)): ?>
            <button class="btn btn-stranger btn-lg" data-bs-toggle="modal" data-bs-target="#addQuoteModal">
                <i class="fas fa-plus"></i> Add New Quote
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quotes Grid -->
    <div class="row">
        <?php while($quote = $result->fetch_assoc()): ?>
        <div class="col-lg-6 mb-4">
            <div class="card-custom" style="height: auto;">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-quote-left" style="color: var(--stranger-red); font-size: 2rem;"></i>
                    </div>
                    <h5 class="card-title" style="font-size: 1.3rem; font-style: italic;">
                        "<?php echo htmlspecialchars($quote['quote_text']); ?>"
                    </h5>
                    
                    <?php if($quote['description']): ?>
                    <p class="card-text mt-3">
                        <strong style="color: var(--stranger-red);">Context:</strong><br>
                        <?php echo htmlspecialchars($quote['description']); ?>
                    </p>
                    <?php endif; ?>
                    
                    <div class="mt-3">
                        <?php if($quote['character_name']): ?>
                        <p class="card-text mb-1">
                            <i class="fas fa-user"></i> 
                            <strong style="color: var(--stranger-red);">Character:</strong> 
                            <?php echo htmlspecialchars($quote['character_name']); ?>
                        </p>
                        <?php endif; ?>
                        
                        <?php if($quote['episode_title']): ?>
                        <p class="card-text mb-1">
                            <i class="fas fa-film"></i> 
                            <strong style="color: var(--stranger-red);">Episode:</strong> 
                            <?php echo htmlspecialchars($quote['episode_title']); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="action-buttons d-flex flex-wrap justify-content-center mt-3">
                        <?php if (!empty($currentUser)): ?>
                        <button class="btn btn-sm btn-outline-stranger" 
                                onclick="editQuote(<?php echo $quote['id']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" 
                                onclick="deleteItem('quote', <?php echo $quote['id']; ?>)">
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
<!-- Add Quote Modal -->
<div class="modal fade" id="addQuoteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Quote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/add_quote.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quote_text" class="form-label">Quote Text *</label>
                        <textarea class="form-control" id="quote_text" name="quote_text" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description/Context</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="character_id" class="form-label">Character</label>
                        <select class="form-select" id="character_id" name="character_id">
                            <option value="">-- Select Character --</option>
                            <?php foreach($characters as $char): ?>
                                <option value="<?php echo $char['id']; ?>"><?php echo htmlspecialchars($char['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="episode_id" class="form-label">Episode</label>
                        <select class="form-select" id="episode_id" name="episode_id">
                            <option value="">-- Select Episode --</option>
                            <?php foreach($episodes as $ep): ?>
                                <option value="<?php echo $ep['id']; ?>">
                                    S<?php echo $ep['season']; ?>E<?php echo $ep['episode_number']; ?> - <?php echo htmlspecialchars($ep['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-stranger">Add Quote</button>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>

        <!-- View Quote Modal -->
<div class="modal fade" id="viewQuoteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-quote-left"></i> Quote Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewQuoteBody">
                <!-- Content loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Quote Modal -->
<div class="modal fade" id="editQuoteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Quote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="actions/edit_quote.php" method="POST">
                <div class="modal-body" id="editQuoteBody">
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
const characters = <?php echo json_encode($characters); ?>;
const episodes = <?php echo json_encode($episodes); ?>;

function viewQuote(id) {
    $.ajax({
        url: 'actions/get_quote.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const quote = JSON.parse(data);
            $('#viewQuoteBody').html(`
                <div class="quote-of-day">
                    <p class="quote-text">"${quote.quote_text}"</p>
                    ${quote.description ? `<p><strong style="color: var(--stranger-red);">Context:</strong><br>${quote.description}</p>` : ''}
                    ${quote.character_name ? `<p><strong style="color: var(--stranger-red);">Said by:</strong> ${quote.character_name}</p>` : ''}
                    ${quote.episode_title ? `<p><strong style="color: var(--stranger-red);">From Episode:</strong> ${quote.episode_title}</p>` : ''}
                </div>
            `);
            $('#viewQuoteModal').modal('show');
        }
    });
}

function editQuote(id) {
    $.ajax({
        url: 'actions/get_quote.php',
        type: 'GET',
        data: { id: id },
        success: function(data) {
            const quote = JSON.parse(data);
            let characterOptions = '<option value="">-- Select Character --</option>';
            characters.forEach(char => {
                characterOptions += `<option value="${char.id}" ${quote.character_id == char.id ? 'selected' : ''}>${char.name}</option>`;
            });
            
            let episodeOptions = '<option value="">-- Select Episode --</option>';
            episodes.forEach(ep => {
                episodeOptions += `<option value="${ep.id}" ${quote.episode_id == ep.id ? 'selected' : ''}>S${ep.season}E${ep.episode_number} - ${ep.title}</option>`;
            });
            
            $('#editQuoteBody').html(`
                <input type="hidden" name="id" value="${quote.id}">
                <div class="mb-3">
                    <label for="edit_quote_text" class="form-label">Quote Text *</label>
                    <textarea class="form-control" id="edit_quote_text" name="quote_text" rows="3" required>${quote.quote_text}</textarea>
                </div>
                <div class="mb-3">
                    <label for="edit_description" class="form-label">Description/Context</label>
                    <textarea class="form-control" id="edit_description" name="description" rows="3">${quote.description || ''}</textarea>
                </div>
                <div class="mb-3">
                    <label for="edit_character_id" class="form-label">Character</label>
                    <select class="form-select" id="edit_character_id" name="character_id">
                        ${characterOptions}
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_episode_id" class="form-label">Episode</label>
                    <select class="form-select" id="edit_episode_id" name="episode_id">
                        ${episodeOptions}
                    </select>
                </div>
            `);
            $('#editQuoteModal').modal('show');
        }
    });
}
</script>

<?php 
$conn->close();
require_once 'includes/footer.php'; 
?>
