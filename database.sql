-- Stranger Things Wikipedia Database

CREATE DATABASE IF NOT EXISTS stranger_things_wiki;
USE stranger_things_wiki;

-- Characters Table
CREATE TABLE IF NOT EXISTS characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    actor_name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    youtube_clip_url VARCHAR(255),
    age INT,
    born_date DATE,
    height VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Episodes Table
CREATE TABLE IF NOT EXISTS episodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    season INT NOT NULL,
    episode_number INT NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    youtube_clip_url VARCHAR(255),
    air_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Locations Table
CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    maps_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Quotes Table
CREATE TABLE IF NOT EXISTS quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote_text TEXT NOT NULL,
    description TEXT,
    character_id INT,
    episode_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (character_id) REFERENCES characters(id) ON DELETE SET NULL,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE SET NULL
);

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    password_reset_token VARCHAR(255) DEFAULT NULL,
    password_reset_expires DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Data

-- Sample Characters
INSERT INTO characters (name, actor_name, description, image_url, youtube_clip_url, age, born_date, height) VALUES
('Eleven', 'Millie Bobby Brown', 'A young girl with psychokinetic abilities who escaped from Hawkins Laboratory.', 'https://media.vanityfair.com/photos/59f370dd16ff751cf425ef46/master/pass/wv_publicity_pre_launch_A_still_23.jpg', 'https://www.youtube.com/watch?v=b9EkMc79ZSU', 15, '2001-01-15', '5\'4"'),
('Mike Wheeler', 'Finn Wolfhard', 'One of the main protagonists and leader of the group of friends.', 'https://cdn.costumewall.com/wp-content/uploads/2019/07/mike-wheeler.jpg', 'https://www.youtube.com/watch?v=XWxyRG_tckY', 15, '2000-12-09', '5\'11"'),
('Dustin Henderson', 'Gaten Matarazzo', 'A loyal friend known for his intelligence and love of science.', 'https://strangerthingsttu.weebly.com/uploads/1/1/4/5/114552629/dustin-2_orig.jpg', 'https://www.youtube.com/watch?v=cZHU7rUFOLQ', 14, '2001-03-22', '5\'8"'),
('Lucas Sinclair', 'Caleb McLaughlin', 'A pragmatic member of the group with strong determination.', 'https://preview.redd.it/day-3-lucas-sinclair-v0-4svbx3j4yr2g1.jpg?width=640&crop=smart&auto=webp&s=02cbf7346418bc636dfc47a1e33a7960486abe86', 'https://www.youtube.com/watch?v=qd8K84jAEg8', 15, '2000-10-15', '5\'9"'),
('Will Byers', 'Noah Schnapp', 'The boy who went missing in the Upside Down in Season 1.', 'https://www.usmagazine.com/wp-content/uploads/2022/05/Everything-the-Stranger-Things-Cast-Has-Said-About-Will-Byers-Exploring-His-Identity-Over-the-Years7.jpg?quality=78&strip=all', 'https://www.youtube.com/watch?v=4n0R4EmxX28', 15, '2000-11-30', '5\'7"'),
('Joyce Byers', 'Winona Ryder', 'Will and Jonathan\'s protective and determined mother.', 'https://hips.hearstapps.com/hmg-prod/images/stranger-things-season-3-joyce-byers-uhdpaper-com-8k-13-1563466975.jpg?crop=0.565xw:1.00xh;0.197xw,0&resize=1200:*', 'https://www.youtube.com/watch?v=yQbUJQr83yE', 42, '1973-05-10', '5\'6"'),
('Jim Hopper', 'David Harbour', 'The chief of police in Hawkins with a troubled past.', 'https://hips.hearstapps.com/hmg-prod/images/h5-promo-stills-022519-0053-ra-1562776884.jpg?crop=0.502xw:1.00xh;0.277xw,0&resize=1200:*', 'https://www.youtube.com/watch?v=6qh2xmSdUZA', 48, '1967-08-20', '6\'2"'),
('Max Mayfield', 'Sadie Sink', 'A tough and independent girl who moves to Hawkins.', 'https://strangerthingsttu.weebly.com/uploads/1/1/4/5/114552629/max-1_1_orig.jpg', 'https://www.youtube.com/watch?v=cvrr83sN1lY', 14, '2001-06-12', '5\'5"');

-- Sample Episodes
INSERT INTO episodes (title, season, episode_number, description, image_url, youtube_clip_url, air_date) VALUES
('The Vanishing of Will Byers', 1, 1, 'On his way home from a friend\'s house, young Will sees something terrifying.', 'https://images.squarespace-cdn.com/content/v1/56cdc4478259b5c112bb2285/1470027914188-9CGT2KIEQV010892VYXZ/image-asset.jpeg', 'https://www.youtube.com/watch?v=wYn1uoN2WYc', '2016-07-15'),
('The Weirdo on Maple Street', 1, 2, 'Lucas, Mike and Dustin try to talk to the girl they found in the woods.', 'https://static.tvtropes.org/pmwiki/pub/images/the_weirdo_on_maple_street_5.jpg', 'https://www.youtube.com/watch?v=kcOufcPvAAo', '2016-07-15'),
('Holly, Jolly', 1, 3, 'An increasingly concerned Nancy looks for Barb and finds out what Jonathan\'s been up to.', 'https://i.redd.it/en52kuw8e9xf1.jpeg', 'https://www.youtube.com/watch?v=dP94UctPJPY', '2016-07-15'),
('The Body', 1, 4, 'Refusing to believe Will is dead, Joyce tries to connect with her son.', 'https://m.media-amazon.com/images/M/MV5BMjI2MTc2MzEwNF5BMl5BanBnXkFtZTgwNzc0ODE0OTE@._V1_.jpg', 'https://www.youtube.com/watch?v=ldvNUqrKJec', '2016-07-15'),
('MADMAX', 2, 1, 'As the town preps for Halloween, a high-scoring rival shakes things up at the arcade.', 'https://m.media-amazon.com/images/M/MV5BZjczYmY5MzktMmFmYi00YzExLTlmYzEtZGM2YzAxMDQ4OGE0XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/watch?v=-stxa3WndBY', '2017-10-27');

-- Sample Locations
INSERT INTO locations (name, description, image_url, maps_url) VALUES
('Hawkins Laboratory', 'A secretive government facility conducting experiments, including those on Eleven.', 'https://ew.com/thmb/Xb5vf5l6klpxBfAJTFEFkQ8goFM=/2000x0/filters:no_upscale():max_bytes(150000):strip_icc()/hawkins_lab-stranger-things-050324-c6b1f49927da42208725a8f9ceb69ac3.jpg', 'https://maps.app.goo.gl/b8hmEsuFHevMDEwb7'),
('The Upside Down', 'A dark, parallel dimension existing alongside the human world.', 'https://static0.srcdn.com/wordpress/wp-content/uploads/2019/06/Stranger-Things-Demogorgon-and-Mind-Flayer.jpg?w=1200&h=675&fit=crop', NULL),
('Hawkins Middle School', 'The school attended by Mike, Dustin, Lucas, Will, and Eleven.', 'https://preview.redd.it/7y5ofu2rxq931.jpg?width=640&crop=smart&auto=webp&s=21ea4ede453583982479ac300524eecf37647c7b', 'https://maps.app.goo.gl/wC9ZJHBbgsRw1DVEA'),
('Byers House', 'Home of Joyce, Will, and Jonathan Byers.', 'https://www.hollywoodreporter.com/wp-content/uploads/2024/10/byers-house-stranger-things-airbnb-living-room-2-MAIN-2024-1.png', 'https://maps.app.goo.gl/EkiKFJH98F4tZymS7'),
('Starcourt Mall', 'A new shopping mall in Hawkins that plays a central role in Season 3.', 'https://media.cnn.com/api/v1/images/stellar/prod/191010131320-stranger-things-3-mall.jpg?q=x_33,y_106,h_1108,w_1970,c_crop/h_833,w_1480', 'https://maps.app.goo.gl/bw35VKjqhfp55ZVJ7'),
('Hawkins Town Square', 'The central area of Hawkins where community events take place.', 'https://videocdn.cdnpk.net/videos/b0ad6d08-b657-42c8-b2c5-78a72c5d5550/horizontal/thumbnails/large.jpg?item_id=368689&w=740&q=80', 'https://maps.app.goo.gl/G8m4itMLA7q2BHoD9');

-- Sample Quotes
INSERT INTO quotes (quote_text, description, character_id, episode_id) VALUES
('Friends don\'t lie.', 'Eleven\'s iconic phrase about trust and honesty.', 1, 1),
('Mornings are for coffee and contemplation.', 'Chief Hopper\'s philosophy on starting the day.', 7, 1),
('She\'s our friend and she\'s crazy!', 'Dustin defending Eleven to the group.', 3, 2),
('Bitchin\'', 'Max\'s favorite expression of approval.', 8, NULL);
