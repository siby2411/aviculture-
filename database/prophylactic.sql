-- Suivi prophylactique complet

-- 1. Vue des indicateurs de santé
CREATE OR REPLACE VIEW v_health_indicators AS
SELECT 
    b.id as batch_id,
    b.name as batch_name,
    b.current_quantity,
    h.temperature_avg,
    h.humidity_avg,
    h.ammonia_level,
    h.feed_intake,
    h.water_intake,
    h.mortality_count as daily_mortality,
    h.sick_birds,
    h.injured_birds,
    h.check_date as last_check,
    (SELECT COUNT(*) FROM mortality_detail md WHERE md.batch_id = b.id) as total_mortality,
    (SELECT AVG(avg_weight) FROM weight_monitoring wm WHERE wm.batch_id = b.id ORDER BY weigh_date DESC LIMIT 1) as avg_weight
FROM batches b
LEFT JOIN health_monitoring h ON b.id = h.batch_id AND h.check_date = (SELECT MAX(check_date) FROM health_monitoring WHERE batch_id = b.id)
WHERE b.status = 'actif';

-- 2. Vue des performances
CREATE OR REPLACE VIEW v_batch_performance AS
SELECT 
    b.id,
    b.name,
    b.current_quantity,
    b.initial_quantity,
    b.start_date,
    DATEDIFF(CURDATE(), b.start_date) as age_days,
    COALESCE(SUM(dr.eggs_collected), 0) as total_eggs,
    COALESCE(SUM(dr.mortality), 0) as total_mortality,
    COALESCE(AVG(dr.average_weight), 0) as avg_weight,
    COALESCE(SUM(s.total_amount), 0) as total_revenue,
    COALESCE(SUM(e.amount), 0) as total_expenses
FROM batches b
LEFT JOIN daily_records dr ON b.id = dr.batch_id
LEFT JOIN sales s ON b.id = s.batch_id
LEFT JOIN expenses e ON b.id = e.batch_id
GROUP BY b.id;
