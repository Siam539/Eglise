<?php include 'header.php'; ?>

<!-- Secțiunea Programe -->
<section class="section section-alternate" id="programmes">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-calendar-alt"></i> Activitățile Noastre</div>
            <h2 class="section-title">Programele Noastre</h2>
            <p class="section-subtitle">Descoperiți diferitele noastre programe săptămânale concepute pentru a vă
                îmbogăți
                viața spirituală.</p>
        </div>
        <div class="programs-grid">
            <?php
            $res = $conn->query("SELECT * FROM programmes ORDER BY FIELD(jour, 'Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi')");
            while ($row = $res->fetch_assoc()):
            ?>
            <div class="program-card scroll-reveal">
                <div class="program-card-header">
                    <div class="program-card-day"><?= htmlspecialchars($row['jour']) ?></div>
                    <div class="program-card-time"><?= substr($row['heure_debut'], 0, 5) ?> -
                        <?= substr($row['heure_fin'], 0, 5) ?></div>
                </div>
                <div class="program-card-body">
                    <h3 class="program-card-title"><?= htmlspecialchars($row['titre']) ?></h3>
                    <p class="program-card-description"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    <div class="program-card-footer">
                        <a href="https://wa.me/41782298661" class="program-join-btn">Participați</a>
                    </div>
                </div>
            </div> <!-- 🛠️ ICI : balise fermée correctement -->
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>