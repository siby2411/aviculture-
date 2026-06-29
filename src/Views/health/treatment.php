<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Traitement - Omega Aviculture</title>
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
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: var(--primary-green); }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
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
            <a href="/?route=health<a href="/?route=rapports">📋 Rapports</a>id=<?php echo $batch['id'] ?? 0; ?>">🏥 Santé</a>
            <a href="/?route=upload">📸 Galerie</a>
        </nav>
    </div>

    <div class="main-content">
        <h1 class="section-title">💊 Ajouter un Traitement</h1>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="batch_id">Lot *</label>
                    <select id="batch_id" name="batch_id" required>
                        <?php foreach ($batches as $b): ?>
                            <option value="<?php echo $b['id']; ?>">
                                <?php echo htmlspecialchars($b['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="treatment_date">Date *</label>
                    <input type="date" id="treatment_date" name="treatment_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="treatment_type">Type de traitement *</label>
                    <select id="treatment_type" name="treatment_type" required>
                        <option value="Vaccination">💉 Vaccination</option>
                        <option value="Déparasitage">🧪 Déparasitage</option>
                        <option value="Antibiotique">💊 Antibiotique</option>
                        <option value="Vitamines">💚 Vitamines</option>
                        <option value="Préventif">🛡️ Préventif</option>
                        <option value="Curatif">🏥 Curatif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_name">Nom du produit *</label>
                    <input type="text" id="product_name" name="product_name" required placeholder="Ex: Vaccin Marek">
                </div>
                <div class="form-group">
                    <label for="dosage">Dosage</label>
                    <input type="text" id="dosage" name="dosage" placeholder="Ex: 1 dose/sujet">
                </div>
                <div class="form-group">
                    <label for="administration_method">Méthode d'administration</label>
                    <select id="administration_method" name="administration_method">
                        <option value="Injection">💉 Injection</option>
                        <option value="Eau">💧 Dans l'eau</option>
                        <option value="Aliment">🌾 Dans l'aliment</option>
                        <option value="Aérosol">🌫️ Aérosol</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cost">Coût (FCFA)</label>
                    <input type="number" id="cost" name="cost" step="100" placeholder="Ex: 25000">
                </div>
                <div class="form-group">
                    <label for="next_due_date">Prochain traitement prévu</label>
                    <input type="date" id="next_due_date" name="next_due_date">
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Observations..."></textarea>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">✅ Enregistrer</button>
                    <a href="/?route=lots" class="btn" style="flex: 1; text-align: center; background: #e2e8f0; color: var(--text-color);">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
