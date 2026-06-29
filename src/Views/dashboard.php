<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omega Aviculture - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .quick-action {
            background: white;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-color);
        }
        .quick-action:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        .quick-action .icon { font-size: 2rem; display: block; margin-bottom: 0.5rem; }
        .health-alert {
            background: #FFF5F5;
            border-left: 4px solid #E53E3E;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .health-ok {
            background: #F0FFF4;
            border-left: 4px solid #48BB78;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <span class="logo-icon">🐔</span>
            <span>Aviculture</span>
        </div>
        <div class="logo-sub">
            OMEGA INFORMATIQUE CONSULTING
            <div class="omega-badge">⭐ GESTION AVICOLE</div>
        </div>
        
        <nav>
            <a href="/?route=dashboard" class="active">📊 Tableau de bord</a>
            <a href="/?route=lots">🐓 Lots</a>
            <a href="/?route=ventes">💰 Ventes</a>
            <a href="/?route=charges">💳 Charges</a>
            <a href="/?route=rapports">📋 Rapports</a>
            <a href="/?route=upload">📸 Galerie</a>
        </nav>

        <div class="status-indicators">
            <h4 style="margin-bottom: 1rem;">🏥 Santé du Troupeau</h4>
            <div class="status-item"><span>Taux de survie</span><span><span class="status-dot green"></span> 94%</span></div>
            <div class="status-item"><span>Production d'œufs</span><span><span class="status-dot green"></span> 87%</span></div>
            <div class="status-item"><span>Mortalité</span><span><span class="status-dot yellow"></span> 3.2%</span></div>
        </div>

        <!-- Module Prophylaxie dans la sidebar -->
        <div style="margin-top: 1rem; padding: 0.5rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem;">
                <span style="font-size: 0.9rem; font-weight: 600;">🏥 Prophylaxie</span>
                <span style="font-size: 0.7rem; background: #48BB78; padding: 0.2rem 0.5rem; border-radius: 12px;">Actif</span>
            </div>
            <?php
            $healthModel = new \Models\HealthMonitoringModel();
            $hasAlerts = false;
            if (isset($batches)) {
                foreach ($batches as $batch) {
                    $alerts = $healthModel->getBatchAlerts($batch['id']);
                    if (!empty($alerts)) {
                        $hasAlerts = true;
                        break;
                    }
                }
            }
            ?>
            <div style="font-size: 0.8rem; padding: 0.25rem 0.5rem; color: <?php echo $hasAlerts ? '#E53E3E' : '#48BB78'; ?>;">
                <?php echo $hasAlerts ? '🔴 Alertes actives' : '🟢 Tout va bien'; ?>
            </div>
            <a href="/?route=health&id=<?php echo isset($batches[0]) ? $batches[0]['id'] : 0; ?>" 
               style="color: white; text-decoration: none; font-size: 0.8rem; display: block; padding: 0.25rem 0.5rem; background: rgba(255,255,255,0.1); border-radius: 4px; text-align: center; margin-top: 0.25rem;">
                📊 Accéder au suivi
            </a>
        </div>

        <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.7rem; text-align: center; opacity: 0.6;">
            v2.0 • OMEGA CONSULTING
        </div>
    </div>

    <div class="main-content">
        <h1 class="section-title">📊 Tableau de bord</h1>
        
        <!-- Module Prophylaxie - Alertes -->
        <?php if (isset($batches)): ?>
            <?php foreach ($batches as $batch): ?>
                <?php 
                $alerts = $healthModel->getBatchAlerts($batch['id']);
                if (!empty($alerts)): 
                ?>
                    <div class="health-alert">
                        <strong>🚨 Alerte sanitaire - <?php echo htmlspecialchars($batch['name']); ?></strong>
                        <ul style="margin: 0.5rem 0 0 1.5rem;">
                            <?php foreach ($alerts as $alert): ?>
                                <li><?php echo $alert; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="/?route=health&id=<?php echo $batch['id']; ?>" style="color: #2D6A4F; font-weight: 600;">Voir les détails →</a>
                    </div>
                <?php else: ?>
                    <div class="health-ok">
                        ✅ <strong><?php echo htmlspecialchars($batch['name']); ?></strong> - Aucune alerte sanitaire
                        <a href="/?route=health&id=<?php echo $batch['id']; ?>" style="color: #2D6A4F; font-weight: 600; margin-left: 1rem;">📊 Suivi</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="quick-actions">
            <a href="/?route=lots&action=create" class="quick-action">
                <span class="icon">🐣</span>
                <div style="font-weight: 600;">Nouveau lot</div>
            </a>
            <a href="/?route=ventes&action=add" class="quick-action">
                <span class="icon">💰</span>
                <div style="font-weight: 600;">Nouvelle vente</div>
            </a>
            <a href="/?route=charges&action=add" class="quick-action">
                <span class="icon">💳</span>
                <div style="font-weight: 600;">Nouvelle charge</div>
            </a>
            <a href="/?route=health-add" class="quick-action" style="border-left: 3px solid #4299E1;">
                <span class="icon">🏥</span>
                <div style="font-weight: 600;">Check santé</div>
            </a>
            <a href="/?route=rapports" class="quick-action">
                <span class="icon">📋</span>
                <div style="font-weight: 600;">Rapports</div>
            </a>
        </div>

        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="value"><?php echo $totalBirds ?? 0; ?></div>
                <div class="label">🐓 Total poulets</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo number_format($totalRevenue ?? 0, 0, ',', ' '); ?> FCFA</div>
                <div class="label">💰 Chiffre d'affaires</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo $totalEggs ?? 0; ?></div>
                <div class="label">🥚 Œufs produits</div>
            </div>
            <div class="stat-card">
                <div class="value"><?php echo $totalMortality ?? 0; ?></div>
                <div class="label">📉 Pertes totales</div>
            </div>
        </div>

        <div class="chart-container">
            <h3 style="color: #2D6A4F; margin-bottom: 1rem;">📈 Évolution des ventes (30 jours)</h3>
            <canvas id="salesChart"></canvas>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 2rem 0;">
            <div class="chart-container">
                <h3 style="color: #2D6A4F; margin-bottom: 1rem;">📉 Taux de mortalité</h3>
                <canvas id="mortalityChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 style="color: #2D6A4F; margin-bottom: 1rem;">🥚 Production d'œufs</h3>
                <canvas id="eggsChart"></canvas>
            </div>
        </div>

        <div>
            <h2 class="section-title">🐔 Galerie des Poulets</h2>
            <div class="gallery-grid" id="poultryGallery"></div>
        </div>

        <div style="margin-top: 2rem; text-align: center;">
            <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimer le rapport</button>
            <a href="/?route=upload" class="btn btn-gold" style="margin-left: 0.5rem;">📸 Gérer les images</a>
            <a href="/?route=health&id=<?php echo isset($batches[0]) ? $batches[0]['id'] : 0; ?>" class="btn btn-info" style="margin-left: 0.5rem; background: #4299E1; color: white;">🏥 Suivi santé</a>
        </div>

        <!-- Footer OMEGA -->
        <div class="omega-footer">
            <div class="company-name">Ω OMEGA INFORMATIQUE CONSULTING</div>
            <div class="tagline">Solutions innovantes pour l'aviculture moderne • Gestion de projet avicole</div>
            <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #a0aec0;">
                © <?php echo date('Y'); ?> Omega Consulting • Tous droits réservés • Développé avec ❤️ pour l'aviculture
            </div>
        </div>
    </div>

    <script>
        const salesData = <?php 
            $chartData = ['labels' => [], 'values' => []];
            if (isset($salesStats)) {
                foreach ($salesStats as $sale) {
                    $chartData['labels'][] = date('d/m', strtotime($sale['date']));
                    $chartData['values'][] = $sale['total_revenue'];
                }
            }
            echo json_encode($chartData);
        ?>;

        const ctx1 = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: salesData.labels,
                datasets: [{
                    label: 'Ventes (FCFA)',
                    data: salesData.values,
                    borderColor: '#2D6A4F',
                    backgroundColor: 'rgba(45, 106, 79, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { responsive: true, plugins: { legend: { labels: { font: { family: 'Inter' } } } } }
        });

        const ctx2 = document.getElementById('mortalityChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
                datasets: [{ label: 'Pertes', data: [2, 5, 3, 1], backgroundColor: '#F4A261', borderRadius: 8 }]
            },
            options: { responsive: true, plugins: { legend: { labels: { font: { family: 'Inter' } } } } }
        });

        const ctx3 = document.getElementById('eggsChart').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{ label: 'Œufs/jour', data: [45, 52, 48, 55, 60, 58, 50], borderColor: '#E9C46A', backgroundColor: 'rgba(233, 196, 106, 0.1)', tension: 0.3, fill: true }]
            },
            options: { responsive: true, plugins: { legend: { labels: { font: { family: 'Inter' } } } } }
        });

        class PoultryGallery {
            constructor() {
                this.hens = [
                    { name: 'Plymouth Rock', breed: 'Poule pondeuse', eggRate: '85%', image: '/images/poules/plymouth-rock.jpg', description: 'Race américaine rustique, excellente pondeuse' },
                    { name: 'Sussex', breed: 'Poule pondeuse', eggRate: '90%', image: '/images/poules/sussex.jpg', description: 'Race anglaise, ponte abondante et chair fine' },
                    { name: 'Orpington', breed: 'Poule pondeuse', eggRate: '75%', image: '/images/poules/orpington.jpg', description: 'Race anglaise, poule calme et bonne couveuse' },
                    { name: 'Bresse', breed: 'Poulet Chair', weight: '3.5 kg', image: '/images/poules/bresse.jpg', description: 'Race française d\'exception, chair réputée' },
                    { name: 'Rhode Island', breed: 'Poule pondeuse', eggRate: '88%', image: '/images/poules/rhode-island.jpg', description: 'Race américaine, excellente pondeuse rustique' },
                    { name: 'Wyandotte', breed: 'Poule pondeuse', eggRate: '82%', image: '/images/poules/wyandotte.jpg', description: 'Race américaine, plumage argenté magnifique' }
                ];
                this.init();
            }
            init() { this.renderGallery(); this.animateCards(); }
            renderGallery() {
                const gallery = document.getElementById('poultryGallery');
                if (!gallery) return;
                gallery.innerHTML = this.hens.map((hen, index) => `
                    <div class="poultry-card" data-id="${index}">
                        <div class="poultry-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <img src="${hen.image}" alt="${hen.name}" style="width: 100%; height: 100%; object-fit: cover;"
                                 onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\\'font-size: 4rem;\\'>🐔</div>'"
                                 loading="lazy">
                        </div>
                        <div class="poultry-info">
                            <div class="poultry-name">${hen.name}</div>
                            <div style="color: #718096; font-size: 0.9rem;">${hen.breed} ${hen.eggRate ? `• 🥚 ${hen.eggRate}` : `• ⚖️ ${hen.weight}`}</div>
                            <div style="color: #a0aec0; font-size: 0.8rem; margin-top: 0.25rem;">${hen.description}</div>
                        </div>
                    </div>
                `).join('');
            }
            animateCards() {
                document.querySelectorAll('.poultry-card').forEach((card, i) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100 * i);
                });
            }
        }
        document.addEventListener('DOMContentLoaded', () => new PoultryGallery());
    </script>
</body>
</html>
