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
                            <div class="event-image-container">
                                <img src="<?= htmlspecialchars($row['image_url']) ?>"
                                    alt="<?= htmlspecialchars($row['titre']) ?>" class="event-image clickable-image"
                                    data-src="<?= htmlspecialchars($row['image_url']) ?>"
                                    data-title="<?= htmlspecialchars($row['titre']) ?>">
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

<!-- Modal pentru mărirea imaginilor -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <span class="close-modal" onclick="closeImageModal()">&times;</span>
        <img id="modalImage" src="" alt="">
        <div class="modal-caption" id="modalCaption"></div>
    </div>
</div>

<style>
    /* Styles pour le modal - directement dans la page pour éviter les conflits */
    .image-modal {
        display: none !important;
        position: fixed !important;
        z-index: 99999 !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background-color: rgba(0, 0, 0, 0.9) !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .image-modal.show {
        display: flex !important;
    }

    .modal-content {
        position: relative !important;
        max-width: 90% !important;
        max-height: 90% !important;
        text-align: center !important;
    }

    .modal-content img {
        width: auto !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: 80vh !important;
        object-fit: contain !important;
        border-radius: 12px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }

    .close-modal {
        position: absolute !important;
        top: -40px !important;
        right: 0 !important;
        color: white !important;
        font-size: 2.5rem !important;
        font-weight: bold !important;
        cursor: pointer !important;
        z-index: 100000 !important;
        background: rgba(0, 0, 0, 0.5) !important;
        border-radius: 50% !important;
        width: 40px !important;
        height: 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        line-height: 1 !important;
    }

    .close-modal:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        transform: scale(1.1) !important;
    }

    .modal-caption {
        color: white !important;
        font-size: 1.25rem !important;
        font-weight: 600 !important;
        margin-top: 1rem !important;
        padding: 1rem !important;
        background: rgba(0, 0, 0, 0.7) !important;
        border-radius: 8px !important;
    }

    .event-image-container {
        position: relative !important;
        cursor: pointer !important;
    }

    .image-overlay {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background: rgba(0, 0, 0, 0.7) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        opacity: 0 !important;
        transition: opacity 0.3s ease !important;
        color: white !important;
        font-size: 1.5rem !important;
        border-radius: 8px !important;
    }

    .event-image-container:hover .image-overlay {
        opacity: 1 !important;
    }

    @media (max-width: 768px) {
        .modal-content {
            max-width: 95% !important;
        }

        .close-modal {
            top: -30px !important;
            font-size: 2rem !important;
        }
    }
</style>

<script>
    // JavaScript pour le modal - avec event listeners
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Pagina încărcată, inițializarea modalului');

        // Ajouter les event listeners à toutes les images cliquables
        const clickableImages = document.querySelectorAll('.clickable-image');
        console.log('Imagini găsite:', clickableImages.length);

        clickableImages.forEach(function(img) {
            img.addEventListener('click', function() {
                const imageSrc = this.getAttribute('data-src');
                const imageTitle = this.getAttribute('data-title');
                console.log('Imagine apăsată:', imageSrc, imageTitle);
                openImageModal(imageSrc, imageTitle);
            });
        });
    });

    function openImageModal(imageSrc, imageAlt) {
        console.log('Deschiderea modalului cu:', imageSrc, imageAlt);

        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const caption = document.getElementById('modalCaption');

        if (!modal || !modalImg || !caption) {
            console.error('Elementele modalului nu au fost găsite');
            return;
        }

        modal.classList.add('show');
        modalImg.src = imageSrc;
        modalImg.alt = imageAlt;
        caption.innerHTML = imageAlt;

        // Empêcher le scroll du body
        document.body.style.overflow = 'hidden';

        console.log('Modal deschis');
    }

    function closeImageModal() {
        console.log('Închiderea modalului');

        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.classList.remove('show');
            // Réactiver le scroll du body
            document.body.style.overflow = 'auto';
        }
    }
</script>

<?php include 'footer.php'; ?>