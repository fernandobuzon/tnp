
CREATE TABLE bands (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	login TEXT NOT NULL,
	passwd TEXT NOT NULL,
	name TEXT NOT NULL,
	contact TEXT NOT NULL,
	city TEXT NOT NULL,
	email TEXT,
	cel TEXT,
	obs TEXT
);

CREATE TABLE events (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	band_id INT UNSIGNED,
	name TEXT,
	date DATE,
	start TEXT,
	city TEXT,
	address TEXT,
	state TEXT,
	ticket FLOAT,
	obs TEXT,
	flyer TEXT
);
ALTER TABLE `events` ADD CONSTRAINT `fk_events_band` FOREIGN KEY ( `band_id` ) REFERENCES `bands` ( `id` );

CREATE TABLE members (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	band_id INT UNSIGNED,
	event_id INT UNSIGNED,
	message TEXT,
	reply TEXT,
	state TEXT
);
ALTER TABLE `members` ADD CONSTRAINT `fk_members_band` FOREIGN KEY ( `band_id` ) REFERENCES `bands` ( `id` );
ALTER TABLE `members` ADD CONSTRAINT `fk_members_event` FOREIGN KEY ( `event_id` ) REFERENCES `events` ( `id` );

CREATE TABLE messages (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	band_id INT UNSIGNED,
	event_id INT UNSIGNED,
	message TEXT NOT NULL,
	date DATE
);
ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_band` FOREIGN KEY ( `band_id` ) REFERENCES `bands` ( `id` );
ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_event` FOREIGN KEY ( `event_id` ) REFERENCES `events` ( `id` );
