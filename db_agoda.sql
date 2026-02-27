
CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    agoda_hotel_id VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT,
    name VARCHAR(255),
    agoda_room_id VARCHAR(50),
    total_inventory INT,
    FOREIGN KEY (property_id) REFERENCES properties(id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agoda_booking_id VARCHAR(100) UNIQUE,
    status VARCHAR(50),
    checkin DATE,
    checkout DATE,
    guest_name VARCHAR(255),
    total_amount DECIMAL(12,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50),
    payload TEXT,
    status VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_reservation_booking ON reservations(agoda_booking_id);
CREATE INDEX idx_jobs_status ON jobs(status);