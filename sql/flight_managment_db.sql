CREATE DATABASE FlightManagementDB;
USE FlightManagementDB;

-- 1. Airlines (No changes needed)
CREATE TABLE Airlines (
    Airline_ID INT PRIMARY KEY AUTO_INCREMENT,
    Airline_Name VARCHAR(50) NOT NULL,
    IATA_Code VARCHAR(3) UNIQUE NOT NULL
);

-- 2. Airports (No changes needed)
CREATE TABLE Airports (
    Airport_Code VARCHAR(3) PRIMARY KEY,
    Name VARCHAR(100),
    City VARCHAR(50),
    State VARCHAR(50)
);

-- 3. Aircrafts (No changes needed)
CREATE TABLE Aircrafts (
    Tail_Number VARCHAR(10) PRIMARY KEY,
    Model VARCHAR(50),
    Capacity INT,
    Airline_ID INT,
    FOREIGN KEY (Airline_ID) REFERENCES Airlines(Airline_ID) ON DELETE SET NULL
);

-- 4. Flights (Added Price)
CREATE TABLE Flights (
    Flight_ID INT PRIMARY KEY AUTO_INCREMENT,
    Flight_Number VARCHAR(10),
    Origin_Airport VARCHAR(3),
    Destination_Airport VARCHAR(3),
    Departure_Time DATETIME,
    Arrival_Time DATETIME,
    Tail_Number VARCHAR(10),
    Price DECIMAL(10,2), -- Added Price
    FOREIGN KEY (Origin_Airport) REFERENCES Airports(Airport_Code),
    FOREIGN KEY (Destination_Airport) REFERENCES Airports(Airport_Code),
    FOREIGN KEY (Tail_Number) REFERENCES Aircrafts(Tail_Number)
);

-- 5. Passengers (Added Password for Login)
CREATE TABLE Passengers (
    Passenger_ID INT PRIMARY KEY AUTO_INCREMENT,
    First_Name VARCHAR(50),
    Last_Name VARCHAR(50),
    Email VARCHAR(100) UNIQUE, -- Make Email Unique to prevent duplicates
    Password VARCHAR(255) -- Added for login functionality
);

-- 6. Bookings (Added Cascade Delete)
CREATE TABLE Bookings (
    Booking_Ref VARCHAR(10) PRIMARY KEY,
    Flight_ID INT,
    Passenger_ID INT,
    Seat_Number VARCHAR(5),
    Status VARCHAR(20) DEFAULT 'Confirmed',
    -- If a flight or passenger is deleted, delete the booking too
    FOREIGN KEY (Flight_ID) REFERENCES Flights(Flight_ID) ON DELETE CASCADE,
    FOREIGN KEY (Passenger_ID) REFERENCES Passengers(Passenger_ID) ON DELETE CASCADE
);

