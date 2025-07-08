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
                <div class="gallery-item-image">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>"
                        alt="<?= htmlspecialchars($row['titre']) ?>" />
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

<?php include 'footer.php'; ?>