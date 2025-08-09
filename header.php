<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biserica Penticostală Harul Geneva</title>
    <link rel="shortcut icon" href="uploads/harul-geneva-logo-web.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Ecran de încărcare -->
    <div class="loader" id="loader">
        <div class="loader-content">
            <div class="loader-icon">
                <i class="fas fa-church"></i>
            </div>
            <div class="loader-text">Biserica Harul Geneva</div>
            <div class="loader-spinner"></div>
        </div>
    </div>

    <!-- Navigare -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">
                <div class="nav-logo-icon">
                    <img src="uploads/harul-geneva-logo-web.png" alt="Harul Geneva" srcset="uploads/harul-geneva-logo-web.png">
                </div>
                Harul Geneva
            </a>
            <ul class="nav-menu" id="navMenu">
                <?php
                $current_page = basename($_SERVER['PHP_SELF']);
                ?>
                <li><a href="index.php" class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>">Acasă</a>
                </li>
                <li><a href="apropos.php"
                        class="nav-link <?= ($current_page == 'apropos.php') ? 'active' : '' ?>">Despre
                        noi</a></li>
                <li><a href="programmes.php"
                        class="nav-link <?= ($current_page == 'programmes.php') ? 'active' : '' ?>">Programe</a></li>
                <li><a href="evenements.php"
                        class="nav-link <?= ($current_page == 'evenements.php') ? 'active' : '' ?>">Evenimente</a></li>
                <li><a href="medias.php"
                        class="nav-link <?= ($current_page == 'medias.php') ? 'active' : '' ?>">Media</a></li>
                <li><a href="contact.php"
                        class="nav-link <?= ($current_page == 'contact.php') ? 'active' : '' ?>">Contact</a></li>
            </ul>

            <button class="mobile-menu-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>