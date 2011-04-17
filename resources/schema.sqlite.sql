CREATE TABLE account (
  account_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  passcode VARCHAR(10) NOT NULL DEFAULT '',
  lastlogin DATETIME NOT NULL
);

CREATE UNIQUE INDEX "k_passcode" ON "account" ("passcode");

CREATE TABLE guest (
  guest_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  forename VARCHAR(30) NOT NULL DEFAULT '',
  surname VARCHAR(30) NOT NULL DEFAULT '',
  account_id INTEGER NOT NULL,
  rsvp INTEGER NOT NULL DEFAULT 1,
  rsvp_time DATETIME NOT NULL,
  menu_id,
  reception_drink_id,
  wine_id
);

CREATE INDEX "k_account_id" ON "guest" ("account_id");

CREATE TABLE menu (
  menu_id,
  description
);

CREATE TABLE reception_drink (
  reception_drink_id,
  description
);

CREATE TABLE wine (
  wine_id,
  description
);
