
-- Bảng người dùng
CREATE TABLE Thong_tin_nguoi_dung (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    email VARCHAR(100),
    password_hash VARCHAR(255),
    avatar_url VARCHAR(255),
    role ENUM('user','admin'),
    status ENUM('active','banned'),
    created_at DATETIME,
    last_login DATETIME
);

-- Bảng danh mục món ăn
CREATE TABLE danh_muc_mon_an (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    description TEXT
);

-- Bảng công thức nấu ăn
CREATE TABLE Cong_thuc_nau_an (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    cook_time INT,
    servings INT,
    difficulty ENUM('easy','medium','hard'),
    category_id INT,
    author_id INT,
    image_url VARCHAR(255),
    video_url VARCHAR(255),
    created_at DATETIME,
    FOREIGN KEY (category_id) REFERENCES danh_muc_mon_an(category_id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES Thong_tin_nguoi_dung(user_id) ON DELETE CASCADE
);

-- Bảng nguyên liệu
CREATE TABLE Nguyen_lieu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT,
    ingredient_name VARCHAR(100),
    quantity VARCHAR(50),
    FOREIGN KEY (recipe_id) REFERENCES Cong_thuc_nau_an(recipe_id) ON DELETE CASCADE
);

-- Bảng các bước nấu ăn
CREATE TABLE Cac_buoc_nau_an (
    step_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT,
    step_number INT,
    description TEXT,
    image_url VARCHAR(255),
    FOREIGN KEY (recipe_id) REFERENCES Cong_thuc_nau_an(recipe_id) ON DELETE CASCADE
);

-- Bảng món ăn yêu thích (many-to-many: user - recipe)
CREATE TABLE Mon_an_yeu_thich (
    favorite_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    recipe_id INT,
    saved_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES Thong_tin_nguoi_dung(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Cong_thuc_nau_an(recipe_id) ON DELETE CASCADE
);

-- Bảng bình luận
CREATE TABLE Binh_luan (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    recipe_id INT,
    content TEXT,
    created_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES Thong_tin_nguoi_dung(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Cong_thuc_nau_an(recipe_id) ON DELETE CASCADE
);

-- Bảng đánh giá
CREATE TABLE Danh_gia (
    rating_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    recipe_id INT,
    rating_value INT CHECK (rating_value BETWEEN 1 AND 5),
    rated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES Thong_tin_nguoi_dung(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Cong_thuc_nau_an(recipe_id) ON DELETE CASCADE
);

-- Bảng báo cáo
CREATE TABLE Bao_cao (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    recipe_id INT,
    reason TEXT,
    status ENUM('pending','resolved'),
    reported_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES Thong_tin_nguoi_dung(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES Cong_thuc_nau_an(recipe_id) ON DELETE CASCADE
);

