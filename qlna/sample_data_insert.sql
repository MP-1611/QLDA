
-- USERS
INSERT INTO Thong_tin_nguoi_dung (username, email, password_hash, avatar_url, role, status, created_at, last_login) VALUES
('alice', 'alice@example.com', 'hashed_password1', 'avatar1.png', 'user', 'active', '2025-07-25 13:14:59', '2025-07-25 13:14:59'),
('bob', 'bob@example.com', 'hashed_password2', 'avatar2.png', 'user', 'active', '2025-07-21 13:14:59', '2025-07-21 13:14:59'),
('carol', 'carol@example.com', 'hashed_password3', 'avatar3.png', 'admin', 'active', '2025-07-06 13:14:59', '2025-07-06 13:14:59');

-- CATEGORIES
INSERT INTO danh_muc_mon_an (name, description) VALUES
('Món chay', 'Các món ăn không dùng thịt cá'),
('Tráng miệng', 'Các món ngọt sau bữa ăn'),
('Món chính', 'Món ăn chính trong bữa ăn');

-- RECIPES
INSERT INTO Cong_thuc_nau_an (title, description, cook_time, servings, difficulty, category_id, author_id, image_url, video_url, created_at) VALUES
('Bún chay', 'Bún với nước lèo chay thanh đạm', 30, 2, 'easy', 1, 1, 'bun_chay.jpg', '', '2025-07-02 13:14:59'),
('Bánh flan', 'Món tráng miệng mềm mịn, béo ngậy', 45, 4, 'medium', 2, 2, 'banh_flan.jpg', '', '2025-07-24 13:14:59'),
('Cơm gà', 'Món chính với gà và cơm vàng thơm', 60, 4, 'medium', 3, 1, 'com_ga.jpg', '', '2025-07-29 13:14:59');

-- INGREDIENTS
INSERT INTO Nguyen_lieu (recipe_id, ingredient_name, quantity) VALUES
(1, 'Bún', '200g'), (1, 'Nấm rơm', '100g'), (1, 'Đậu hũ', '2 miếng'),
(2, 'Trứng gà', '4 quả'), (2, 'Sữa đặc', '1 lon'), (2, 'Đường', '100g'),
(3, 'Gạo', '300g'), (3, 'Gà ta', '1 con'), (3, 'Hành tím', '50g');
