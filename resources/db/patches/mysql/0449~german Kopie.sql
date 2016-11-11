# Add new categories to Movies and TV

INSERT IGNORE INTO categories (id, title, parentid) VALUES (2100, 'Movies EN', NULL);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (2130, 'SD', 2100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (2140, 'HD', 2100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (2145, 'UHD', 2100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (2150, '3D', 2100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (2160, 'Bluray', 2100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (2170, 'DVD', 2100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (2180, 'WEBDL', 2100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5100, 'TV EN', NULL);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5110, 'WEB-DL', 5100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5130, 'SD', 5100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5140, 'HD', 5100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5145, 'UHD', 5100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5150, '3D', 5100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5160, 'Sport', 5100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5170, 'Anime', 5100);
INSERT IGNORE INTO categories (id, title, parentid) VALUES (5180, 'Documentary', 5100);
UPDATE categories SET title = "Movies DE" WHERE id = 2000;
UPDATE categories SET title = "TV DE" WHERE id = 5000;

# Add new field to users table
ALTER TABLE users ADD COLUMN appendpassword BOOLEAN;
ALTER TABLE releases ADD COLUMN password VARCHAR(255);
