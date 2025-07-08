<?php include 'header.php'; ?>

<section class="section section-alternate" id="contact">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">
                <i class="fas fa-envelope"></i>
                Să rămânem în Contact
            </div>
            <h2 class="section-title">Contactați-ne</h2>
            <p class="section-subtitle">
                Ne-ar face plăcere să vă primim în comunitatea noastră.
                Nu ezitați să ne contactați pentru orice întrebare.
            </p>
        </div>

        <!-- DIV 1 : Contact Info + WhatsApp (Horizontale pleine largeur) -->
        <div class="contact-section-top">
            <div class="contact-info-modern">
                <h3><i class="fas fa-address-book"></i> Coordonatele Noastre</h3>

                <!-- 3 cartes en haut -->
                <div class="contact-cards-row">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Adresa Noastră</h4>
                            <p>Chemin de la Mousse 10<br>1225 Chêne-Bourg, Geneva</p>
                        </div>
                    </div>
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Telefon</h4>
                            <p>+41 78 632 77 52<br>Disponibil 7 zile/7</p>
                        </div>
                    </div>
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Email</h4>
                            <p>contact@bisericaharul.ch<br>Răspuns în 24h</p>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp pleine largeur en bas -->
                <div class="whatsapp-section-full">
                    <div class="whatsapp-content">
                        <div class="whatsapp-icon-large">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="whatsapp-text">
                            <h4>Contactați-ne pe WhatsApp</h4>
                            <p>Pentru un răspuns rapid, scrieți-ne direct pe WhatsApp!</p>
                        </div>
                        <a href="https://wa.me/41782298661" target="_blank" class="whatsapp-btn-large">
                            <i class="fab fa-whatsapp"></i>
                            Scrieți acum
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- DIV 2 : Carte (Horizontale pleine largeur) -->
        <div class="map-section-full">
            <div class="map-header-modern">
                <h3><i class="fas fa-map-marked-alt"></i> Veniți să ne întâlniți</h3>
                <p>Descoperiți locația noastră în inima Genevei</p>
            </div>
            <div class="map-wrapper-full">
                <iframe
                    src="https://www.google.com/maps?q=Chemin%20de%20la%20Mousse%2010%2C%201225%20Chêne-Bourg&output=embed"
                    width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>