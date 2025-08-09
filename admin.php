<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8" />
    <title>Admin - Biserica Harul</title>
    <link rel="shortcut icon" href="uploads/harul-geneva-logo-web.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #ffffff;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Container principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Titre principal */
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Navigation par onglets */
        .tab-navigation {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 1rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            font-weight: 500;
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .tab-btn.active {
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            color: #1a1a1a;
            border-color: transparent;
        }

        /* Sections d'onglets */
        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        /* Section wrapper */
        .section-wrapper {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(10px);
        }

        /* Titres de sections */
        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 2rem 0;
            color: #ffffff;
            border-left: 4px solid #ffffff;
            padding-left: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Grid pour formulaire et liste */
        .crud-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .crud-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Formulaires */
        form {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            height: fit-content;
        }

        form:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #ffffff;
            text-align: center;
        }

        /* Liste wrapper */
        .list-wrapper {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2rem;
            max-height: 600px;
            overflow-y: auto;
        }

        .list-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #ffffff;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
        }

        /* Inputs et textareas */
        input,
        textarea,
        select {
            width: 100%;
            padding: 0.875rem 1rem;
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        input::placeholder,
        textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Inputs de type file */
        input[type="file"] {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            padding: 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="file"]:hover {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Boutons principaux */
        button[type="submit"] {
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            color: #1a1a1a;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
            width: 100%;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
            background: linear-gradient(45deg, #f0f0f0, #d0d0d0);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        /* Boutons d'action (modifier, supprimer) */
        button[name="modifier_programme"],
        button[name="modifier_evenement"],
        button[name="modifier_media"] {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 0.5rem;
        }

        button[name="modifier_programme"]:hover,
        button[name="modifier_evenement"]:hover,
        button[name="modifier_media"]:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Liens de suppression */
        a[href*="supprimer"] {
            color: #ff4444;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: inline-block;
            border: 1px solid rgba(255, 68, 68, 0.3);
            font-size: 0.875rem;
        }

        a[href*="supprimer"]:hover {
            background: rgba(255, 68, 68, 0.1);
            color: #ff6666;
            border-color: rgba(255, 68, 68, 0.5);
        }

        /* Cards pour les listes */
        .list-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .list-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Actions wrapper */
        .item-actions {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            align-items: center;
        }

        /* Formulaires inline pour modifications */
        .edit-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            align-items: end;
            margin-top: 1rem;
        }

        .edit-form input:not([type="hidden"]),
        .edit-form textarea {
            margin-bottom: 0;
        }

        .edit-form button {
            height: fit-content;
        }

        /* Style pour les strong */
        strong {
            color: #ffffff;
            font-weight: 600;
            display: block;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.1rem;
        }

        /* Images dans les événements et médias */
        img {
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            margin-bottom: 1rem;
        }

        img:hover {
            transform: scale(1.05);
        }

        /* Style spécifique pour les images d'événements */
        .event-image {
            width: 100%;
            max-width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        /* Messages de succès et d'erreur */
        p[style*="color:green"] {
            background: rgba(76, 175, 80, 0.1) !important;
            border: 1px solid rgba(76, 175, 80, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            color: #4caf50 !important;
        }

        p[style*="color:red"] {
            background: rgba(244, 67, 54, 0.1) !important;
            border: 1px solid rgba(244, 67, 54, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
            color: #f44336 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            .logout-btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }

            .tab-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }

            form,
            .list-wrapper {
                padding: 1.5rem;
            }

            input,
            textarea {
                padding: 0.75rem;
            }

            .edit-form {
                grid-template-columns: 1fr;
            }

            .event-image {
                max-width: 100%;
                height: 150px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Badge de comptage */
        .count-badge {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        /* Bouton de déconnexion */
        .logout-btn {
            background: rgba(255, 68, 68, 0.1);
            border: 1px solid rgba(255, 68, 68, 0.3);
            color: #ff4444;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: rgba(255, 68, 68, 0.2);
            border-color: rgba(255, 68, 68, 0.5);
            color: #ff6666;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 68, 68, 0.2);
        }

        .logout-btn i {
            font-size: 1rem;
        }

        /* Label pour les champs optionnels */
        .optional-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: block;
        }
    </style>
</head>

<body>
    <section class="section" id="admin">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                <h1 style="margin: 0;">🛠️ Panoul de Administrare</h1>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Deconectare
                </a>
            </div>

            <!-- Navigation par onglets -->
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="showTab('programmes')">
                    📅 Programe
                    <span
                        class="count-badge"><?php echo $conn->query("SELECT COUNT(*) as count FROM programmes")->fetch_assoc()['count']; ?></span>
                </button>
                <button class="tab-btn" onclick="showTab('evenements')">
                    🎉 Evenimente
                    <span
                        class="count-badge"><?php echo $conn->query("SELECT COUNT(*) as count FROM evenements")->fetch_assoc()['count']; ?></span>
                </button>
                <button class="tab-btn" onclick="showTab('medias')">
                    📷 Media
                    <span
                        class="count-badge"><?php echo $conn->query("SELECT COUNT(*) as count FROM medias")->fetch_assoc()['count']; ?></span>
                </button>
            </div>

            <?php
            // AJOUT
            if (isset($_POST['ajouter_programme'])) {
                $stmt = $conn->prepare("INSERT INTO programmes (jour, heure_debut, heure_fin, titre, description) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $_POST['jour'], $_POST['heure_debut'], $_POST['heure_fin'], $_POST['titre_programme'], $_POST['description_programme']);
                echo $stmt->execute() ? "<p style='color:green;'>✅ Programul a fost adăugat</p>" : "<p style='color:red;'>❌ Eroare</p>";
            }

            if (isset($_POST['ajouter_evenement'])) {
                $image_url = null;

                // Gestion de l'upload d'image (optionnel)
                if (isset($_FILES['image_evenement']) && $_FILES['image_evenement']['error'] == 0) {
                    $targetDir = 'uploads/events/';
                    if (!file_exists($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }
                    $filename = time() . '_' . basename($_FILES['image_evenement']['name']);
                    $targetFile = $targetDir . $filename;

                    if (move_uploaded_file($_FILES['image_evenement']['tmp_name'], $targetFile)) {
                        $image_url = $targetFile;
                    }
                }

                $stmt = $conn->prepare("INSERT INTO evenements (titre, date, heure, lieu, description, image_url) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $_POST['titre_evenement'], $_POST['date'], $_POST['heure'], $_POST['lieu'], $_POST['description_evenement'], $image_url);
                echo $stmt->execute() ? "<p style='color:green;'>✅ Evenimentul a fost adăugat</p>" : "<p style='color:red;'>❌ Eroare</p>";
            }

            if (isset($_POST['ajouter_media'])) {
                if ($_FILES['image_media']['error'] == 0) {
                    $targetDir = 'uploads/';
                    if (!file_exists($targetDir)) mkdir($targetDir);
                    $filename = time() . '_' . basename($_FILES['image_media']['name']);
                    $targetFile = $targetDir . $filename;

                    if (move_uploaded_file($_FILES['image_media']['tmp_name'], $targetFile)) {
                        $stmt = $conn->prepare("INSERT INTO medias (titre, image_url, description) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $_POST['titre_media'], $targetFile, $_POST['description_media']);
                        echo $stmt->execute() ? "<p style='color:green;'>✅ Imaginea a fost adăugată</p>" : "<p style='color:red;'>❌ Eroare</p>";
                    }
                }
            }

            // SUPPRESSION
            if (isset($_GET['supprimer_programme'])) {
                $conn->query("DELETE FROM programmes WHERE id=" . intval($_GET['supprimer_programme']));
            }
            if (isset($_GET['supprimer_evenement'])) {
                $id = intval($_GET['supprimer_evenement']);
                // Supprimer l'image associée si elle existe
                $res = $conn->query("SELECT image_url FROM evenements WHERE id=$id");
                if ($img = $res->fetch_assoc()) {
                    if (!empty($img['image_url']) && file_exists($img['image_url'])) {
                        unlink($img['image_url']);
                    }
                }
                $conn->query("DELETE FROM evenements WHERE id=$id");
            }
            if (isset($_GET['supprimer_media'])) {
                $id = intval($_GET['supprimer_media']);
                $res = $conn->query("SELECT image_url FROM medias WHERE id=$id");
                if ($img = $res->fetch_assoc()) unlink($img['image_url']);
                $conn->query("DELETE FROM medias WHERE id=$id");
            }

            // MODIFICATION PROGRAMME
            if (isset($_POST['modifier_programme'])) {
                $stmt = $conn->prepare("UPDATE programmes SET jour=?, heure_debut=?, heure_fin=?, titre=?, description=? WHERE id=?");
                $stmt->bind_param("sssssi", $_POST['jour'], $_POST['heure_debut'], $_POST['heure_fin'], $_POST['titre_programme'], $_POST['description_programme'], $_POST['id']);
                $stmt->execute();
            }

            // MODIFICATION EVENEMENT
            if (isset($_POST['modifier_evenement'])) {
                $stmt = $conn->prepare("UPDATE evenements SET titre=?, date=?, heure=?, lieu=?, description=? WHERE id=?");
                $stmt->bind_param("sssssi", $_POST['titre_evenement'], $_POST['date'], $_POST['heure'], $_POST['lieu'], $_POST['description_evenement'], $_POST['id']);
                $stmt->execute();
            }

            // MODIFICATION MEDIA
            if (isset($_POST['modifier_media'])) {
                $stmt = $conn->prepare("UPDATE medias SET titre=?, description=? WHERE id=?");
                $stmt->bind_param("ssi", $_POST['titre_media'], $_POST['description_media'], $_POST['id']);
                $stmt->execute();
            }
            ?>

            <!-- SECTION PROGRAMMES -->
            <div id="programmes" class="tab-content active">
                <div class="section-wrapper">
                    <h2>📅 Gestionarea Programelor</h2>
                    <div class="crud-grid">
                        <form method="POST">
                            <div class="form-title">➕ Adăugați un Program</div>
                            <input name="jour" placeholder="Ziua (ex: Duminică)" required />
                            <input type="time" name="heure_debut" required />
                            <input type="time" name="heure_fin" required />
                            <input name="titre_programme" placeholder="Titlul programului" required />
                            <textarea name="description_programme" placeholder="Descrierea programului"></textarea>
                            <button type="submit" name="ajouter_programme">Adăugați Programul</button>
                        </form>

                        <div class="list-wrapper">
                            <div class="list-title">📋 Lista Programelor</div>
                            <?php
                            $res = $conn->query("SELECT * FROM programmes ORDER BY id DESC");
                            while ($r = $res->fetch_assoc()) {
                                echo "<div class='list-item'>
                                    <strong>{$r['jour']} - {$r['titre']}</strong>
                                    <div class='item-actions'>
                                        <a href='?supprimer_programme={$r['id']}'>Ștergeți</a>
                                    </div>
                                    <form method='POST' class='edit-form'>
                                        <input type='hidden' name='id' value='{$r['id']}'>
                                        <input name='jour' value='{$r['jour']}' placeholder='Ziua'>
                                        <input name='heure_debut' value='{$r['heure_debut']}' type='time'>
                                        <input name='heure_fin' value='{$r['heure_fin']}' type='time'>
                                        <input name='titre_programme' value='{$r['titre']}' placeholder='Titlu'>
                                        <textarea name='description_programme' placeholder='Descriere'>{$r['description']}</textarea>
                                        <button name='modifier_programme'>Modificați</button>
                                    </form>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION ÉVÉNEMENTS -->
            <div id="evenements" class="tab-content">
                <div class="section-wrapper">
                    <h2>🎉 Gestionarea Evenimentelor</h2>
                    <div class="crud-grid">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-title">➕ Adăugați un Eveniment</div>
                            <input name="titre_evenement" placeholder="Titlul evenimentului" required />
                            <input type="date" name="date" required />
                            <input type="time" name="heure" required />
                            <input name="lieu" placeholder="Locația evenimentului" required />
                            <textarea name="description_evenement" placeholder="Descrierea evenimentului"></textarea>
                            <label class="optional-label">📸 Fotografia evenimentului (opțional)</label>
                            <input type="file" name="image_evenement" accept="image/*" />
                            <button type="submit" name="ajouter_evenement">Adăugați Evenimentul</button>
                        </form>

                        <div class="list-wrapper">
                            <div class="list-title">📋 Lista Evenimentelor</div>
                            <?php
                            $res = $conn->query("SELECT * FROM evenements ORDER BY date DESC");
                            while ($r = $res->fetch_assoc()) {
                                echo "<div class='list-item'>";

                                // Affichage de l'image si elle existe
                                if (!empty($r['image_url']) && file_exists($r['image_url'])) {
                                    echo "<img src='{$r['image_url']}' class='event-image' alt='{$r['titre']}'>";
                                }

                                echo "<strong>{$r['date']} - {$r['titre']}</strong>
                                    <div class='item-actions'>
                                        <a href='?supprimer_evenement={$r['id']}'>Ștergeți</a>
                                    </div>
                                    <form method='POST' class='edit-form'>
                                        <input type='hidden' name='id' value='{$r['id']}'>
                                        <input name='titre_evenement' value='{$r['titre']}' placeholder='Titlu'>
                                        <input name='date' value='{$r['date']}' type='date'>
                                        <input name='heure' value='{$r['heure']}' type='time'>
                                        <input name='lieu' value='{$r['lieu']}' placeholder='Locația'>
                                        <textarea name='description_evenement' placeholder='Descriere'>{$r['description']}</textarea>
                                        <button name='modifier_evenement'>Modificați</button>
                                    </form>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION MÉDIAS -->
            <div id="medias" class="tab-content">
                <div class="section-wrapper">
                    <h2>📷 Gestionarea Media</h2>
                    <div class="crud-grid">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-title">➕ Adăugați un Media</div>
                            <input name="titre_media" placeholder="Titlul media" required />
                            <input type="file" name="image_media" accept="image/*" required />
                            <textarea name="description_media" placeholder="Descrierea media"></textarea>
                            <button type="submit" name="ajouter_media">Adăugați Media</button>
                        </form>

                        <div class="list-wrapper">
                            <div class="list-title">📋 Lista Media</div>
                            <?php
                            $res = $conn->query("SELECT * FROM medias ORDER BY id DESC");
                            while ($r = $res->fetch_assoc()) {
                                echo "<div class='list-item'>
                                    <img src='{$r['image_url']}' width='100' alt='{$r['titre']}'>
                                    <strong>{$r['titre']}</strong>
                                    <div class='item-actions'>
                                        <a href='?supprimer_media={$r['id']}'>Ștergeți</a>
                                    </div>
                                    <form method='POST' class='edit-form'>
                                        <input type='hidden' name='id' value='{$r['id']}'>
                                        <input name='titre_media' value='{$r['titre']}' placeholder='Titlu'>
                                        <textarea name='description_media' placeholder='Descriere'>{$r['description']}</textarea>
                                        <button name='modifier_media'>Modificați</button>
                                    </form>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function showTab(tabName) {
            // Ascunde toate tab-urile
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));

            // Dezactivează toate butoanele
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));

            // Afișează tab-ul selectat
            document.getElementById(tabName).classList.add('active');

            // Activează butonul corespunzător
            event.target.classList.add('active');
        }
    </script>
</body>

</html>