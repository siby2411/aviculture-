<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Vente - Aviculture</title>
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
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-color); }
        .form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 1rem; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: var(--primary-green); box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1); }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><span class="logo-icon">🐔</span><span>Aviculture</span></div>
        <nav>
            <a href="/?route=dashboard" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📊 Tableau de bord</a>
            <a href="/?route=lots" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">🐓 Lots</a>
            <a href="/?route=ventes" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; background: rgba(255,255,255,0.1); border-radius: 8px;">💰 Ventes</a>
            <a href="/?route=charges" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">💳 Charges</a>
            <a href="/?route=rapports" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📋 Rapports</a>
            <a href="/?route=upload" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📸 Galerie</a>
        </nav>
    </div>

    <div class="main-content">
        <h1 class="section-title">💰 Nouvelle Vente</h1>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="batch_id">Lot *</label>
                    <select id="batch_id" name="batch_id" required>
                        <option value="">Sélectionner un lot</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?php echo $batch['id']; ?>">
                                <?php echo htmlspecialchars($batch['name']); ?> 
                                (<?php echo $batch['current_quantity']; ?> sujets)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sale_type">Type de vente *</label>
                    <select id="sale_type" name="sale_type" required>
                        <option value="poulet">🐓 Poulets de chair</option>
                        <option value="oeuf">🥚 Œufs</option>
                        <option value="autre">📦 Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantité *</label>
                    <input type="number" id="quantity" name="quantity" required min="1" placeholder="Nombre d'unités">
                </div>
                <div class="form-group">
                    <label for="unit_price">Prix unitaire (FCFA) *</label>
                    <input type="number" id="unit_price" name="unit_price" required min="1" step="100" placeholder="Ex: 4500">
                </div>
                <div class="form-group">
                    <label for="buyer_name">Nom de l'acheteur</label>
                    <input type="text" id="buyer_name" name="buyer_name" placeholder="Nom du client">
                </div>
                <div class="form-group">
                    <label for="sale_date">Date de vente *</label>
                    <input type="date" id="sale_date" name="sale_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">✅ Enregistrer la vente</button>
                    <a href="/?route=ventes" class="btn" style="flex: 1; text-align: center; background: #e2e8f0; color: var(--text-color);">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
