<?php include 'header.php'; ?>

<!-- Secțiunea Media -->
<section class="section" id="medias">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-camera"></i> Momentele Noastre</div>
            <h2 class="section-title">Galeria Foto</h2>
            <p class="section-subtitle">Descoperiți momentele importante ale comunității noastre prin aceste fotografii.
            </p>
        </div>
        <div class="gallery-grid">
            <?php
            $res = $conn->query("SELECT * FROM medias ORDER BY id DESC");
            while ($row = $res->fetch_assoc()):
            ?>
                <div class="gallery-item scroll-reveal">
                    <div class="gallery-item-image lightbox-trigger"
                        data-image="<?= htmlspecialchars($row['image_url']) ?>"
                        data-title="<?= htmlspecialchars($row['titre']) ?>">
                        <img src="<?= htmlspecialchars($row['image_url']) ?>"
                            alt="<?= htmlspecialchars($row['titre']) ?>" />
                        <div class="image-overlay">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </div>
                    </div>
                    <div class="gallery-item-content">
                        <h3 class="gallery-item-title"><?= htmlspecialchars($row['titre']) ?></h3>
                        <p class="gallery-item-description"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Lightbox Modal (reusing the same modal from events) -->
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