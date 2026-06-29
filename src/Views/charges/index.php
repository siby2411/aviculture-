<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charges - Omega Aviculture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .expense-card {
            background: white;
            padding: 1rem 1.5rem;
            margin: 0.5rem 0;
            border-radius: 8px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .expense-card:hover { background: #f7fafc; }
        .expense-header { font-weight: 600; color: #718096; background: #edf2f7; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary-green); color: white; }
        .btn-primary:hover { background: var(--dark-green); }
        .category-badge {
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.8rem;
        }
        .cat-Aliment { background: #C6F6D5; color: #22543D; }
        .cat-Vétérinaire { background: #FEFCBF; color: #975A16; }
        .cat-Eau { background: #BEE3F8; color: #2B6CB0; }
        .cat-Energie { background: #FED7D7; color: #9B2C2C; }
        .cat-Autre { background: #E2E8F0; color: #4A5568; }
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
            <a href="/?route=charges" class="active">💳 Charges</a>
            <a href="/?route=rapports">📋 Rapports</a>
            <a href="/?route=upload">📸 Galerie</a>
        </nav>
        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.7rem; text-align: center; opacity: 0.6;">v2.0 • OMEGA CONSULTING</div>
    </div>

    <div class="main-content">
        <h1 class="section-title">💳 Gestion des Charges</h1>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <a href="/?route=charges&action=add" class="btn btn-primary">➕ Nouvelle charge</a>
            <div style="display: flex; gap: 2rem; background: white; padding: 1rem 2rem; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                <div><span style="color: #718096;">Total charges:</span> <strong style="color: #E53E3E; font-size: 1.2rem;"><?php echo number_format($total ?? 0, 0, ',', ' '); ?> FCFA</strong></div>
            </div>
        </div>

        <?php if (isset($expenses) && count($expenses) > 0): ?>
            <div class="expense-card expense-header">
                <div>Description / Lot</div>
                <div>Catégorie</div>
                <div>Montant</div>
                <div>Date</div>
            </div>
            <?php foreach ($expenses as $expense): ?>
                <div class="expense-card">
                    <div>
                        <strong><?php echo htmlspecialchars($expense['description'] ?? 'N/A'); ?></strong>
                        <div style="font-size: 0.85rem; color: #718096;">Lot: <?php echo htmlspecialchars($expense['batch_name'] ?? 'N/A'); ?></div>
                    </div>
                    <div>
                        <span class="category-badge cat-<?php echo $expense['category']; ?>">
                            <?php 
                            $icons = ['Aliment' => '🌾', 'Vétérinaire' => '💊', 'Eau' => '💧', 'Energie' => '⚡', 'Autre' => '📦'];
                            echo ($icons[$expense['category']] ?? '📦') . ' ' . htmlspecialchars($expense['category']); 
                            ?>
                        </span>
                    </div>
                    <div><strong><?php echo number_format($expense['amount'], 0, ',', ' '); ?> FCFA</strong></div>
                    <div style="font-size: 0.9rem; color: #718096;"><?php echo date('d/m/Y', strtotime($expense['expense_date'])); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
                <div style="font-size: 4rem;">💳</div>
                <h3 style="color: #718096;">Aucune charge enregistrée</h3>
                <p style="color: #a0aec0; margin: 1rem 0;">Enregistrez vos premières charges</p>
                <a href="/?route=charges&action=add" class="btn btn-primary">➕ Ajouter une charge</a>
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
