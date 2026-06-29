<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Check Santé - Omega Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .form-group { margin-bottom: 1rem; }
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
        .full-width { grid-column: 1 / -1; }
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
            <a href="/?route=upload">📸 Galerie</a>
        </nav>
    </div>

    <div class="main-content">
        <h1 class="section-title">📊 Nouveau Check Sanitaire</h1>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="batch_id">Lot *</label>
                        <select id="batch_id" name="batch_id" required>
                            <?php foreach ($batches as $b): ?>
                                <option value="<?php echo $b['id']; ?>" <?php echo ($_GET['id'] ?? 0) == $b['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($b['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="check_date">Date *</label>
                        <input type="date" id="check_date" name="check_date" required value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="temperature_avg">🌡️ Température (°C)</label>
                        <input type="number" id="temperature_avg" name="temperature_avg" step="0.1" placeholder="28.5">
                    </div>
                    <div class="form-group">
                        <label for="humidity_avg">💧 Humidité (%)</label>
                        <input type="number" id="humidity_avg" name="humidity_avg" step="0.1" placeholder="65">
                    </div>

                    <div class="form-group">
                        <label for="ammonia_level">🧪 Ammoniaque (ppm)</label>
                        <input type="number" id="ammonia_level" name="ammonia_level" step="0.1" placeholder="5.2">
                    </div>
                    <div class="form-group">
                        <label for="co2_level">CO₂ (ppm)</label>
                        <input type="number" id="co2_level" name="co2_level" step="0.1" placeholder="800">
                    </div>

                    <div class="form-group">
                        <label for="feed_intake">🌾 Aliment consommé (kg)</label>
                        <input type="number" id="feed_intake" name="feed_intake" step="0.1" placeholder="145.5">
                    </div>
                    <div class="form-group">
                        <label for="water_intake">💧 Eau consommée (L)</label>
                        <input type="number" id="water_intake" name="water_intake" step="0.1" placeholder="320">
                    </div>

                    <div class="form-group">
                        <label for="mortality_count">📉 Mortalité</label>
                        <input type="number" id="mortality_count" name="mortality_count" value="0">
                    </div>
                    <div class="form-group">
                        <label for="sick_birds">🤒 Sujets malades</label>
                        <input type="number" id="sick_birds" name="sick_birds" value="0">
                    </div>

                    <div class="form-group">
                        <label for="injured_birds">🩹 Sujets blessés</label>
                        <input type="number" id="injured_birds" name="injured_birds" value="0">
                    </div>
                    <div class="form-group">
                        <label for="treatment_given">💊 Traitement administré</label>
                        <input type="text" id="treatment_given" name="treatment_given" placeholder="Vaccin Marek">
                    </div>

                    <div class="full-width form-group">
                        <label for="observations">📝 Observations</label>
                        <textarea id="observations" name="observations" rows="3" placeholder="État général du troupeau..."></textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">✅ Enregistrer</button>
                    <a href="/?route=lots" class="btn" style="flex: 1; text-align: center; background: #e2e8f0; color: var(--text-color);">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
