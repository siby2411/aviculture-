<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi Sanitaire - Omega Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .alert-card {
            padding: 1rem;
            border-radius: 8px;
            margin: 0.5rem 0;
            border-left: 4px solid #E53E3E;
            background: #FFF5F5;
        }
        .alert-card.warning { border-color: #D69E2E; background: #FFFFF0; }
        .alert-card.success { border-color: #48BB78; background: #F0FFF4; }
        .metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        .metric-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .metric-item .value {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .metric-item .label {
            font-size: 0.8rem;
            color: #718096;
        }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
        .btn-warning { background: #F4A261; color: white; }
        .btn-info { background: #4299E1; color: white; }
        .btn-danger { background: #FC8181; color: white; }
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
            <a href="/?route=health&id=<?php echo $batch['id'] ?? 0; ?>" class="active">🏥 Santé</a>
            <a href="/?route=rapports">📋 Rapports</a>
            <a href="/?route=health<a href="/?route=rapports">📋 Rapports</a>id=<?php echo $batch['id'] ?? 0; ?>">🏥 Santé</a>
            <a href="/?route=upload">📸 Galerie</a>
        </nav>
        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.7rem; text-align: center; opacity: 0.6;">v2.0 • OMEGA CONSULTING</div>
    </div>

    <div class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 class="section-title">🏥 Suivi Sanitaire: <?php echo htmlspecialchars($batch['name'] ?? 'N/A'); ?></h1>
            <a href="/?route=lots" class="btn btn-primary">← Retour</a>
        </div>

        <?php if (!empty($alerts)): ?>
            <div style="margin: 1rem 0;">
                <?php foreach ($alerts as $alert): ?>
                    <div class="alert-card <?php echo strpos($alert, '⚠️') !== false ? 'warning' : 'danger'; ?>">
                        <?php echo $alert; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert-card success">✅ Aucune alerte sanitaire pour ce lot</div>
        <?php endif; ?>

        <?php if ($healthStatus): ?>
        <div class="metric-grid">
            <div class="metric-item">
                <div class="value" style="color: var(--primary-green);"><?php echo $healthStatus['temperature_avg'] ?? '--'; ?>°C</div>
                <div class="label">🌡️ Température</div>
            </div>
            <div class="metric-item">
                <div class="value" style="color: #4299E1;"><?php echo $healthStatus['humidity_avg'] ?? '--'; ?>%</div>
                <div class="label">💧 Humidité</div>
            </div>
            <div class="metric-item">
                <div class="value" style="color: #D69E2E;"><?php echo $healthStatus['ammonia_level'] ?? '--'; ?> ppm</div>
                <div class="label">🧪 Ammoniaque</div>
            </div>
            <div class="metric-item">
                <div class="value" style="color: #E53E3E;"><?php echo $healthStatus['mortality_count'] ?? 0; ?></div>
                <div class="label">📉 Mortalité</div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 2rem 0;">
            <div class="chart-container">
                <h4 style="color: var(--primary-green);">Consommation</h4>
                <canvas id="consumptionChart"></canvas>
            </div>
            <div class="chart-container">
                <h4 style="color: var(--primary-green);">Évolution des poids</h4>
                <canvas id="weightChart"></canvas>
            </div>
        </div>
        <?php endif; ?>

        <div style="display: flex; gap: 1rem; margin: 2rem 0; flex-wrap: wrap;">
            <a href="/?route=health-add&id=<?php echo $batch['id'] ?? 0; ?>" class="btn btn-info">📊 Nouveau check</a>
            <a href="/?route=treatment-add&id=<?php echo $batch['id'] ?? 0; ?>" class="btn btn-warning">💊 Ajouter traitement</a>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimer</button>
        </div>

        <?php if (!empty($treatments)): ?>
        <h3 style="color: var(--primary-green); margin-top: 2rem;">💊 Traitements préventifs</h3>
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f7fafc;">
                    <tr>
                        <th style="padding: 0.75rem; text-align: left;">Date</th>
                        <th style="padding: 0.75rem; text-align: left;">Type</th>
                        <th style="padding: 0.75rem; text-align: left;">Produit</th>
                        <th style="padding: 0.75rem; text-align: left;">Dosage</th>
                        <th style="padding: 0.75rem; text-align: left;">Prochain</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($treatments as $treatment): ?>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 0.75rem;"><?php echo date('d/m/Y', strtotime($treatment['treatment_date'])); ?></td>
                        <td style="padding: 0.75rem;"><?php echo htmlspecialchars($treatment['treatment_type']); ?></td>
                        <td style="padding: 0.75rem;"><?php echo htmlspecialchars($treatment['product_name']); ?></td>
                        <td style="padding: 0.75rem;"><?php echo htmlspecialchars($treatment['dosage']); ?></td>
                        <td style="padding: 0.75rem;"><?php echo $treatment['next_due_date'] ? date('d/m/Y', strtotime($treatment['next_due_date'])) : '--'; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div class="omega-footer">
            <div class="company-name">Ω OMEGA INFORMATIQUE CONSULTING</div>
            <div class="tagline">Solutions innovantes pour l'aviculture moderne • Gestion de projet avicole</div>
            <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #a0aec0;">© <?php echo date('Y'); ?> Omega Consulting</div>
        </div>
    </div>

    <script>
        <?php if ($healthStatus): ?>
        // Graphique de consommation
        const consumptionCtx = document.getElementById('consumptionChart').getContext('2d');
        new Chart(consumptionCtx, {
            type: 'line',
            data: {
                labels: <?php 
                    $labels = [];
                    $feedData = [];
                    $waterData = [];
                    foreach ($healthHistory as $h) {
                        $labels[] = date('d/m', strtotime($h['check_date']));
                        $feedData[] = $h['feed_intake'] ?? 0;
                        $waterData[] = $h['water_intake'] ?? 0;
                    }
                    echo json_encode(array_reverse($labels));
                ?>,
                datasets: [
                    {
                        label: 'Aliment (kg)',
                        data: <?php echo json_encode(array_reverse($feedData)); ?>,
                        borderColor: '#2D6A4F',
                        backgroundColor: 'rgba(45, 106, 79, 0.1)',
                        fill: true
                    },
                    {
                        label: 'Eau (L)',
                        data: <?php echo json_encode(array_reverse($waterData)); ?>,
                        borderColor: '#4299E1',
                        backgroundColor: 'rgba(66, 153, 225, 0.1)',
                        fill: true
                    }
                ]
            },
            options: { responsive: true }
        });

        // Graphique des poids
        const weightCtx = document.getElementById('weightChart').getContext('2d');
        new Chart(weightCtx, {
            type: 'line',
            data: {
                labels: <?php 
                    $weightLabels = [];
                    $weightData = [];
                    foreach ($weights as $w) {
                        $weightLabels[] = date('d/m', strtotime($w['weigh_date']));
                        $weightData[] = $w['avg_weight'] ?? 0;
                    }
                    echo json_encode(array_reverse($weightLabels));
                ?>,
                datasets: [{
                    label: 'Poids moyen (kg)',
                    data: <?php echo json_encode(array_reverse($weightData)); ?>,
                    borderColor: '#D69E2E',
                    backgroundColor: 'rgba(214, 158, 46, 0.1)',
                    fill: true
                }]
            },
            options: { responsive: true }
        });
        <?php endif; ?>
    </script>
</body>
</html>
