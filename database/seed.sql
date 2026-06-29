USE aviculture;

-- Supprimer les données existantes (optionnel)
-- TRUNCATE TABLE daily_records;
-- TRUNCATE TABLE egg_production;
-- TRUNCATE TABLE sales;
-- TRUNCATE TABLE expenses;
-- TRUNCATE TABLE treatments;
-- TRUNCATE TABLE daily_records;
-- TRUNCATE TABLE batches;
-- TRUNCATE TABLE buildings;

-- 1. Bâtiments
INSERT INTO buildings (name, type, capacity, current_stock) VALUES
('Bâtiment A - Poulets de Chair', 'poulet_chair', 600, 580),
('Bâtiment B - Poules Pondeuses', 'poule_pondeuse', 400, 385),
('Bâtiment C - Élevage', 'poulet_chair', 500, 490);

-- 2. Lots
INSERT INTO batches (building_id, name, start_date, initial_quantity, current_quantity, average_weight, age_days, status) VALUES
(1, 'Lot Chair - Mars 2026', '2026-03-01', 600, 580, 2.8, 28, 'actif'),
(1, 'Lot Chair - Février 2026', '2026-02-01', 550, 530, 3.2, 56, 'fini'),
(2, 'Lot Pondeuses - Avril 2026', '2026-04-01', 400, 385, 1.9, 14, 'actif'),
(2, 'Lot Pondeuses - Mars 2026', '2026-03-15', 380, 370, 2.0, 42, 'actif'),
(3, 'Lot Elevage - Mai 2026', '2026-05-01', 500, 490, 1.5, 7, 'actif');

-- 3. Enregistrements quotidiens (30 jours)
INSERT INTO daily_records (batch_id, record_date, feed_consumed, water_consumed, mortality, eggs_collected, average_weight) VALUES
-- Lot Chair Mars 2026 (ID 1)
(1, DATE_SUB(CURDATE(), INTERVAL 28 DAY), 85.5, 220.0, 1, 0, 1.2),
(1, DATE_SUB(CURDATE(), INTERVAL 27 DAY), 87.2, 225.5, 1, 0, 1.3),
(1, DATE_SUB(CURDATE(), INTERVAL 26 DAY), 88.0, 228.0, 0, 0, 1.4),
(1, DATE_SUB(CURDATE(), INTERVAL 25 DAY), 89.5, 230.5, 1, 0, 1.5),
(1, DATE_SUB(CURDATE(), INTERVAL 24 DAY), 91.0, 235.0, 0, 0, 1.6),
(1, DATE_SUB(CURDATE(), INTERVAL 23 DAY), 92.5, 238.5, 1, 0, 1.7),
(1, DATE_SUB(CURDATE(), INTERVAL 22 DAY), 94.0, 240.0, 0, 0, 1.8),
(1, DATE_SUB(CURDATE(), INTERVAL 21 DAY), 95.5, 245.5, 1, 0, 1.9),
(1, DATE_SUB(CURDATE(), INTERVAL 20 DAY), 97.0, 248.0, 0, 0, 2.0),
(1, DATE_SUB(CURDATE(), INTERVAL 19 DAY), 98.5, 250.5, 1, 0, 2.1),
(1, DATE_SUB(CURDATE(), INTERVAL 18 DAY), 100.0, 255.0, 0, 0, 2.2),
(1, DATE_SUB(CURDATE(), INTERVAL 17 DAY), 102.5, 258.5, 1, 0, 2.3),
(1, DATE_SUB(CURDATE(), INTERVAL 16 DAY), 105.0, 260.0, 0, 0, 2.4),
(1, DATE_SUB(CURDATE(), INTERVAL 15 DAY), 107.5, 265.5, 1, 0, 2.5),
(1, DATE_SUB(CURDATE(), INTERVAL 14 DAY), 110.0, 268.0, 0, 0, 2.6),
(1, DATE_SUB(CURDATE(), INTERVAL 13 DAY), 112.5, 270.5, 1, 0, 2.7),
(1, DATE_SUB(CURDATE(), INTERVAL 12 DAY), 115.0, 275.0, 0, 0, 2.8),
(1, DATE_SUB(CURDATE(), INTERVAL 11 DAY), 118.5, 280.5, 1, 0, 2.9),
(1, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 120.0, 285.0, 0, 0, 3.0),
(1, DATE_SUB(CURDATE(), INTERVAL 9 DAY), 125.5, 290.5, 1, 0, 3.1),
(1, DATE_SUB(CURDATE(), INTERVAL 8 DAY), 130.0, 295.0, 0, 0, 3.2),
(1, DATE_SUB(CURDATE(), INTERVAL 7 DAY), 135.5, 300.0, 1, 0, 3.3),
(1, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 140.0, 310.0, 0, 0, 3.4),
(1, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 145.5, 320.0, 1, 0, 3.5),
(1, DATE_SUB(CURDATE(), INTERVAL 4 DAY), 150.0, 330.0, 0, 0, 3.6),
(1, DATE_SUB(CURDATE(), INTERVAL 3 DAY), 155.5, 340.0, 1, 0, 3.7),
(1, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 160.0, 350.0, 0, 0, 3.8),
(1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 165.5, 360.0, 1, 0, 3.9),
(1, CURDATE(), 170.0, 370.0, 0, 0, 4.0);

-- Poules Pondeuses Avril 2026 (ID 3)
INSERT INTO daily_records (batch_id, record_date, feed_consumed, water_consumed, mortality, eggs_collected, average_weight) VALUES
(3, DATE_SUB(CURDATE(), INTERVAL 14 DAY), 45.0, 120.0, 0, 180, 1.8),
(3, DATE_SUB(CURDATE(), INTERVAL 13 DAY), 45.5, 122.0, 0, 185, 1.8),
(3, DATE_SUB(CURDATE(), INTERVAL 12 DAY), 46.0, 125.0, 1, 182, 1.9),
(3, DATE_SUB(CURDATE(), INTERVAL 11 DAY), 46.5, 128.0, 0, 190, 1.9),
(3, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 47.0, 130.0, 0, 195, 1.9),
(3, DATE_SUB(CURDATE(), INTERVAL 9 DAY), 47.5, 132.0, 0, 188, 1.9),
(3, DATE_SUB(CURDATE(), INTERVAL 8 DAY), 48.0, 135.0, 0, 200, 1.9),
(3, DATE_SUB(CURDATE(), INTERVAL 7 DAY), 48.5, 138.0, 0, 195, 1.9),
(3, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 49.0, 140.0, 0, 210, 2.0),
(3, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 49.5, 142.0, 0, 205, 2.0),
(3, DATE_SUB(CURDATE(), INTERVAL 4 DAY), 50.0, 145.0, 0, 215, 2.0),
(3, DATE_SUB(CURDATE(), INTERVAL 3 DAY), 50.5, 148.0, 0, 220, 2.0),
(3, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 51.0, 150.0, 0, 225, 2.0),
(3, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 51.5, 152.0, 0, 230, 2.0),
(3, CURDATE(), 52.0, 155.0, 0, 235, 2.0);

-- 4. Production d'œufs
INSERT INTO egg_production (batch_id, record_date, eggs_collected, broken_eggs, saleable_eggs) VALUES
(3, DATE_SUB(CURDATE(), INTERVAL 14 DAY), 180, 2, 178),
(3, DATE_SUB(CURDATE(), INTERVAL 13 DAY), 185, 1, 184),
(3, DATE_SUB(CURDATE(), INTERVAL 12 DAY), 182, 3, 179),
(3, DATE_SUB(CURDATE(), INTERVAL 11 DAY), 190, 1, 189),
(3, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 195, 2, 193),
(3, DATE_SUB(CURDATE(), INTERVAL 9 DAY), 188, 0, 188),
(3, DATE_SUB(CURDATE(), INTERVAL 8 DAY), 200, 2, 198),
(3, DATE_SUB(CURDATE(), INTERVAL 7 DAY), 195, 1, 194),
(3, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 210, 2, 208),
(3, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 205, 0, 205),
(3, DATE_SUB(CURDATE(), INTERVAL 4 DAY), 215, 1, 214),
(3, DATE_SUB(CURDATE(), INTERVAL 3 DAY), 220, 2, 218),
(3, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 225, 1, 224),
(3, DATE_SUB(CURDATE(), INTERVAL 1 DAY), 230, 2, 228),
(3, CURDATE(), 235, 1, 234);

-- 5. Ventes
INSERT INTO sales (batch_id, sale_date, quantity, unit_price, total_amount, buyer_name, sale_type) VALUES
-- Ventes de poulets
(1, DATE_SUB(CURDATE(), INTERVAL 20 DAY), 30, 4500, 135000, 'Marché Central de Dakar', 'poulet'),
(1, DATE_SUB(CURDATE(), INTERVAL 15 DAY), 25, 4600, 115000, 'Super U - Auchan', 'poulet'),
(1, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 40, 4700, 188000, 'Restaurant Le Baobab', 'poulet'),
(1, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 35, 4800, 168000, 'Marché de Thiaroye', 'poulet'),
(1, CURDATE(), 20, 5000, 100000, 'Boucherie Moderne', 'poulet'),
(2, DATE_SUB(CURDATE(), INTERVAL 30 DAY), 50, 4200, 210000, 'Marché Central', 'poulet'),
(2, DATE_SUB(CURDATE(), INTERVAL 20 DAY), 40, 4400, 176000, 'Super U', 'poulet'),

-- Ventes d'œufs
(3, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 200, 450, 90000, 'Boulangerie Pain dOr', 'oeuf'),
(3, DATE_SUB(CURDATE(), INTERVAL 8 DAY), 180, 460, 82800, 'Marché de Castors', 'oeuf'),
(3, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 220, 470, 103400, 'Pâtisserie La Douceur', 'oeuf'),
(3, DATE_SUB(CURDATE(), INTERVAL 4 DAY), 200, 480, 96000, 'Super Marché Jumbo', 'oeuf'),
(3, DATE_SUB(CURDATE(), INTERVAL 2 DAY), 230, 490, 112700, 'Hôtel Ngor', 'oeuf'),
(3, CURDATE(), 200, 500, 100000, 'Boulangerie Moderne', 'oeuf'),

-- Ventes mixtes
(4, DATE_SUB(CURDATE(), INTERVAL 7 DAY), 150, 450, 67500, 'Marché Fass', 'oeuf'),
(4, DATE_SUB(CURDATE(), INTERVAL 3 DAY), 100, 480, 48000, 'Hôtel Teranga', 'oeuf');

-- 6. Charges
INSERT INTO expenses (batch_id, expense_date, category, description, amount) VALUES
-- Charges Aliment
(1, DATE_SUB(CURDATE(), INTERVAL 25 DAY), 'Aliment', 'Aliment de démarrage 200kg', 75000),
(1, DATE_SUB(CURDATE(), INTERVAL 20 DAY), 'Aliment', 'Aliment croissance 300kg', 120000),
(1, DATE_SUB(CURDATE(), INTERVAL 15 DAY), 'Aliment', 'Aliment finition 250kg', 105000),
(1, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 'Aliment', 'Aliment finition 300kg', 126000),
(1, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'Aliment', 'Aliment finition 350kg', 147000),
(1, CURDATE(), 'Aliment', 'Aliment finition 400kg', 168000),
(3, DATE_SUB(CURDATE(), INTERVAL 12 DAY), 'Aliment', 'Aliment ponte 150kg', 75000),
(3, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 'Aliment', 'Aliment ponte 200kg', 100000),
(3, CURDATE(), 'Aliment', 'Aliment ponte 250kg', 125000),

-- Charges Vétérinaire
(1, DATE_SUB(CURDATE(), INTERVAL 20 DAY), 'Vétérinaire', 'Vaccin Marek', 25000),
(1, DATE_SUB(CURDATE(), INTERVAL 15 DAY), 'Vétérinaire', 'Vaccin Gumboro', 18000),
(1, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 'Vétérinaire', 'Antibiotiques', 35000),
(1, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'Vétérinaire', 'Vitamines', 12000),
(3, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 'Vétérinaire', 'Vaccin pondeuses', 22000),
(3, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'Vétérinaire', 'Déparasitant', 15000),

-- Charges Eau
(1, DATE_SUB(CURDATE(), INTERVAL 15 DAY), 'Eau', 'Facture eau - SDE', 45000),
(3, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 'Eau', 'Facture eau - SDE', 32000),

-- Charges Energie
(1, DATE_SUB(CURDATE(), INTERVAL 20 DAY), 'Energie', 'Électricité - Senelec', 85000),
(3, DATE_SUB(CURDATE(), INTERVAL 15 DAY), 'Energie', 'Électricité - Senelec', 65000),

-- Charges Autres
(1, DATE_SUB(CURDATE(), INTERVAL 18 DAY), 'Autre', 'Litière - Sciure 1000kg', 50000),
(1, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 'Autre', 'Main d\'œuvre - Salaires', 150000),
(3, DATE_SUB(CURDATE(), INTERVAL 8 DAY), 'Autre', 'Nids pour pondeuses', 30000);

-- 7. Traitements vétérinaires
INSERT INTO veterinary_products (name, category, unit_price, stock_quantity, expiry_date) VALUES
('Vaccin Marek', 'Vaccin', 25000, 15, '2027-06-30'),
('Vaccin Gumboro', 'Vaccin', 18000, 12, '2027-12-31'),
('Antibiotique SP', 'Antibiotique', 35000, 8, '2026-12-31'),
('Vitamines Sol', 'Vitamines', 12000, 20, '2027-03-31'),
('Déparasitant Bio', 'Déparasitant', 15000, 10, '2027-09-30');

INSERT INTO treatments (batch_id, product_id, administration_date, dosage, cost, notes) VALUES
(1, 1, DATE_SUB(CURDATE(), INTERVAL 20 DAY), 50, 25000, 'Vaccination Marek - jour 1'),
(1, 2, DATE_SUB(CURDATE(), INTERVAL 15 DAY), 40, 18000, 'Vaccination Gumboro - booster'),
(1, 3, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 30, 35000, 'Traitement antibiotique - 5 jours'),
(1, 4, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 20, 12000, 'Supplémentation vitaminique'),
(3, 1, DATE_SUB(CURDATE(), INTERVAL 10 DAY), 30, 22000, 'Vaccination pondeuses'),
(3, 5, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 25, 15000, 'Déparasitage routine');

-- 8. Mettre à jour les statistiques des lots
UPDATE batches b
SET 
    current_quantity = (
        SELECT initial_quantity - COALESCE(SUM(mortality), 0)
        FROM daily_records 
        WHERE batch_id = b.id
    ),
    average_weight = (
        SELECT AVG(average_weight)
        FROM daily_records 
        WHERE batch_id = b.id AND average_weight > 0
        ORDER BY record_date DESC
        LIMIT 1
    )
WHERE id IN (1, 2, 3, 4, 5);

-- Afficher un résumé
SELECT '✅ Base de données peuplée avec succès !' as Message;
SELECT '📊 Statistiques:' as '';
SELECT 
    (SELECT COUNT(*) FROM batches) as 'Lots',
    (SELECT COUNT(*) FROM daily_records) as 'Enregistrements',
    (SELECT COUNT(*) FROM sales) as 'Ventes',
    (SELECT COUNT(*) FROM expenses) as 'Charges',
    (SELECT COUNT(*) FROM egg_production) as 'Production œufs';

SELECT '🐓 Lots actifs:' as '';
SELECT id, name, current_quantity, status, average_weight FROM batches;

SELECT '💰 Résumé financier:' as '';
SELECT 
    COALESCE((SELECT SUM(total_amount) FROM sales), 0) as 'Chiffre d\'affaires',
    COALESCE((SELECT SUM(amount) FROM expenses), 0) as 'Charges totales',
    COALESCE((SELECT SUM(total_amount) FROM sales), 0) - COALESCE((SELECT SUM(amount) FROM expenses), 0) as 'Résultat brut';

SELECT '🥚 Production totale d\'œufs: ' || COALESCE((SELECT SUM(eggs_collected) FROM egg_production), 0) as '';
