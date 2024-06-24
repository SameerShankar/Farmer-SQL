-- Complete CREATE TABLE statements, assuming no space quota restrictions

DROP TABLE Regulates
DROP TABLE Distributes
DROP TABLE Grocery
DROP TABLE GroceryLocation
DROP TABLE Agency
DROP TABLE AgencyLocation
DROP TABLE works_on
DROP TABLE works_on_num_h_ec
DROP TABLE works_on_num_h_fc
DROP TABLE machine
DROP TABLE machine_yos
DROP TABLE machine_type
DROP TABLE trades_with
DROP TABLE trades_with_sale_date
DROP TABLE trades_with_quantity
DROP TABLE personal_farmer
DROP TABLE personal_farmer_family_size_qs
DROP TABLE personal_farmer_family_size_sc
DROP TABLE sells_to
DROP TABLE sells_to_sale_date
DROP TABLE sells_to_sale_quantity
DROP TABLE grows_crop
DROP TABLE grows_crop_time
DROP TABLE grows_crop_type
DROP TABLE has_plots
DROP TABLE has_plots_type
DROP TABLE has_plots_location
DROP TABLE Wholesale
DROP TABLE WholesaleLocation
DROP TABLE commercial_farmer
DROP TABLE commercial_farmer_a
DROP TABLE commercial_farmer_nc
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

CREATE TABLE commercial_farmer_nc (
	name VARCHAR(20),
	phone INTEGER,
	company VARCHAR(20),
	PRIMARY KEY (name, company))

CREATE TABLE commercial_farmer_a (
	address VARCHAR(30),
	company VARCHAR(20) NOT NULL,
	PRIMARY KEY (address),
	FOREIGN KEY (company) REFERENCES commercial_farmer_nc(company))

CREATE TABLE commercial_farmer (
	sin CHAR(9) NOT NULL,
	name VARCHAR(20) NOT NULL,
	age INTEGER,
	address VARCHAR(30) NOT NULL,
	PRIMARY KEY (sin),
	FOREIGN KEY (sin) REFERENCES farmer ON DELETE CASCADE,
	FOREIGN KEY (name) REFERENCES commercial_farmer_nc(name),
	FOREIGN KEY (address) REFERENCES commercial_farmer_a(address))

CREATE TABLE WholesaleLocation (
	province CHAR(2),
	postal_code CHAR(7),
	PRIMARY KEY (postal_code)
)

CREATE TABLE Wholesale (
	wid VARCHAR(20),
	address VARCHAR(30),
	name VARCHAR(20),
	postal_code CHAR(7) NOT NULL,
	PRIMARY KEY (wid),
	FOREIGN KEY (postal_code) REFERENCES WholesaleLocation)

CREATE TABLE has_plots_location (
	size VARCHAR(20),
	price REAL,
	location VARCHAR(20),
	PRIMARY KEY (location)
)

CREATE TABLE has_plots_type (
	plot_type VARCHAR(20),
	location VARCHAR(20) NOT NULL,
	PRIMARY KEY (plot_type),
	FOREIGN KEY (location) REFERENCES has_plots_location)

CREATE TABLE has_plots (
	pid VARCHAR(20),
	fid VARCHAR(20) NOT NULL,
	plot_type VARCHAR(20) NOT NULL,
	PRIMARY KEY (pid, fid),
	FOREIGN KEY (fid) REFERENCES farm ON DELETE CASCADE,
	FOREIGN KEY (plot_type) REFERENCES has_plots_type
)

CREATE TABLE grows_crop_type (
	price REAL,
	type VARCHAR(20),
	PRIMARY KEY (type, price)
)

CREATE TABLE grows_crop_time (
	price REAL,
	time_to_yield REAL,
	PRIMARY KEY (time_to_yield)
)

CREATE TABLE grows_crop (
	cid VARCHAR(20),
	name VARCHAR(20),
	type VARCHAR(20) NOT NULL,
	time_to_yield REAL NOT NULL,
	pid VARCHAR(20) NOT NULL,
	fid VARCHAR(20) NOT NULL,
	PRIMARY KEY (cid),
	FOREIGN KEY (pid, fid) REFERENCES has_plots ON DELETE CASCADE,
	FOREIGN KEY (type) REFERENCES grows_crop_type,
	FOREIGN KEY (time_to_yield) REFERENCES grows_crop_time
)

CREATE TABLE sells_to_sale_quantity (
	quantity INTEGER,
	sale_price REAL,
	PRIMARY KEY (quantity)
)

CREATE TABLE sells_to_sale_date (
	sale_date DATE,
	quantity INTEGER NOT NULL,
	PRIMARY KEY (sale_date),
	FOREIGN KEY (quantity) REFERENCES sells_to_sale_quantity
)

CREATE TABLE sells_to (
	sale_date DATE NOT NULL,
	wid VARCHAR(20) NOT NULL,
	sin CHAR(9) NOT NULL,
	cid VARCHAR(20) NOT NULL,
	PRIMARY KEY (wid, sin, cid),
	FOREIGN KEY (wid) REFERENCES Wholesale ON DELETE CASCADE,
	FOREIGN KEY (sin) REFERENCES farmer ON DELETE CASCADE,
	FOREIGN KEY (cid) REFERENCES grows_crop ON DELETE CASCADE,
	FOREIGN KEY (sale_date) REFERENCES sells_to_sale_date
)

CREATE TABLE personal_farmer_family_size_sc (
	family_size INTEGER,
	self_consumption INTEGER,
	PRIMARY KEY (family_size)
)

CREATE TABLE personal_farmer_family_size_qs (
	family_size INTEGER,
	quantity_sold INTEGER,
	PRIMARY KEY (family_size)
)

CREATE TABLE personal_farmer (
	sin CHAR(9) NOT NULL,
	name VARCHAR(20),
	phone INTEGER,
	age INTEGER,
	address VARCHAR(30),
	family_size INTEGER NOT NULL,
	PRIMARY KEY (sin),
	FOREIGN KEY (sin) REFERENCES farmer ON DELETE CASCADE,
	FOREIGN KEY (family_size) REFERENCES personal_farmer_family_size_sc,
	FOREIGN KEY (family_size) REFERENCES personal_farmer_family_size_qs)

CREATE TABLE trades_with_quantity (
	quantity INTEGER,
	sale_price REAL,
	PRIMARY KEY (quantity)
)

CREATE TABLE trades_with_sale_date (
	sale_date DATE,
	quantity INTEGER NOT NULL,
	PRIMARY KEY (sale_date),
	FOREIGN KEY (quantity) REFERENCES trades_with_quantity
)

CREATE TABLE trades_with (
	sale_date DATE NOT NULL,
	cid VARCHAR(20) NOT NULL,
	farm_trader_A_SIN CHAR(9) NOT NULL,
	farm_trader_B_SIN CHAR(9) NOT NULL,
	PRIMARY KEY (cid, farm_trader_A_SIN, farm_trader_B_SIN),
	FOREIGN KEY (cid) REFERENCES grows_crop ON DELETE CASCADE,
	FOREIGN KEY (farm_trader_A_SIN) REFERENCES personal_farmer(sin) ON DELETE CASCADE,
	FOREIGN KEY (farm_trader_B_SIN) REFERENCES personal_farmer(sin) ON DELETE CASCADE
	FOREIGN KEY (sale_date) REFERENCES trades_with_sale_date
)

CREATE TABLE machine_type (
	type VARCHAR(20),
	price REAL,
	PRIMARY KEY (type)
)

CREATE TABLE machine_yos (
	years_of_service INTEGER,
	needs_repair BOOL,
	PRIMARY KEY (years_of_service)
)

CREATE TABLE machine (
	mid VARCHAR(20),
	type VARCHAR(20) NOT NULL,
	years_of_service INTEGER NOT NULL,
	PRIMARY KEY (mid),
	FOREIGN KEY (type) REFERENCES machine_type,
	FOREIGN KEY (years_of_service) REFERENCES machine_yos
)

CREATE TABLE works_on_num_h_fc (
	num_hours REAL,
	fuel_consumption REAL,
	PRIMARY KEY (num_hours))
	

CREATE TABLE works_on_num_h_ec (
	num_hours REAL,
	electricity_consumption REAL,
	PRIMARY KEY (num_hours)
)

CREATE TABLE works_on (
	mid VARCHAR(20) NOT NULL,
	pid VARCHAR(20) NOT NULL,
	fid VARCHAR(20) NOT NULL,
	num_hours REAL NOT NULL,
	PRIMARY KEY (mid, pid, fid),
	FOREIGN KEY (pid, fid) REFERENCES has_plots ON DELETE CASCADE,
	FOREIGN KEY (mid) REFERENCES machine ON DELETE CASCADE,
	FOREIGN KEY (num_hours) REFERENCES works_on_num_h_fc,
	FOREIGN KEY (num_hours) REFERENCES works_on_num_h_ec
)

CREATE TABLE AgencyLocation (
	name VARCHAR(20),
	province CHAR(2),
	director VARCHAR(20),
	PRIMARY KEY (name, province),
	UNIQUE (director, province)
)

CREATE TABLE Agency (
	aid VARCHAR(20),
	name VARCHAR(20) NOT NULL,
	province CHAR(2) NOT NULL,
	PRIMARY KEY (aid),
	FOREIGN KEY (name, province) REFERENCES AgencyLocation
)

CREATE TABLE Regulates (
	aid VARCHAR(20) NOT NULL,
	fid VARCHAR(20) NOT NULL,
	sin VARCHAR(20) NOT NULL,
	PRIMARY KEY (aid, sin, fid),
	FOREIGN KEY (aid) REFERENCES Agency ON DELETE CASCADE,
	FOREIGN KEY (sin) REFERENCES farmer ON DELETE CASCADE,
	FOREIGN KEY (fid) REFERENCES farm ON DELETE CASCADE
)

CREATE TABLE Distributes (
	wid VARCHAR(20) NOT NULL,
	gid VARCHAR(20) NOT NULL,
	PRIMARY KEY (wid, gid),
	FOREIGN KEY (wid) REFERENCES Wholesale ON DELETE CASCADE,
	FOREIGN KEY (gid) REFERENCES Grocery ON DELETE CASCADE
)

CREATE TABLE GroceryLocation (
	province CHAR(2),
	postal_code CHAR(7),
	PRIMARY KEY (postal_code)
)

CREATE TABLE Grocery (
	gid VARCHAR(20),
	address VARCHAR(30),
	name VARCHAR(20),
	postal_code CHAR(7) NOT NULL,
	PRIMARY KEY (gid),
	FOREIGN KEY (postal_code) REFERENCES GroceryLocation
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

INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Mark Johnson', 1112223333, 'FarmersCo')
INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Emily Davis', 4445556666, 'AgroTech')
INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Michael Wilson', 7778889999, 'GreenFields')
INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('Sarah Brown', 1011121314, 'NatureFresh')
INSERT INTO commercial_farmer_nc (name, phone, company) VALUES ('David Smith', 1516171819, 'BioFarms')

INSERT INTO commercial_farmer_a (address, company) VALUES ('345 Agro Way', 'FarmersCo')
INSERT INTO commercial_farmer_a (address, company) VALUES ('678 Tech Blvd', 'AgroTech')
INSERT INTO commercial_farmer_a (address, company) VALUES ('910 Green St', 'GreenFields')
INSERT INTO commercial_farmer_a (address, company) VALUES ('111 Nature Drive', 'NatureFresh')
INSERT INTO commercial_farmer_a (address, company) VALUES ('222 Bio Court', 'BioFarms')

INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('123456789', 'Mark Johnson', 35, '345 Agro Way')
INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('234567890', 'Emily Davis', 40, '678 Tech Blvd')
INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('345678901', 'Michael Wilson', 30, '910 Green St')
INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('456789012', 'Sarah Brown', 45, '111 Nature Drive')
INSERT INTO commercial_farmer (sin, name, age, address) VALUES ('567890123', 'David Smith', 50, '222 Bio Court')

INSERT INTO WholesaleLocation (province, postal_code) VALUES ('SK', 'S7K 3J8')
INSERT INTO WholesaleLocation (province, postal_code) VALUES ('NS', 'B3H 1W5')
INSERT INTO WholesaleLocation (province, postal_code) VALUES ('AB', 'T5J 2N3')
INSERT INTO WholesaleLocation (province, postal_code) VALUES ('QC', 'H2Y 1L6')
INSERT INTO WholesaleLocation (province, postal_code) VALUES ('ON', 'M5V 2T6')

INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W001', '345 Distribution St', 'FoodMart', 'S7K 3J8')
INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W002', '678 Wholesome Rd', 'GroceryWorld', 'B3H 1W5')
INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W003', '910 Wholesale Ave', 'FreshFoods', 'T5J 2N3')
INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W004', '111 Bulk St', 'FarmersBazaar', 'H2Y 1L6')
INSERT INTO Wholesale (wid, address, name, postal_code) VALUES ('W005', '222 Bulk Warehouse', 'GreenGrocers', 'M5V 2T6')

INSERT INTO has_plots_location (size, price, location) VALUES ('Small', 1000.00, 'Plot_A')
INSERT INTO has_plots_location (size, price, location) VALUES ('Medium', 2000.00, 'Plot_B')
INSERT INTO has_plots_location (size, price, location) VALUES ('Large', 3000.00, 'Plot_C')
INSERT INTO has_plots_location (size, price, location) VALUES ('Extra Large', 4000.00, 'Plot_D')
INSERT INTO has_plots_location (size, price, location) VALUES ('Giant', 5000.00, 'Plot_E')

INSERT INTO has_plots_type (plot_type, location) VALUES ('Corn', 'Plot_A')
INSERT INTO has_plots_type (plot_type, location) VALUES ('Tomato', 'Plot_B')
INSERT INTO has_plots_type (plot_type, location) VALUES ('Potato', 'Plot_C')
INSERT INTO has_plots_type (plot_type, location) VALUES ('Carrot', 'Plot_D')
INSERT INTO has_plots_type (plot_type, location) VALUES ('Lettuce', 'Plot_E')

INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P001', 'F006', 'Corn')
INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P002', 'F007', 'Tomato')
INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P003', 'F008', 'Potato')
INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P004', 'F009', 'Carrot')
INSERT INTO has_plots (pid, fid, plot_type) VALUES ('P005', 'F010', 'Lettuce')

INSERT INTO grows_crop_type (price, type) VALUES (10.00, 'Corn')
INSERT INTO grows_crop_type (price, type) VALUES (30.00, 'Corn')
INSERT INTO grows_crop_type (price, type) VALUES (20.00, 'Tomato')
INSERT INTO grows_crop_type (price, type) VALUES (50.00, 'Tomato')
INSERT INTO grows_crop_type (price, type) VALUES (30.00, 'Potato')
INSERT INTO grows_crop_type (price, type) VALUES (40.00, 'Carrot')
INSERT INTO grows_crop_type (price, type) VALUES (50.00, 'Lettuce')
INSERT INTO grows_crop_type (price, type) VALUES (90.00, 'Lettuce')

INSERT INTO grows_crop_time (price, time_to_yield) VALUES (10.00, 90.0)
INSERT INTO grows_crop_time (price, time_to_yield) VALUES (20.00, 120.0)
INSERT INTO grows_crop_time (price, time_to_yield) VALUES (30.00, 150.0)
INSERT INTO grows_crop_time (price, time_to_yield) VALUES (40.00, 180.0)
INSERT INTO grows_crop_time (price, time_to_yield) VALUES (50.00, 210.0)

INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C001', 'Cornfield', 'Corn', 90.0, 'P001', 'F006')
INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C002', 'Tomatoland', 'Tomato', 120.0, 'P002', 'F007')
INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C003', 'Potato Patch', 'Potato', 150.0, 'P003', 'F008')
INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C004', 'Carrot Corner', 'Carrot', 180.0, 'P004', 'F009')
INSERT INTO grows_crop (cid, name, type, time_to_yield, pid, fid) VALUES ('C005', 'Lettuce Lane', 'Lettuce', 210.0, 'P005', 'F010')

INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (100, 1000.00)
INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (200, 2000.00)
INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (300, 3000.00)
INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (400, 4000.00)
INSERT INTO sells_to_sale_quantity (quantity, sale_price) VALUES (500, 5000.00)

INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-01', 100)
INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-02', 200)
INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-03', 300)
INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-04', 400)
INSERT INTO sells_to_sale_date (sale_date, quantity) VALUES ('2024-04-05', 500)

INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-01', 'W001', '123456789', 'C001')
INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-02', 'W002', '234567890', 'C002')
INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-03', 'W003', '345678901', 'C003')
INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-04', 'W004', '456789012', 'C004')
INSERT INTO sells_to (sale_date, wid, sin, cid) VALUES ('2024-04-05', 'W005', '567890123', 'C005')

INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (1, 50)
INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (2, 100)
INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (3, 150)
INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (4, 200)
INSERT INTO personal_farmer_family_size_sc (family_size, self_consumption) VALUES (5, 250)

INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (1, 25)
INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (2, 50)
INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (3, 75)
INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (4, 100)
INSERT INTO personal_farmer_family_size_qs (family_size, quantity_sold) VALUES (5, 125)

INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('123456789', 'John Doe', 1234567890, 35, '345 Dairy Lane', 1)
INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('234567890', 'Jane Smith', 2345678901, 42, '678 Barnyard Road', 2)
INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('345678901', 'Alice Johnson', 3456789012, 28, '910 Poultry Place', 3)
INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('456789012', 'Bob Brown', 4567890123, 55, '111 Orchard Street', 4)
INSERT INTO personal_farmer (sin, name, phone, age, address, family_size) VALUES ('567890123', 'Eve Wilson', 5678901234, 48, '222 Greenhouse Avenue', 5)

INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (50, 500.00)
INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (100, 1000.00)
INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (150, 1500.00)
INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (200, 2000.00)
INSERT INTO trades_with_quantity (quantity, sale_price) VALUES (250, 2500.00)

INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-01', 50)
INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-02', 100)
INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-03', 150)
INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-04', 200)
INSERT INTO trades_with_sale_date (sale_date, quantity) VALUES ('2024-04-05', 250)

INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-01', 'C001', '123456789', '234567890')
INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-02', 'C002', '234567890', '345678901')
INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-03', 'C003', '345678901', '456789012')
INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-04', 'C004', '456789012', '567890123')
INSERT INTO trades_with (sale_date, cid, farm_trader_A_SIN, farm_trader_B_SIN) VALUES ('2024-04-05', 'C005', '567890123', '123456789')

INSERT INTO machine_type (type, price) VALUES ('Tractor', 10000.00)
INSERT INTO machine_type (type, price) VALUES ('Harvester', 20000.00)
INSERT INTO machine_type (type, price) VALUES ('Seeder', 30000.00)
INSERT INTO machine_type (type, price) VALUES ('Plough', 40000.00)
INSERT INTO machine_type (type, price) VALUES ('Sprayer', 50000.00)

INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (1, FALSE)
INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (2, FALSE)
INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (3, TRUE)
INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (4, TRUE)
INSERT INTO machine_yos (years_of_service, needs_repair) VALUES (5, TRUE)

INSERT INTO machine (mid, type, years_of_service) VALUES ('M001', 'Tractor', 1)
INSERT INTO machine (mid, type, years_of_service) VALUES ('M002', 'Harvester', 2)
INSERT INTO machine (mid, type, years_of_service) VALUES ('M003', 'Seeder', 3)
INSERT INTO machine (mid, type, years_of_service) VALUES ('M004', 'Plough', 4)
INSERT INTO machine (mid, type, years_of_service) VALUES ('M005', 'Sprayer', 5)

INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (1.0, 10.00)
INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (2.0, 20.00)
INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (3.0, 30.00)
INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (4.0, 40.00)
INSERT INTO works_on_num_h_fc (num_hours, fuel_consumption) VALUES (5.0, 50.00)

INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (1.0, 100.00)
INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (2.0, 200.00)
INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (3.0, 300.00)
INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (4.0, 400.00)
INSERT INTO works_on_num_h_ec (num_hours, electricity_consumption) VALUES (5.0, 500.00)

INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M001', 'P001', 'F006', 1.0)
INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M002', 'P002', 'F007', 2.0)
INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M003', 'P003', 'F008', 3.0)
INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M004', 'P004', 'F009', 4.0)
INSERT INTO works_on (mid, pid, fid, num_hours) VALUES ('M005', 'P005', 'F010', 5.0)

INSERT INTO AgencyLocation (name, province, director) VALUES ('AgroCare', 'ON', 'John Smith')
INSERT INTO AgencyLocation (name, province, director) VALUES ('FarmSolutions', 'AB', 'Jane Doe')
INSERT INTO AgencyLocation (name, province, director) VALUES ('GrowersHub', 'BC', 'Alice Johnson')
INSERT INTO AgencyLocation (name, province, director) VALUES ('AgriTech', 'QC', 'Bob Brown')
INSERT INTO AgencyLocation (name, province, director) VALUES ('HarvestFirst', 'NS', 'Eve Wilson')

INSERT INTO Agency (aid, name, province) VALUES ('A001', 'AgroCare', 'ON')
INSERT INTO Agency (aid, name, province) VALUES ('A002', 'FarmSolutions', 'AB')
INSERT INTO Agency (aid, name, province) VALUES ('A003', 'GrowersHub', 'BC')
INSERT INTO Agency (aid, name, province) VALUES ('A004', 'AgriTech', 'QC')
INSERT INTO Agency (aid, name, province) VALUES ('A005', 'HarvestFirst', 'NS')

INSERT INTO Regulates (aid, fid, sin) VALUES ('A001', 'F001', '123456789')
INSERT INTO Regulates (aid, fid, sin) VALUES ('A002', 'F002', '234567890')
INSERT INTO Regulates (aid, fid, sin) VALUES ('A003', 'F003', '345678901')
INSERT INTO Regulates (aid, fid, sin) VALUES ('A004', 'F004', '456789012')
INSERT INTO Regulates (aid, fid, sin) VALUES ('A005', 'F005', '567890123')

INSERT INTO Distributes (wid, gid) VALUES ('W001', 'G001')
INSERT INTO Distributes (wid, gid) VALUES ('W002', 'G002')
INSERT INTO Distributes (wid, gid) VALUES ('W003', 'G003')
INSERT INTO Distributes (wid, gid) VALUES ('W004', 'G004')
INSERT INTO Distributes (wid, gid) VALUES ('W005', 'G005')

INSERT INTO GroceryLocation (province, postal_code) VALUES ('ON', 'L1V 1N6')
INSERT INTO GroceryLocation (province, postal_code) VALUES ('AB', 'T2P 2G8')
INSERT INTO GroceryLocation (province, postal_code) VALUES ('BC', 'V6C 1S4')
INSERT INTO GroceryLocation (province, postal_code) VALUES ('QC', 'H2Y 1C6')
INSERT INTO GroceryLocation (province, postal_code) VALUES ('NS', 'B3J 3S9')

INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G001', '123 Market Street', 'FreshMart', 'L1V 1N6')
INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G002', '456 Farm Road', 'OrganicGrocer', 'T2P 2G8')
INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G003', '789 Orchard Avenue', 'HealthyHarvest', 'V6C 1S4')
INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G004', '101 Supermarket Lane', 'GreenGrocery', 'H2Y 1C6')
INSERT INTO Grocery (gid, address, name, postal_code) VALUES ('G005', '202 Fresh Plaza', "Nature'sBest", 'B3J 3S9')