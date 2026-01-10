-- Stranger Things Wikipedia Database (Updated Users Table)

CREATE DATABASE IF NOT EXISTS stranger_things_wiki;
USE stranger_things_wiki;

-- ======================================
-- Characters Table
-- ======================================
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

-- ======================================
-- Episodes Table
-- ======================================
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

-- ======================================
-- Locations Table
-- ======================================
CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    maps_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ======================================
-- Quotes Table
-- ======================================
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

-- ======================================
-- Users Table (Security fields removed)
-- ======================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ======================================
-- Sample Characters (Detailed Descriptions)
-- ======================================
INSERT INTO characters (name, actor_name, description, image_url, youtube_clip_url, age, born_date, height) VALUES
('Eleven', 'Millie Bobby Brown', 'Eleven is a young girl with extraordinary psychokinetic and telepathic abilities who escaped from the secretive Hawkins National Laboratory. Having endured years of experimentation, she developed formidable powers including telekinesis, remote viewing, and the ability to travel between dimensions. Despite her traumatic upbringing and limited social experience, Eleven forms deep bonds with Mike Wheeler and his friends, becoming the moral compass and protector of the group. Her journey is one of discovery, friendship, and resilience, as she learns about family, loyalty, and her own humanity.', 'https://media.vanityfair.com/photos/59f370dd16ff751cf425ef46/master/pass/wv_publicity_pre_launch_A_still_23.jpg', 'https://www.youtube.com/watch?v=b9EkMc79ZSU', 15, '2001-01-15', '5''4"'),

('Mike Wheeler', 'Finn Wolfhard', 'Mike is the natural leader of his friend group in Hawkins, Indiana. Intelligent, strategic, and compassionate, he navigates the challenges of adolescence while confronting supernatural threats. He forms a strong bond with Eleven and develops a deep romantic connection, demonstrating courage and loyalty even in the face of life-threatening dangers. Mike is consistently the anchor of his friends, offering moral support, quick thinking, and an unwavering commitment to protect those he loves. His leadership and bravery play a central role in the group''s survival against the forces from the Upside Down.', 'https://cdn.costumewall.com/wp-content/uploads/2019/07/mike-wheeler.jpg', 'https://www.youtube.com/watch?v=XWxyRG_tckY', 15, '2000-12-09', '5''11"'),

('Dustin Henderson', 'Gaten Matarazzo', 'Dustin is an intellectually curious and optimistic member of the group, known for his scientific aptitude and resourcefulness. Born with cleidocranial dysplasia, he faces physical challenges with humor and courage. Dustin is endlessly loyal, often serving as the heart of the group, offering comic relief while also providing critical insights into the supernatural events in Hawkins. His infectious enthusiasm, empathy, and creativity allow him to form bonds with humans and creatures alike, making him an essential and beloved member of the team.', 'https://strangerthingsttu.weebly.com/uploads/1/1/4/5/114552629/dustin-2_orig.jpg', 'https://www.youtube.com/watch?v=cZHU7rUFOLQ', 14, '2001-03-22', '5''8"'),

('Lucas Sinclair', 'Caleb McLaughlin', 'Lucas is a pragmatic and skeptical member of the group who brings a sense of realism and level-headedness. Athletic, brave, and morally grounded, he is often cautious and initially hesitant to trust new people, especially Eleven. Over time, Lucas shows remarkable loyalty, courage, and resourcefulness, often using his intellect and physical skills to protect his friends. His growing relationship with Max highlights his caring nature, while his quick thinking and adaptability help the group navigate dangers from both the human world and the Upside Down.', 'https://i.redd.it/3wfhbq7fjnva1.jpg', 'https://www.youtube.com/watch?v=qd8K84jAEg8', 15, '2000-10-15', '5''9"'),

('Will Byers', 'Noah Schnapp', 'Will is a sensitive, artistic, and introspective boy whose disappearance in the first season triggers the central events of the story. His experiences in the Upside Down leave him with lingering connections to the dark dimension and its terrifying entities, such as the Mind Flayer. Will struggles with trauma, isolation, and possession, yet demonstrates resilience and courage as he attempts to return to a normal life. His empathetic and creative nature adds emotional depth to the series, influencing his friends and family as they face increasingly dangerous threats.', 'https://www.usmagazine.com/wp-content/uploads/2022/05/Everything-the-Stranger-Things-Cast-Has-Said-About-Will-Byers-Exploring-His-Identity-Over-the-Years7.jpg', 'https://www.youtube.com/watch?v=4n0R4EmxX28', 15, '2000-11-30', '5''7"'),

('Joyce Byers', 'Winona Ryder', 'Joyce is a determined and fiercely protective mother who refuses to accept her son Will''s disappearance as final. Working multiple jobs to support her family, Joyce exhibits extraordinary courage and intuition, going to great lengths to uncover hidden truths about Hawkins and the mysterious Upside Down. Her resourcefulness, maternal instincts, and relentless pursuit of answers make her a cornerstone of the narrative, often risking her safety to protect and save her children and friends. Her character embodies love, resilience, and unyielding determination.', 'https://hips.hearstapps.com/hmg-prod/images/stranger-things-season-3-joyce-byers-uhdpaper-com-8k-13-1563466975.jpg', 'https://www.youtube.com/watch?v=yQbUJQr83yE', 42, '1973-05-10', '5''6"'),

('Jim Hopper', 'David Harbour', 'Hopper is the gruff and world-weary chief of police in Hawkins, carrying the weight of past traumas including the loss of his daughter and a failed marriage. Initially cynical and struggling with personal demons, he evolves into a heroic father figure for Eleven and a protector of the town. Hopper''s investigative skills, courage, and ability to make tough decisions in life-threatening situations are vital to confronting the supernatural occurrences in Hawkins. His journey reflects redemption, sacrifice, and the complexities of love and duty.', 'https://hips.hearstapps.com/hmg-prod/images/h5-promo-stills-022519-0053-ra-1562776884.jpg', 'https://www.youtube.com/watch?v=6qh2xmSdUZA', 48, '1967-08-20', '6''2"'),

('Max Mayfield', 'Sadie Sink', 'Max is a tough, independent skateboarder who moves to Hawkins from California. Initially guarded due to past trauma and an abusive stepfamily, she quickly proves her bravery, resourcefulness, and loyalty. Her skills in gaming and skateboarding earn her the nickname "MADMAX," and she develops a meaningful romantic relationship with Lucas. Max balances her adventurous spirit with vulnerability, and her character adds depth to the group dynamic, representing resilience, courage, and friendship in the face of danger.', 'https://strangerthingsttu.weebly.com/uploads/1/1/4/5/114552629/max-1_1_orig.jpg', 'https://www.youtube.com/watch?v=cvrr83sN1lY', 14, '2001-06-12', '5''5"');

-- ======================================
-- Sample Episodes (Detailed Descriptions)
-- ======================================
INSERT INTO episodes (title, season, episode_number, description, image_url, youtube_clip_url, air_date) VALUES
('The Vanishing of Will Byers', 1, 1, 'On his way home after playing Dungeons & Dragons, young Will Byers encounters a terrifying creature in the woods and disappears. His mysterious disappearance triggers a frantic search by his mother, friends, and the police. Meanwhile, a mysterious girl with supernatural powers, later known as Eleven, escapes from Hawkins Laboratory. This episode establishes the series'' central mystery, introduces the town''s secretive government experiments, and sets the stage for the confrontation between the human world and the Upside Down.', 'https://images.squarespace-cdn.com/content/v1/56cdc4478259b5c112bb2285/1470027914188-9CGT2KIEQV010892VYXZ/image-asset.jpeg', 'https://www.youtube.com/watch?v=wYn1uoN2WYc', '2016-07-15'),

('The Weirdo on Maple Street', 1, 2, 'Lucas, Mike, and Dustin encounter Eleven and discover her mysterious powers. They nickname her based on the tattoo on her wrist and begin hiding her in Mike''s basement. Joyce Byers becomes increasingly convinced that Will is alive, communicating through Christmas lights. Meanwhile, Chief Hopper investigates Hawkins Laboratory''s suspicious activities, uncovering hints of a larger conspiracy. This episode deepens the relationships between the children, reveals the existence of supernatural phenomena, and sets up future conflicts.', 'https://static.tvtropes.org/pmwiki/pub/images/the_weirdo_on_maple_street_5.jpg', 'https://www.youtube.com/watch?v=kcOufcPvAAo', '2016-07-15'),

('Holly, Jolly', 1, 3, 'Nancy investigates the disappearance of her friend Barb and teams up with Jonathan Byers to uncover evidence of a supernatural creature. Joyce becomes increasingly determined to communicate with Will through Christmas lights, displaying her unrelenting maternal devotion. The episode explores themes of fear, friendship, and courage, while heightening tension with the introduction of the Upside Down and its ominous influence on Hawkins.', 'https://i.redd.it/en52kuw8e9xf1.jpeg', 'https://www.youtube.com/watch?v=dP94UctPJPY', '2016-07-15'),

('The Body', 1, 4, 'Joyce refuses to accept Will''s apparent death, convinced he is trying to reach her. Hopper discovers the cover-up involving Will''s body, leading them to collaborate in uncovering the truth. Meanwhile, the boys, aided by Eleven, attempt to boost a radio signal to contact Will in the Upside Down. This episode emphasizes themes of maternal love, courage, and friendship, while escalating the tension between the normal world and the dark alternate dimension.', 'https://m.media-amazon.com/images/M/MV5BMjI2MTc2MzEwNF5BMl5BanBnXkFtZTgwNzc0ODE0OTE@._V1_.jpg', 'https://www.youtube.com/watch?v=ldvNUqrKJec', '2016-07-15'),

('MADMAX', 2, 1, 'A year after Will''s return, Hawkins prepares for Halloween. A new gaming prodigy, Max Mayfield, challenges the boys'' high score records at the arcade. Will experiences disturbing visions of the Upside Down, while Joyce and Hopper investigate his episodes. This episode introduces Max, deepens the interpersonal relationships among the main characters, and highlights the growing influence of supernatural forces that continue to threaten Hawkins.', 'https://m.media-amazon.com/images/M/MV5BZjczYmY5MzktMmFmYi00YzExLTlmYzEtZGM2YzAxMDQ4OGE0XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/watch?v=-stxa3WndBY', '2017-10-27');

-- ======================================
-- Sample Locations (Detailed Descriptions)
-- ======================================
INSERT INTO locations (name, description, image_url, maps_url) VALUES
('Hawkins Laboratory', 'A secret government research facility on the outskirts of Hawkins, Indiana, operated by the Department of Energy. The lab conducts experiments on individuals with psychic abilities, including Eleven, under the guise of energy research. Its unethical experiments inadvertently open a gateway to the Upside Down, causing supernatural phenomena and threatening the town. The lab is heavily guarded and a focal point for government secrecy and sinister activities.', 'https://ew.com/thmb/Xb5vf5l6klpxBfAJTFEFkQ8goFM=/2000x0/filters:no_upscale():max_bytes(150000):strip_icc()/hawkins_lab-stranger-things-050324-c6b1f49927da42208725a8f9ceb69ac3.jpg', 'https://maps.app.goo.gl/b8hmEsuFHevMDEwb7'),

('The Upside Down', 'A dark, cold, and highly dangerous parallel dimension that mirrors Hawkins in a decayed, toxic, and predatory form. It is inhabited by terrifying creatures, including Demogorgons and the Mind Flayer, and is governed by altered physics and frozen time. Individuals trapped here face near-certain death without rescue, making it a constant threat to anyone who encounters the gateway. The Upside Down embodies the consequences of Hawkins Laboratory''s experiments and serves as the primary supernatural threat in the series.', 'https://static0.srcdn.com/wordpress/wp-content/uploads/2019/06/Stranger-Things-Demogorgon-and-Mind-Flayer.jpg?w=1200&h=675&fit=crop', NULL),

('Hawkins Middle School', 'The local school attended by Mike, Dustin, Lucas, Will, Eleven, and Max. The school is central to the children''s social interactions, hosting the AV Club and various community events. It is where they plan their adventures, conduct experiments, and navigate friendships, romances, and conflicts, while often being unaware of the darker forces affecting their town.', 'https://preview.redd.it/7y5ofu2rxq931.jpg?width=640&crop=smart&auto=webp&s=21ea4ede453583982479ac300524eecf37647c7b', 'https://maps.app.goo.gl/wC9ZJHBbgsRw1DVEA'),

('Starcourt Mall', 'A shopping mall opened in Hawkins in 1985, representing consumer culture and leisure activities of the era. Beneath the mall lies a hidden Soviet operation attempting to reopen the gate to the Upside Down. Starcourt Mall serves as a major narrative setting in Season 3, combining normal teenage life, work environments, and epic supernatural confrontations.', 'https://www.slashfilm.com/img/gallery/stranger-things-starcourt-mall-exists-in-real-life-but-its-not-in-hawkins/l-intro-1657566265.jpg', 'https://maps.app.goo.gl/example'),

('Byers House', 'The home of Joyce, Will, and Jonathan Byers. It functions as a central hub for the characters, filled with domestic warmth and emotional tension. Joyce''s inventive methods of communicating with Will, including Christmas lights, illustrate her determination and creativity in confronting supernatural events.', 'https://www.hollywoodreporter.com/wp-content/uploads/2024/10/byers-house-stranger-things-airbnb-living-room-2-MAIN-2024-1.png', 'https://maps.app.goo.gl/EkiKFJH98F4tZymS7'),

('Hawkins Town Square', 'The central gathering place for Hawkins residents, hosting community events, parades, and public celebrations. The town square is a backdrop for both ordinary town life and the unusual events connected to the Upside Down, blending normalcy with mystery and suspense.', 'https://videocdn.cdnpk.net/videos/b0ad6d08-b657-42c8-b2c5-78a72c5d5550/horizontal/thumbnails/large.jpg?item_id=368689&w=740&q=80', 'https://maps.app.goo.gl/G8m4itMLA7q2BHoD9');

-- ======================================
-- Sample Quotes (Unchanged)
-- ======================================
INSERT INTO quotes (quote_text, description, character_id, episode_id) VALUES
('Friends don''t lie.', 'Eleven''s iconic line.', 1, 1),
('Mornings are for coffee and contemplation.', 'Hopper''s morning philosophy.', 7, 1),
('She''s our friend and she''s crazy!', 'Dustin defending Eleven.', 3, 2),
('Will is not gone!', 'Joyce refusing to accept Will''s death.', 6, 4),
('The Demogorgon! It got me!', 'Dustin during a D&D campaign.', 3, 1),
('It''s the Upside Down.', 'Eleven explaining the alternate dimension.', 1, 4);