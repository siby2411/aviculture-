<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie - Omega Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .upload-area {
            border: 2px dashed var(--primary-green);
            padding: 3rem;
            border-radius: 12px;
            text-align: center;
            margin: 2rem 0;
            background: white;
            transition: all 0.3s;
        }
        .upload-area:hover { border-color: var(--omega-gold); background: #f7fafc; }
        .upload-area input[type="file"] { display: none; }
        .upload-btn {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
        }
        .upload-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(45, 106, 79, 0.3); }
        .gallery-grid-upload {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .gallery-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            position: relative;
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .gallery-item .info {
            padding: 0.75rem;
            text-align: center;
        }
        .gallery-item .name {
            font-weight: 600;
            color: var(--primary-green);
        }
        .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: rgba(229, 62, 62, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 1rem;
        }
        .delete-btn:hover { background: #E53E3E; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
        .btn-gold { background: linear-gradient(135deg, #D69E2E, #B7791F); color: white; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><span class="logo-icon">🐔</span><span>Aviculture</span></div>
        <div class="logo-sub">OMEGA INFORMATIQUE CONSULTING<div class="omega-badge">⭐ GESTION AVICOLE</div></div>
        <nav>
            <a href="/?route=dashboard">📊 Tableau de bord</a>
            <a href="/?route=lots">🐓 Lots</a>
            <a href="/?route=ventes">💰 Ventes</a>
            <a href="/?route=charges">💳 Charges</a>
            <a href="/?route=rapports">📋 Rapports</a>
            <a href="/?route=upload" class="active">📸 Galerie</a>
        </nav>
        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.7rem; text-align: center; opacity: 0.6;">v2.0 • OMEGA CONSULTING</div>
    </div>

    <div class="main-content">
        <h1 class="section-title">📸 Galerie des Poulets</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div style="background: #C6F6D5; color: #22543D; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background: #FED7D7; color: #9B2C2C; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="upload-area">
            <h3>📤 Uploader une nouvelle image</h3>
            <p style="color: #718096; margin: 1rem 0;">Formats: JPG, PNG, WEBP (max 5MB)</p>
            <form method="POST" enctype="multipart/form-data">
                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                        <label for="poultryImage" style="background: #e2e8f0; padding: 0.8rem 2rem; border-radius: 8px; cursor: pointer;">
                            📁 Choisir une image
                            <input type="file" id="poultryImage" name="poultry_image" accept="image/*" style="display: none;">
                        </label>
                        <input type="text" name="poultry_name" placeholder="Nom du poulet" style="padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px; min-width: 200px;">
                    </div>
                    <button type="submit" class="upload-btn">📤 Uploader l'image</button>
                </div>
            </form>
        </div>

        <h3 style="color: var(--primary-green); margin: 2rem 0 1rem;">🖼️ Images disponibles</h3>
        <div class="gallery-grid-upload">
            <?php
            $imageDir = __DIR__ . '/../../public/images/poules/';
            if (is_dir($imageDir)) {
                $images = array_diff(scandir($imageDir), ['.', '..']);
                foreach ($images as $image) {
                    if (!in_array(strtolower(pathinfo($image, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) continue;
                    $name = ucwords(str_replace(['-', '_'], ' ', pathinfo($image, PATHINFO_FILENAME)));
                    echo '<div class="gallery-item">';
                    echo '<img src="/images/poules/' . $image . '" alt="' . $name . '" loading="lazy">';
                    echo '<div class="info"><div class="name">' . $name . '</div></div>';
                    echo '<button class="delete-btn" onclick="deleteImage(\'' . $image . '\')">✕</button>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <?php if (empty($images)): ?>
            <div style="text-align: center; padding: 2rem; background: white; border-radius: 12px;">
                <div style="font-size: 3rem;">🖼️</div>
                <p style="color: #a0aec0;">Aucune image dans la galerie. Uploader vos premières photos !</p>
            </div>
        <?php endif; ?>

        <div style="margin-top: 2rem; text-align: center;">
            <a href="/?route=dashboard" class="btn btn-primary">← Retour au tableau de bord</a>
            <a href="/?route=upload" class="btn btn-gold" style="margin-left: 0.5rem;">🔄 Actualiser</a>
        </div>

        <div class="omega-footer">
            <div class="company-name">Ω OMEGA INFORMATIQUE CONSULTING</div>
            <div class="tagline">Solutions innovantes pour l'aviculture moderne • Gestion de projet avicole</div>
            <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #a0aec0;">© <?php echo date('Y'); ?> Omega Consulting</div>
        </div>
    </div>

    <script>
        function deleteImage(filename) {
            if (confirm('Supprimer cette image ?')) {
                window.location.href = '/?route=upload&delete=' + encodeURIComponent(filename);
            }
        }

        <?php if (isset($_GET['delete'])): ?>
            <?php
            $file = __DIR__ . '/../../public/images/poules/' . $_GET['delete'];
            if (file_exists($file)) {
                unlink($file);
                $_SESSION['message'] = '✅ Image supprimée avec succès';
                header('Location: /?route=upload');
                exit;
            }
            ?>
        <?php endif; ?>
    </script>
</body>
</html>
