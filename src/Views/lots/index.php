<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Lots - Omega Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .lot-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1rem 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary-green);
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 1rem;
            align-items: center;
        }
        .lot-card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .lot-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-actif { background: #C6F6D5; color: #22543D; }
        .status-fini { background: #FED7D7; color: #9B2C2C; }
        .status-attente { background: #FEFCBF; color: #975A16; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
        .btn-success { background: #48BB78; color: white; }
        .btn-gold { background: linear-gradient(135deg, #D69E2E, #B7791F); color: white; }
        .btn-sm { padding: 0.25rem 0.75rem; font-size: 0.85rem; }
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
            <a href="/?route=health<a href="/?route=rapports">📋 Rapports</a>id=<?php echo $batch['id'] ?? 0; ?>">🏥 Santé</a>
            <a href="/?route=upload">📸 Galerie</a>
        </nav>
        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.7rem; text-align: center; opacity: 0.6;">v2.0 • OMEGA CONSULTING</div>
    </div>

    <div class="main-content">
        <h1 class="section-title">🐓 Gestion des Lots</h1>
        
        <div style="margin-bottom: 2rem;">
            <a href="/?route=lots&action=create" class="btn btn-primary">➕ Nouveau Lot</a>
        </div>

        <?php if (isset($batches) && count($batches) > 0): ?>
            <?php foreach ($batches as $batch): ?>
                <?php $stats = (new \Models\BatchModel())->getBatchStats($batch['id']); ?>
                <div class="lot-card">
                    <div>
                        <h3 style="color: var(--primary-green);"><?php echo htmlspecialchars($batch['name']); ?></h3>
                        <div style="color: #718096; font-size: 0.9rem;">
                            <?php echo htmlspecialchars($batch['building_name'] ?? 'Bâtiment'); ?>
                        </div>
                        <div style="margin-top: 0.5rem;">
                            <span class="lot-status status-<?php echo $batch['status']; ?>">
                                <?php echo $batch['status'] === 'actif' ? '🟢 Actif' : ($batch['status'] === 'fini' ? '🔴 Fini' : '🟡 En attente'); ?>
                            </span>
                        </div>
                    </div>
                    <div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-green);">
                                    <?php echo $batch['current_quantity']; ?>
                                </div>
                                <div style="color: #718096; font-size: 0.8rem;">🐓 Sujets</div>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: var(--gold-amber);">
                                    <?php echo $stats['total_eggs'] ?? 0; ?>
                                </div>
                                <div style="color: #718096; font-size: 0.8rem;">🥚 Œufs</div>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #E53E3E;">
                                    <?php echo $stats['total_mortality'] ?? 0; ?>
                                </div>
                                <div style="color: #718096; font-size: 0.8rem;">📉 Pertes</div>
                            </div>
                        </div>
                        <div style="margin-top: 0.5rem; color: #718096; font-size: 0.85rem;">
                            Début: <?php echo date('d/m/Y', strtotime($batch['start_date'])); ?> • 
                            Âge: <?php echo $stats['age_days'] ?? 0; ?> jours
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <a href="/?route=lots&id=<?php echo $batch['id']; ?>" class="btn btn-primary btn-sm">📊 Détails</a>
                        <a href="/?route=ventes&action=add&batch=<?php echo $batch['id']; ?>" class="btn btn-success btn-sm">💰 Vente</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
                <div style="font-size: 4rem;">🐣</div>
                <h3 style="color: #718096;">Aucun lot enregistré</h3>
                <p style="color: #a0aec0; margin: 1rem 0;">Commencez par créer votre premier lot</p>
                <a href="/?route=lots&action=create" class="btn btn-primary">➕ Créer un lot</a>
            </div>
        <?php endif; ?>

        <div class="omega-footer">
            <div class="company-name">Ω OMEGA INFORMATIQUE CONSULTING</div>
            <div class="tagline">Solutions innovantes pour l'aviculture moderne • Gestion de projet avicole</div>
            <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #a0aec0;">© <?php echo date('Y'); ?> Omega Consulting</div>
        </div>
    </div>
</body>
</html>
