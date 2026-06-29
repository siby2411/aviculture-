<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports - Omega Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .report-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 2rem 0; }
        .report-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .report-card h3 { color: var(--primary-green); margin-bottom: 1rem; }
        .stat-row { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f0f0f0; }
        .stat-row:last-child { border-bottom: none; }
        .stat-value { font-weight: 700; color: var(--primary-green); }
        .stat-value.negative { color: #E53E3E; }
        .profit-card {
            background: linear-gradient(135deg, var(--omega-blue), var(--dark-green));
            color: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            margin: 1rem 0;
        }
        .profit-card .big-number { font-size: 3rem; font-weight: 700; }
        @media print { .sidebar { display: none; } .main-content { margin-left: 0; } .report-card { break-inside: avoid; } .profit-card { background: #1A365D !important; } }
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
            <a href="/?route=rapports" class="active">📋 Rapports</a>
            <a href="/?route=upload">📸 Galerie</a>
        </nav>
        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.7rem; text-align: center; opacity: 0.6;">v2.0 • OMEGA CONSULTING</div>
    </div>

    <div class="main-content">
        <h1 class="section-title">📋 Rapports d'Exploitation</h1>
        
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimer le rapport</button>
            <a href="/?route=rapports" class="btn btn-gold">🔄 Actualiser</a>
        </div>

        <?php
        $totalRevenue = array_sum(array_column($profitPerBatch ?? [], 'revenue'));
        $totalCost = array_sum(array_column($profitPerBatch ?? [], 'cost'));
        $totalProfit = array_sum(array_column($profitPerBatch ?? [], 'profit'));
        ?>

        <div class="profit-card">
            <div style="font-size: 1.2rem; opacity: 0.9;">Résultat d'exploitation</div>
            <div class="big-number"><?php echo number_format($totalProfit, 0, ',', ' '); ?> FCFA</div>
            <div style="margin-top: 0.5rem;">
                CA: <?php echo number_format($totalRevenue, 0, ',', ' '); ?> FCFA • 
                Coûts: <?php echo number_format($totalCost, 0, ',', ' '); ?> FCFA
            </div>
            <div style="margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.8;">
                Omega Consulting • Gestion de projet avicole
            </div>
        </div>

        <div class="report-grid">
            <div class="report-card">
                <h3>📊 Synthèse Globale</h3>
                <div class="stat-row"><span>Total poulets</span><span class="stat-value"><?php echo $totalBirds ?? 0; ?></span></div>
                <div class="stat-row"><span>Total œufs produits</span><span class="stat-value"><?php echo $totalEggs ?? 0; ?></span></div>
                <div class="stat-row"><span>Pertes totales</span><span class="stat-value" style="color: #E53E3E;"><?php echo $totalMortality ?? 0; ?></span></div>
                <div class="stat-row"><span>Coût de production total</span><span class="stat-value"><?php echo number_format($totalProductionCost ?? 0, 0, ',', ' '); ?> FCFA</span></div>
                <div class="stat-row"><span>Chiffre d'affaires</span><span class="stat-value"><?php echo number_format($totalRevenue, 0, ',', ' '); ?> FCFA</span></div>
                <div class="stat-row"><span>Charges totales</span><span class="stat-value"><?php echo number_format($totalExpenses ?? 0, 0, ',', ' '); ?> FCFA</span></div>
                <div class="stat-row" style="font-size: 1.1rem; border-top: 2px solid var(--primary-green); padding-top: 0.75rem; margin-top: 0.5rem;">
                    <span><strong>Résultat net</strong></span>
                    <span class="stat-value <?php echo ($profit ?? 0) < 0 ? 'negative' : ''; ?>">
                        <?php echo number_format($profit ?? 0, 0, ',', ' '); ?> FCFA
                    </span>
                </div>
            </div>

            <div class="report-card">
                <h3>📈 Performance par Lot</h3>
                <?php foreach ($profitPerBatch ?? [] as $batch): ?>
                    <div class="stat-row">
                        <span><?php echo htmlspecialchars($batch['name']); ?></span>
                        <span style="font-size: 0.9rem;">
                            CA: <?php echo number_format($batch['revenue'], 0, ',', ' '); ?> • 
                            <span style="color: <?php echo $batch['profit'] >= 0 ? 'var(--primary-green)' : '#E53E3E'; ?>;">
                                <?php echo number_format($batch['profit'], 0, ',', ' '); ?>
                            </span>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: center; color: #718096; font-size: 0.9rem;">
            Rapport généré le <?php echo date('d/m/Y à H:i'); ?> • Omega Consulting v2.0
        </div>

        <div class="omega-footer">
            <div class="company-name">Ω OMEGA INFORMATIQUE CONSULTING</div>
            <div class="tagline">Solutions innovantes pour l'aviculture moderne • Gestion de projet avicole</div>
            <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #a0aec0;">© <?php echo date('Y'); ?> Omega Consulting</div>
        </div>
    </div>
</body>
</html>
