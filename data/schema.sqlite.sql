DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS guest;
DROP TABLE IF EXISTS menu;
DROP TABLE IF EXISTS reception;
DROP TABLE IF EXISTS wine;
DROP TABLE IF EXISTS gift;
DROP TABLE IF EXISTS user_basket;

CREATE TABLE user (
  user_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  passcode VARCHAR(10) NOT NULL DEFAULT '',
  lastlogin DATETIME NOT NULL,
  international INTEGER NOT NULL DEFAULT 0
);

CREATE UNIQUE INDEX "k_passcode" ON "user" (passcode);
CREATE INDEX "k_international" ON "user" (international);

CREATE TABLE admin (
  user_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT
);

CREATE TABLE guest (
  guest_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  forename VARCHAR(30) NOT NULL DEFAULT '',
  surname VARCHAR(30) NOT NULL DEFAULT '',
  user_id INTEGER NOT NULL,
  rsvp INTEGER NOT NULL DEFAULT 0,
  rsvp_time DATETIME DEFAULT '0000-00-00 00:00:00',
  menu_id INTEGER NOT NULL,
  diet VARCHAR(255) DEFAULT '',
  reception_id INTEGER NOT NULL,
  wine_id INTEGER NOT NULL
);

CREATE INDEX "k_user_id" ON "guest" (user_id);
CREATE INDEX "k_rsvp" ON "guest" (rsvp);

CREATE TABLE menu (
  menu_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(30) NOT NULL DEFAULT '',
  description VARCHAR(100) NOT NULL DEFAULT ''
);

INSERT INTO menu (name, description) VALUES 
	('Meat', 'Slow cooked blade of beef topped with homemade pate sat on a croute with a creamy brandy sauce');
INSERT INTO menu (name, description) VALUES 
  ('Fish', 'Fillet of salmon with a lemon &amp; herb crust, champagne butter sauce and seasonal vegetables');
INSERT INTO menu (name, description) VALUES 
  ('Vegetarian', 'Saute vegetable wellington with a basil sauce');

CREATE TABLE reception (
  reception_drink_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  description VARCHAR(25) NOT NULL DEFAULT ''
);

CREATE TABLE wine (
  wine_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  description VARCHAR(25) NOT NULL DEFAULT ''
);

CREATE TABLE gift (
	gift_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	name VARCHAR(45) NOT NULL DEFAULT '',
	description VARCHAR(150) NOT NULL DEFAULT '',
	price INTEGER NOT NULL DEFAULT 0,
	requested INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE user_basket (
	user_id INTEGER NOT NULL,
	gift_id INTEGER NOT NULL,
	quantity INTEGER NOT NULL DEFAULT 1
);

CREATE UNIQUE INDEX "k_user_gift" ON "user_basket" (user_id, gift_id);
