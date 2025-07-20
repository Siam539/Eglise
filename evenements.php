<?php include 'header.php'; ?>

<!-- Secțiunea Evenimente -->
<section class="section" id="evenements">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-star"></i> Evenimente Speciale</div>
            <h2 class="section-title">Evenimente viitoare</h2>
            <p class="section-subtitle">Nu ratați evenimentele noastre care marchează viața comunității noastre.</p>
        </div>
        <div class="events-container scroll-reveal">
            <div class="events-list">
                <?php
                $res = $conn->query("SELECT * FROM evenements ORDER BY date ASC");
                while ($row = $res->fetch_assoc()):
                    $date = date_create($row['date']);
                ?>
                    <div class="event-item">
                        <div class="event-date">
                            <div class="event-day"><?= date_format($date, 'd') ?></div>
                            <div class="event-month"><?= strtoupper(date_format($date, 'M')) ?></div>
                        </div>

                        <!-- Section image de l'événement -->
                        <?php if (!empty($row['image_url']) && file_exists($row['image_url'])): ?>
                            <div class="event-image-container lightbox-trigger"
                                data-image="<?= htmlspecialchars($row['image_url']) ?>"
                                data-title="<?= htmlspecialchars($row['titre']) ?>">
                                <img src="<?= htmlspecialchars($row['image_url']) ?>"
                                    alt="<?= htmlspecialchars($row['titre']) ?>" class="event-image">
                                <div class="image-overlay">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="event-content">
                            <h4 class="event-title"><?= htmlspecialchars($row['titre']) ?></h4>
                            <div class="event-details">
                                <div class="event-detail"><i class="fas fa-clock"></i>
                                    <?= substr($row['heure'], 0, 5) ?></div>
                                <div class="event-detail"><i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($row['lieu']) ?></div>
                            </div>
                            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="lightbox-modal">
    <div class="lightbox-backdrop"></div>
    <div class="lightbox-content">
        <button class="lightbox-close" aria-label="Închide">
            <i class="fas fa-times"></i>
        </button>
        <img id="lightboxImage" class="lightbox-image" src="" alt="">
        <div id="lightboxCaption" class="lightbox-caption"></div>
    </div>
</div>

<?php include 'footer.php'; ?>