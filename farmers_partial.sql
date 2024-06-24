-- Partial CREATE TABLE statements, due to space quota restrictions

DROP TABLE grows_crop_type
DROP TABLE owns
DROP TABLE farmer
DROP TABLE farm
DROP TABLE farmAddress
DROP TABLE farmProvince


CREATE TABLE farmProvince(
	province CHAR(2),
	postal_code CHAR(7),
	PRIMARY KEY (postal_code))

CREATE TABLE farmAddress(
	address VARCHAR(30), 
	postal_code CHAR(7) NOT NULL, 
	PRIMARY KEY (address), 
	FOREIGN KEY (postal_code) REFERENCES farmProvince(postal_code))

CREATE TABLE farm(
	fid VARCHAR(20), 
	address VARCHAR(30) NOT NULL, 
	PRIMARY KEY (fid), 
	FOREIGN KEY (address) REFERENCES farmAddress(address))

CREATE TABLE farmer(
	sin CHAR(9),
	name VARCHAR(20),
	phone INTEGER,
	age INTEGER,
	address VARCHAR(30),
	PRIMARY KEY (sin))

CREATE TABLE owns(
	fid VARCHAR(20) NOT NULL,
	sin CHAR(9) NOT NULL,
	PRIMARY KEY (fid, sin),
	FOREIGN KEY (fid) REFERENCES farm ON DELETE CASCADE,
	FOREIGN KEY (sin) REFERENCES farmer ON DELETE CASCADE)

CREATE TABLE grows_crop_type (
	price REAL,
	type VARCHAR(20),
	PRIMARY KEY (type, price)
)

INSERT INTO farmProvince (province, postal_code) VALUES ('ON', 'M5V 2T6')
INSERT INTO farmProvince (province, postal_code) VALUES ('QC', 'H2X 1Y4')
INSERT INTO farmProvince (province, postal_code) VALUES ('SK', 'S4P 3Y2')
INSERT INTO farmProvince (province, postal_code) VALUES ('NS', 'B3H 1W5')
INSERT INTO farmProvince (province, postal_code) VALUES ('PE', 'C1A 9L9')

INSERT INTO farmAddress (address, postal_code) VALUES ('345 Dairy Lane', 'M5V 2T6')
INSERT INTO farmAddress (address, postal_code) VALUES ('678 Barnyard Road', 'H2X 1Y4')
INSERT INTO farmAddress (address, postal_code) VALUES ('910 Poultry Place', 'S4P 3Y2')
INSERT INTO farmAddress (address, postal_code) VALUES ('111 Orchard Street', 'B3H 1W5')
INSERT INTO farmAddress (address, postal_code) VALUES ('222 Greenhouse Avenue', 'C1A 9L9')

INSERT INTO farm (fid, address) VALUES ('F006', '345 Dairy Lane')
INSERT INTO farm (fid, address) VALUES ('F007', '678 Barnyard Road')
INSERT INTO farm (fid, address) VALUES ('F008', '910 Poultry Place')
INSERT INTO farm (fid, address) VALUES ('F009', '111 Orchard Street')
INSERT INTO farm (fid, address) VALUES ('F010', '222 Greenhouse Avenue')

INSERT INTO farmer (sin, name, phone, age, address) VALUES ('123456789', 'John Doe', 1234567890, 35, '345 Dairy Lane')
INSERT INTO farmer (sin, name, phone, age, address) VALUES ('234567890', 'Jane Smith', 2345678901, 42, '678 Barnyard Road')
INSERT INTO farmer (sin, name, phone, age, address) VALUES ('345678901', 'Alice Johnson', 3456789012, 28, '910 Poultry Place')
INSERT INTO farmer (sin, name, phone, age, address) VALUES ('456789012', 'Bob Brown', 4567890123, 55, '111 Orchard Street')
INSERT INTO farmer (sin, name, phone, age, address) VALUES ('567890123', 'Eve Wilson', 5678901234, 48, '222 Greenhouse Avenue')

INSERT INTO owns (fid, sin) VALUES ('F006', '123456789')
INSERT INTO owns (fid, sin) VALUES ('F007', '234567890')
INSERT INTO owns (fid, sin) VALUES ('F008', '345678901')
INSERT INTO owns (fid, sin) VALUES ('F009', '456789012')
INSERT INTO owns (fid, sin) VALUES ('F010', '567890123')
INSERT INTO owns (fid, sin) VALUES ('F006', '234567890')
INSERT INTO owns (fid, sin) VALUES ('F006', '345678901')
INSERT INTO owns (fid, sin) VALUES ('F006', '456789012')
INSERT INTO owns (fid, sin) VALUES ('F006', '567890123')

INSERT INTO grows_crop_type (price, type) VALUES (10.00, 'Corn')
INSERT INTO grows_crop_type (price, type) VALUES (30.00, 'Corn')
INSERT INTO grows_crop_type (price, type) VALUES (20.00, 'Tomato')
INSERT INTO grows_crop_type (price, type) VALUES (50.00, 'Tomato')
INSERT INTO grows_crop_type (price, type) VALUES (30.00, 'Potato')
INSERT INTO grows_crop_type (price, type) VALUES (40.00, 'Carrot')
INSERT INTO grows_crop_type (price, type) VALUES (50.00, 'Lettuce')
INSERT INTO grows_crop_type (price, type) VALUES (90.00, 'Lettuce')