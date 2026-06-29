<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du lot - Omega Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
            margin: 1.5rem 0;
        }
        .detail-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .detail-card h4 {
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }
        .detail-card .number {
            font-size: 2rem;
            font-weight: 700;
        }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
        .btn-success { background: #48BB78; color: white; }
        .btn-warning { background: #F4A261; color: white; }
        .btn-gold { background: linear-gradient(135deg, #D69E2E, #B7791F); color: white; }
        .tab-container { margin: 2rem 0; }
        .tab-buttons { display: flex; gap: 0.5rem; margin-bottom: 1rem; }
        .tab-btn { padding: 0.5rem 1.5rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; background: #e2e8f0; }
        .tab-btn.active { background: var(--primary-green); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .record-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
            padding: 0.75rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .record-row.header { font-weight: 600; color: #718096; background: #f7fafc; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><span class="logo-icon">🐔</span><span>Aviculture</span></div>
        <div class="logo-sub">OMEGA INFORMATIQUE CONSULTING<div class="omega-badge">⭐ GESTION AVICOLE</div></div>
        <nav>
            <a href="/?route=dashboard">📊 Tableau de bord</a>
            <a href="/?route=lots" class="active">🐓 Lots</a>
            <a href="/?route=ventes">💰 Ventes</a>
            <a href="/?route=charges">💳 Charges</a>
            <a href="/?route=rapports">📋 Rapports</a>
            <a href="/?route=upload">📸 Galerie</a>
        </nav>
        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.7rem; text-align: center; opacity: 0.6;">v2.0 • OMEGA CONSULTING</div>
    </div>

    <div class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 class="section-title">📊 Détails du lot: <?php echo htmlspecialchars($batch['name'] ?? 'N/A'); ?></h1>
            <a href="/?route=lots" class="btn btn-primary">← Retour</a>
        </div>

        <?php if (isset($batch) && $batch): ?>
        <div class="detail-grid">
            <div class="detail-card">
                <h4>🐓 Effectif</h4>
                <div class="number" style="color: var(--primary-green);"><?php echo $batch['current_quantity']; ?></div>
                <div style="color: #718096;">Initial: <?php echo $batch['initial_quantity']; ?></div>
            </div>
            <div class="detail-card">
                <h4>📊 Production</h4>
                <div class="number" style="color: var(--gold-amber);"><?php echo $stats['total_eggs'] ?? 0; ?></div>
                <div style="color: #718096;">🥚 Œufs produits</div>
            </div>
            <div class="detail-card">
                <h4>💰 Coût de production</h4>
                <div class="number" style="color: #E53E3E;"><?php echo number_format($cost['cost_per_bird'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                <div style="color: #718096;">Par sujet</div>
            </div>
        </div>

        <div class="tab-container">
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="showTab('records')">📋 Enregistrements</button>
                <button class="tab-btn" onclick="showTab('costs')">💰 Coûts</button>
                <button class="tab-btn" onclick="showTab('eggs')">🥚 Ponte</button>
                <button class="tab-btn" onclick="showTab('health')">🏥 Santé</button>
            </div>

            <div id="tab-records" class="tab-content active">
                <h3 style="color: var(--primary-green);">Enregistrements quotidiens</h3>
                <div class="record-row header">
                    <div>Date</div>
                    <div>Aliment (kg)</div>
                    <div>Eau (L)</div>
                    <div>Pertes</div>
                    <div>Poids (kg)</div>
                </div>
                <?php foreach ($dailyRecords ?? [] as $record): ?>
                <div class="record-row">
                    <div><?php echo date('d/m/Y', strtotime($record['record_date'])); ?></div>
                    <div><?php echo $record['feed_consumed']; ?></div>
                    <div><?php echo $record['water_consumed']; ?></div>
                    <div style="color: #E53E3E;"><?php echo $record['mortality']; ?></div>
                    <div><?php echo $record['average_weight']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <div id="tab-costs" class="tab-content">
                <h3 style="color: var(--primary-green);">Détail des coûts</h3>
                <div class="record-row header">
                    <div>Catégorie</div>
                    <div>Montant</div>
                    <div>% du total</div>
                </div>
                <?php if (isset($cost)): ?>
                <div class="record-row">
                    <div>🌾 Aliment</div>
                    <div><?php echo number_format($cost['feed_cost'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                    <div><?php echo $cost['total_cost'] > 0 ? round(($cost['feed_cost'] / $cost['total_cost']) * 100, 1) : 0; ?>%</div>
                </div>
                <div class="record-row">
                    <div>💊 Vétérinaire</div>
                    <div><?php echo number_format($cost['veterinary_cost'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                    <div><?php echo $cost['total_cost'] > 0 ? round(($cost['veterinary_cost'] / $cost['total_cost']) * 100, 1) : 0; ?>%</div>
                </div>
                <div class="record-row">
                    <div>💧 Eau</div>
                    <div><?php echo number_format($cost['water_cost'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                    <div><?php echo $cost['total_cost'] > 0 ? round(($cost['water_cost'] / $cost['total_cost']) * 100, 1) : 0; ?>%</div>
                </div>
                <div class="record-row">
                    <div>📦 Autres charges</div>
                    <div><?php echo number_format($cost['other_expenses'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                    <div><?php echo $cost['total_cost'] > 0 ? round(($cost['other_expenses'] / $cost['total_cost']) * 100, 1) : 0; ?>%</div>
                </div>
                <div class="record-row" style="font-weight: 700; border-top: 2px solid var(--primary-green);">
                    <div>TOTAL</div>
                    <div><?php echo number_format($cost['total_cost'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                    <div>100%</div>
                </div>
                <?php endif; ?>
            </div>

            <div id="tab-eggs" class="tab-content">
                <h3 style="color: var(--primary-green);">Production d'œufs</h3>
                <?php if (isset($eggProduction) && count($eggProduction) > 0): ?>
                <div class="record-row header">
                    <div>Date</div>
                    <div>Œufs collectés</div>
                    <div>Œufs cassés</div>
                    <div>Œufs vendables</div>
                </div>
                <?php foreach ($eggProduction as $egg): ?>
                <div class="record-row">
                    <div><?php echo date('d/m/Y', strtotime($egg['record_date'])); ?></div>
                    <div><?php echo $egg['eggs_collected']; ?></div>
                    <div style="color: #E53E3E;"><?php echo $egg['broken_eggs']; ?></div>
                    <div style="color: var(--primary-green);"><?php echo $egg['saleable_eggs']; ?></div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p style="color: #718096;">Aucune donnée de ponte pour ce lot</p>
                <?php endif; ?>
            </div>

            <div id="tab-health" class="tab-content">
                <h3 style="color: var(--primary-green);">Suivi sanitaire</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                    <div style="background: white; padding: 1rem; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem;">📊</div>
                        <div style="font-weight: 700;">Taux de survie</div>
                        <div style="font-size: 1.5rem; color: #48BB78;"><?php echo round($cost['survival_rate'] ?? 0, 1); ?>%</div>
                    </div>
                    <div style="background: white; padding: 1rem; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem;">📉</div>
                        <div style="font-weight: 700;">Mortalité</div>
                        <div style="font-size: 1.5rem; color: #E53E3E;"><?php echo round($cost['mortality_rate'] ?? 0, 1); ?>%</div>
                    </div>
                    <div style="background: white; padding: 1rem; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem;">⚖️</div>
                        <div style="font-weight: 700;">Poids moyen</div>
                        <div style="font-size: 1.5rem; color: var(--gold-amber);"><?php echo $cost['avg_weight'] ?? 0; ?> kg</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="/?route=ventes&action=add&batch=<?php echo $batch['id']; ?>" class="btn btn-success">💰 Ajouter une vente</a>
            <a href="/?route=charges&action=add&batch=<?php echo $batch['id']; ?>" class="btn btn-warning">💳 Ajouter une charge</a>
            <button onclick="window.print()" class="btn btn-gold">🖨️ Imprimer</button>
        </div>

        <?php else: ?>
        <div style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
            <div style="font-size: 4rem;">🔍</div>
            <h3 style="color: #718096;">Lot non trouvé</h3>
            <a href="/?route=lots" class="btn btn-primary">← Retour aux lots</a>
        </div>
        <?php endif; ?>

        <div class="omega-footer">
            <div class="company-name">Ω OMEGA INFORMATIQUE CONSULTING</div>
            <div class="tagline">Solutions innovantes pour l'aviculture moderne • Gestion de projet avicole</div>
            <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #a0aec0;">© <?php echo date('Y'); ?> Omega Consulting</div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
