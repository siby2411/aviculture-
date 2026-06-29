<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Charge - Aviculture</title>
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
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 1rem; }
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
            <a href="/?route=ventes" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">💰 Ventes</a>
            <a href="/?route=charges" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; background: rgba(255,255,255,0.1); border-radius: 8px;">💳 Charges</a>
            <a href="/?route=rapports" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📋 Rapports</a>
            <a href="/?route=upload" style="color: white; text-decoration: none; display: block; padding: 0.5rem 1rem; margin: 0.25rem 0; opacity: 0.7;">📸 Galerie</a>
        </nav>
    </div>

    <div class="main-content">
        <h1 class="section-title">💳 Nouvelle Charge</h1>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="batch_id">Lot *</label>
                    <select id="batch_id" name="batch_id" required>
                        <option value="">Sélectionner un lot</option>
                        <?php foreach ($batches as $batch): ?>
                            <option value="<?php echo $batch['id']; ?>">
                                <?php echo htmlspecialchars($batch['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Catégorie *</label>
                    <select id="category" name="category" required>
                        <option value="Aliment">🌾 Aliment</option>
                        <option value="Vétérinaire">💊 Vétérinaire</option>
                        <option value="Eau">💧 Eau</option>
                        <option value="Energie">⚡ Energie</option>
                        <option value="Autre">📦 Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description *</label>
                    <input type="text" id="description" name="description" required placeholder="Ex: Achat aliment 100kg">
                </div>
                <div class="form-group">
                    <label for="amount">Montant (FCFA) *</label>
                    <input type="number" id="amount" name="amount" required min="1" step="100" placeholder="Ex: 25000">
                </div>
                <div class="form-group">
                    <label for="expense_date">Date *</label>
                    <input type="date" id="expense_date" name="expense_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">✅ Enregistrer la charge</button>
                    <a href="/?route=charges" class="btn" style="flex: 1; text-align: center; background: #e2e8f0; color: var(--text-color);">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
