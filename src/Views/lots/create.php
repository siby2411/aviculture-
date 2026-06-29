<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Lot - Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><span class="logo-icon">🐔</span><span>Aviculture</span></div>
        <nav>
            <a href="/?route=dashboard" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📊 Tableau de bord</a>
            <a href="/?route=lots" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; background: rgba(255,255,255,0.1); border-radius: 8px;">🐓 Lots</a>
            <a href="/?route=ventes" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">💰 Ventes</a>
            <a href="/?route=charges" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">💳 Charges</a>
            <a href="/?route=rapports" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📋 Rapports</a>
            <a href="/?route=upload" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📸 Galerie</a>
        </nav>
    </div>

    <div class="main-content">
        <h1 class="section-title">🐣 Nouveau Lot</h1>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="name">Nom du lot *</label>
                    <input type="text" id="name" name="name" required placeholder="Ex: Lot 1 - Janvier 2026">
                </div>
                <div class="form-group">
                    <label for="building_id">Bâtiment *</label>
                    <select id="building_id" name="building_id" required>
                        <option value="">Sélectionner un bâtiment</option>
                        <?php
                        $db = \Config\Database::getInstance()->getConnection();
                        $stmt = $db->query("SELECT * FROM buildings");
                        while ($building = $stmt->fetch()) {
                            echo "<option value='{$building['id']}'>{$building['name']} (Capacité: {$building['capacity']})</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_date">Date de début *</label>
                    <input type="date" id="start_date" name="start_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="initial_quantity">Quantité initiale *</label>
                    <input type="number" id="initial_quantity" name="initial_quantity" required min="1" placeholder="Nombre de poulets">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">✅ Créer le lot</button>
                    <a href="/?route=lots" class="btn" style="flex: 1; text-align: center; background: #e2e8f0; color: var(--text-color);">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
