-- 1. Disable Foreign Key Checks
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Clear All Tables (Use DELETE instead of TRUNCATE)
DELETE FROM Bookings;
ALTER TABLE Bookings AUTO_INCREMENT = 1;

DELETE FROM Passengers;
ALTER TABLE Passengers AUTO_INCREMENT = 1;

DELETE FROM Flights;
ALTER TABLE Flights AUTO_INCREMENT = 1;

DELETE FROM Aircrafts;
DELETE FROM Airports;
DELETE FROM Airlines;

-- 3. Reset IDs for Master tables (Optional but good for cleanliness)
ALTER TABLE Airlines AUTO_INCREMENT = 1;

-- 4. Re-enable Foreign Key Checks
SET FOREIGN_KEY_CHECKS = 1;

-- ==========================================
-- INSERT MASTER DATA
-- ==========================================

-- Insert Airlines
INSERT INTO Airlines (Airline_Name, IATA_Code) VALUES 
('IndiGo', '6E'), ('Air India', 'AI'), ('Vistara', 'UK'), 
('SpiceJet', 'SG'), ('Akasa Air', 'QP'), ('AIX Connect', 'I5'), 
('Emirates', 'EK'), ('Singapore Airlines', 'SQ'), 
('Qatar Airways', 'QR'), ('Lufthansa', 'LH');

-- Insert Airports
INSERT INTO Airports (Airport_Code, Name, City, State) VALUES 
('DEL', 'Indira Gandhi International', 'Delhi', 'Delhi'),
('BOM', 'Chhatrapati Shivaji Maharaj', 'Mumbai', 'Maharashtra'),
('BLR', 'Kempegowda International', 'Bangalore', 'Karnataka'),
('MAA', 'Chennai International', 'Chennai', 'Tamil Nadu'),
('HYD', 'Rajiv Gandhi International', 'Hyderabad', 'Telangana'),
('CCU', 'Netaji Subhash Chandra Bose', 'Kolkata', 'West Bengal'),
('COK', 'Cochin International', 'Kochi', 'Kerala'),
('AMD', 'Sardar Vallabhbhai Patel', 'Ahmedabad', 'Gujarat'),
('GOI', 'Dabolim Airport', 'Goa', 'Goa'),
('PNQ', 'Pune Airport', 'Pune', 'Maharashtra'),
('DXB', 'Dubai International', 'Dubai', 'UAE'),
('SIN', 'Changi Airport', 'Singapore', 'Singapore'),
('LHR', 'Heathrow Airport', 'London', 'UK'),
('JFK', 'John F. Kennedy International', 'New York', 'USA'),
('HND', 'Haneda Airport', 'Tokyo', 'Japan');

-- Insert Aircrafts
INSERT INTO Aircrafts (Tail_Number, Model, Capacity, Airline_ID) VALUES 
('VT-IFP', 'Airbus A320neo', 186, 1), ('VT-IZM', 'Airbus A321neo', 222, 1), 
('VT-IBG', 'ATR 72-600', 78, 1), ('VT-EXK', 'Airbus A321', 182, 2), 
('VT-PPV', 'Airbus A320', 180, 2), ('VT-ALN', 'Boeing 777-300ER', 342, 2), 
('VT-ANO', 'Boeing 787-8 Dreamliner', 256, 2), ('VT-TNC', 'Boeing 787-9', 299, 3), 
('VT-TTJ', 'Airbus A320neo', 164, 3), ('VT-TVB', 'Airbus A321neo', 188, 3), 
('VT-SYZ', 'Boeing 737 MAX 8', 189, 4), ('VT-SQA', 'Bombardier Q400', 78, 4), 
('VT-YAA', 'Boeing 737 MAX 8', 189, 5), ('VT-YAB', 'Boeing 737 MAX 8', 189, 5), 
('A6-EEO', 'Airbus A380-800', 517, 7), ('A6-EPP', 'Boeing 777-300ER', 360, 7), 
('9V-SKU', 'Airbus A380-800', 471, 8), ('9V-SMF', 'Airbus A350-900', 253, 8), 
('D-AIHI', 'Airbus A340-600', 297, 10), ('D-ABYT', 'Boeing 747-8', 364, 10);