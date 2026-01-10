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
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Data

-- Sample Characters
INSERT INTO characters (name, actor_name, description, image_url, youtube_clip_url, age, born_date, height) VALUES
('Eleven', 'Millie Bobby Brown', 'A young girl with extraordinary psychokinetic and telepathic abilities who escaped from the mysterious Hawkins National Laboratory. Raised as a test subject, she was experimented on throughout her childhood and developed powerful abilities including telekinesis, remote viewing, and dimensional travel. Despite her traumatic past, she forms deep bonds with Mike and his friends, becoming a crucial member of their group in fighting the threats from the Upside Down.', 'https://media.vanityfair.com/photos/59f370dd16ff751cf425ef46/master/pass/wv_publicity_pre_launch_A_still_23.jpg', 'https://www.youtube.com/watch?v=b9EkMc79ZSU', 15, '2001-01-15', '5\'4"'),
('Mike Wheeler', 'Finn Wolfhard', 'One of the main protagonists and the natural leader of the group of friends in Hawkins. Mike is intelligent, compassionate, and fiercely loyal to his friends and family. He is the first to befriend Eleven and develops a deep romantic connection with her. Mike demonstrates exceptional bravery throughout the series, often putting himself in danger to protect those he cares about. His strategic thinking and unwavering determination make him the heart of the group.', 'https://cdn.costumewall.com/wp-content/uploads/2019/07/mike-wheeler.jpg', 'https://www.youtube.com/watch?v=XWxyRG_tckY', 15, '2000-12-09', '5\'11"'),
('Dustin Henderson', 'Gaten Matarazzo', 'A loyal and endearing friend known for his exceptional intelligence, scientific curiosity, and love of technology. Born with cleidocranial dysplasia, Dustin never lets his condition define him. He is the most scientifically-minded member of the group and often provides crucial insights into the supernatural phenomena they encounter. His infectious enthusiasm, quick wit, and ability to befriend anyone (including a baby Demogorgon) make him an invaluable member of the team.', 'https://strangerthingsttu.weebly.com/uploads/1/1/4/5/114552629/dustin-2_orig.jpg', 'https://www.youtube.com/watch?v=cZHU7rUFOLQ', 14, '2001-03-22', '5\'8"'),
('Lucas Sinclair', 'Caleb McLaughlin', 'A pragmatic and realistic member of the group who often serves as the voice of reason. Lucas is athletic, brave, and possesses strong moral convictions. While he can be skeptical and cautious, especially when the group first meets Eleven, he proves himself to be deeply loyal and protective of his friends. His relationship with Max brings out his romantic and caring side, and his skills with a wrist rocket have saved the group on multiple occasions.', 'https://preview.redd.it/day-3-lucas-sinclair-v0-4svbx3j4yr2g1.jpg?width=640&crop=smart&auto=webp&s=02cbf7346418bc636dfc47a1e33a7960486abe86', 'https://www.youtube.com/watch?v=qd8K84jAEg8', 15, '2000-10-15', '5\'9"'),
('Will Byers', 'Noah Schnapp', 'The sensitive and artistic boy who went missing in the Upside Down during the first season, setting the entire series into motion. Will possesses a gentle and creative nature, with a talent for drawing and a deep appreciation for art. His disappearance and subsequent experiences in the Upside Down leave him with a lingering connection to that dimension and the Mind Flayer. Despite his trauma, Will shows remarkable resilience and courage as he struggles to return to normalcy while dealing with possession and visions.', 'https://www.usmagazine.com/wp-content/uploads/2022/05/Everything-the-Stranger-Things-Cast-Has-Said-About-Will-Byers-Exploring-His-Identity-Over-the-Years7.jpg?quality=78&strip=all', 'https://www.youtube.com/watch?v=4n0R4EmxX28', 15, '2000-11-30', '5\'7"'),
('Joyce Byers', 'Winona Ryder', 'Will and Jonathan\'s fiercely protective and determined mother who works multiple jobs to support her family. Joyce is initially viewed as unstable when she insists Will is alive despite his apparent death, but her maternal instinct proves correct. She displays extraordinary courage and resourcefulness in her quest to save her son, communicating with him through Christmas lights and venturing into the Upside Down. Her unwavering love and determination make her one of the most formidable characters in the series.', 'https://hips.hearstapps.com/hmg-prod/images/stranger-things-season-3-joyce-byers-uhdpaper-com-8k-13-1563466975.jpg?crop=0.565xw:1.00xh;0.197xw,0&resize=1200:*', 'https://www.youtube.com/watch?v=yQbUJQr83yE', 42, '1973-05-10', '5\'6"'),
('Jim Hopper', 'David Harbour', 'The chief of police in Hawkins who carries the weight of a troubled past, including the loss of his young daughter to cancer and a failed marriage. Initially appearing as a cynical, world-weary lawman with substance abuse issues, Hopper transforms throughout the series into a heroic father figure. His investigation into Will\'s disappearance leads him to uncover the dark secrets of Hawkins Lab. He becomes Eleven\'s adoptive father, showing a tender and protective side while maintaining his tough, resourceful nature.', 'https://hips.hearstapps.com/hmg-prod/images/h5-promo-stills-022519-0053-ra-1562776884.jpg?crop=0.502xw:1.00xh;0.277xw,0&resize=1200:*', 'https://www.youtube.com/watch?v=6qh2xmSdUZA', 48, '1967-08-20', '6\'2"'),
('Max Mayfield', 'Sadie Sink', 'A tough, independent, and skilled skateboarder who moves to Hawkins from California with her mother and abusive stepbrother Billy. Max initially appears standoffish and reluctant to join the group, having been hurt in the past. However, she proves to be brave, loyal, and a valuable addition to the team. Her arcade skills earn her the nickname "MADMAX," and her relationship with Lucas develops into a sweet romance. She struggles with her complicated family dynamics while fighting alongside her friends against supernatural threats.', 'https://strangerthingsttu.weebly.com/uploads/1/1/4/5/114552629/max-1_1_orig.jpg', 'https://www.youtube.com/watch?v=cvrr83sN1lY', 14, '2001-06-12', '5\'5"');

-- Sample Episodes
INSERT INTO episodes (title, season, episode_number, description, image_url, youtube_clip_url, air_date) VALUES
('The Vanishing of Will Byers', 1, 1, 'On his way home from a friend\'s house after a night of playing Dungeons & Dragons, young Will Byers encounters something terrifying in the woods near his home. His sudden disappearance sets off a chain of events that will uncover dark secrets in the small town of Hawkins. Meanwhile, a mysterious girl with a shaved head and supernatural powers escapes from a nearby government laboratory, setting the stage for an incredible adventure that will change everything.', 'https://images.squarespace-cdn.com/content/v1/56cdc4478259b5c112bb2285/1470027914188-9CGT2KIEQV010892VYXZ/image-asset.jpeg', 'https://www.youtube.com/watch?v=wYn1uoN2WYc', '2016-07-15'),
('The Weirdo on Maple Street', 1, 2, 'Lucas, Mike and Dustin try to talk to and understand the strange girl they found in the woods, who reveals she has telekinetic powers and knows something about Will\'s disappearance. The boys nickname her "Eleven" based on the tattoo on her wrist. As Joyce becomes increasingly convinced that Will is trying to communicate with her through the lights in her house, the boys hide Eleven in Mike\'s basement. Meanwhile, Hopper\'s investigation into Will\'s disappearance leads him to question the suspicious activities at Hawkins Laboratory.', 'https://static.tvtropes.org/pmwiki/pub/images/the_weirdo_on_maple_street_5.jpg', 'https://www.youtube.com/watch?v=kcOufcPvAAo', '2016-07-15'),
('Holly, Jolly', 1, 3, 'An increasingly concerned Nancy looks for her missing friend Barb and begins to suspect something terrible has happened. She teams up with social outcast Jonathan Byers, who has been taking photographs in the woods. Together they discover evidence of a creature and a dark parallel dimension. Meanwhile, Joyce believes she can communicate with Will through Christmas lights and begins stringing them throughout her house. Hopper breaks into the morgue and makes a shocking discovery about Will\'s supposed body, realizing the lab is covering something up.', 'https://i.redd.it/en52kuw8e9xf1.jpeg', 'https://www.youtube.com/watch?v=dP94UctPJPY', '2016-07-15'),
('The Body', 1, 4, 'Refusing to believe that Will is actually dead despite the discovery of his body, Joyce becomes more determined than ever to find her son. She is convinced he is trapped somewhere and trying to reach her. The boys, with Eleven\'s help, use their teacher\'s AV equipment to boost a radio signal, attempting to reach Will in what Eleven calls "the Upside Down." Hopper discovers the truth about the fake body and teams up with Joyce. Nancy and Jonathan follow a trail of blood and make a terrifying discovery in the woods when they encounter the otherworldly monster.', 'https://m.media-amazon.com/images/M/MV5BMjI2MTc2MzEwNF5BMl5BanBnXkFtZTgwNzc0ODE0OTE@._V1_.jpg', 'https://www.youtube.com/watch?v=ldvNUqrKJec', '2016-07-15'),
('MADMAX', 2, 1, 'As the town of Hawkins prepares for Halloween celebrations one year after Will\'s return, a mysterious new high-scoring rival with the arcade name "MADMAX" shakes things up at the Palace Arcade, breaking Dustin\'s Dragon\'s Lair record. The boys are intrigued by this gaming prodigy, who turns out to be Max Mayfield, a tough skateboarding girl from California. Meanwhile, Will experiences disturbing visions of the Upside Down that seem more real than memories. Joyce and Hopper worry about his episodes while the boys excitedly plan their Ghostbusters costumes for Halloween night.', 'https://m.media-amazon.com/images/M/MV5BZjczYmY5MzktMmFmYi00YzExLTlmYzEtZGM2YzAxMDQ4OGE0XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/watch?v=-stxa3WndBY', '2017-10-27');

-- Sample Locations
INSERT INTO locations (name, description, image_url, maps_url) VALUES
('Hawkins Laboratory', 'A top-secret government research facility operated by the United States Department of Energy, located on the outskirts of Hawkins, Indiana. The laboratory conducts classified experiments involving psychic abilities, interdimensional travel, and sensory deprivation. It is here that Eleven and other test subjects with supernatural powers were raised and experimented upon. The lab\'s experiments inadvertently opened a gateway to the Upside Down, unleashing dangerous creatures and phenomena upon the town. The facility is heavily guarded and maintains a public cover as an energy research center.', 'https://ew.com/thmb/Xb5vf5l6klpxBfAJTFEFkQ8goFM=/2000x0/filters:no_upscale():max_bytes(150000):strip_icc()/hawkins_lab-stranger-things-050324-c6b1f49927da42208725a8f9ceb69ac3.jpg', 'https://maps.app.goo.gl/b8hmEsuFHevMDEwb7'),
('The Upside Down', 'A dark, cold, and hostile alternate dimension existing in parallel to the human world. This nightmarish realm is a twisted, decaying reflection of Hawkins, covered in toxic vines and floating spores. The Upside Down is home to terrifying creatures including Demogorgons and the Mind Flayer. Time seems frozen in this dimension, stuck at the moment the gate was first opened. The environment is extremely dangerous to humans, with toxic air and predatory monsters. Those who become trapped there face near-certain death without rescue.', 'https://static0.srcdn.com/wordpress/wp-content/uploads/2019/06/Stranger-Things-Demogorgon-and-Mind-Flayer.jpg?w=1200&h=675&fit=crop', NULL),
('Hawkins Middle School', 'The local middle school attended by Mike Wheeler, Dustin Henderson, Lucas Sinclair, Will Byers, Eleven, and Max Mayfield. The school serves as a central gathering place for the main characters and features prominently throughout the series. It houses the AV Club where the boys spend much of their time working on projects and playing Dungeons & Dragons. The school also has a gymnasium where the kids attend the Snow Ball dance and other events. Mr. Clarke, the beloved science teacher, provides crucial scientific knowledge that helps the kids understand the supernatural phenomena they encounter.', 'https://preview.redd.it/7y5ofu2rxq931.jpg?width=640&crop=smart&auto=webp&s=21ea4ede453583982479ac300524eecf37647c7b', 'https://maps.app.goo.gl/wC9ZJHBbgsRw1DVEA'),
('Starcourt Mall', 'A newly built shopping mall that opened in Hawkins in 1985, representing the height of American consumer culture in the 1980s. The mall features numerous stores, a food court, and a movie theater. Beneath the mall lies a secret Soviet operation attempting to reopen the gate to the Upside Down. The mall becomes a major battleground in Season 3 as the characters discover and attempt to stop the Russian conspiracy. Steve and Robin work at Scoops Ahoy ice cream parlor, while Eleven and Max enjoy shopping at various stores. The mall ultimately burns down during the final confrontation.', 'https://www.slashfilm.com/img/gallery/stranger-things-starcourt-mall-exists-in-real-life-but-its-not-in-hawkins/l-intro-1657566265.jpg', 'https://maps.app.goo.gl/example');
('Byers House', 'Home of Joyce, Will, and Jonathan Byers.', 'https://www.hollywoodreporter.com/wp-content/uploads/2024/10/byers-house-stranger-things-airbnb-living-room-2-MAIN-2024-1.png', 'https://maps.app.goo.gl/EkiKFJH98F4tZymS7'),
('Starcourt Mall', 'A new shopping mall in Hawkins that plays a central role in Season 3.', 'https://media.cnn.com/api/v1/images/stellar/prod/191010131320-stranger-things-3-mall.jpg?q=x_33,y_106,h_1108,w_1970,c_crop/h_833,w_1480', 'https://maps.app.goo.gl/bw35VKjqhfp55ZVJ7'),
('Hawkins Town Square', 'The central area of Hawkins where community events take place.', 'https://videocdn.cdnpk.net/videos/b0ad6d08-b657-42c8-b2c5-78a72c5d5550/horizontal/thumbnails/large.jpg?item_id=368689&w=740&q=80', 'https://maps.app.goo.gl/G8m4itMLA7q2BHoD9');

-- Sample Quotes
INSERT INTO quotes (quote_text, description, character_id, episode_id) VALUES
('Friends don\'t lie.', 'Eleven\'s iconic phrase about trust and honesty.', 1, 1),
('Mornings are for coffee and contemplation.', 'Chief Hopper\'s philosophy on starting the day.', 7, 1),
('She\'s our friend and she\'s crazy!', 'Dustin defending Eleven to the group.', 3, 2),
('Bitchin\'', 'Max\'s favorite expression of approval.', 8, NULL);
