-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone_number VARCHAR(15),
    address VARCHAR(255),
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(10),
    country VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data into the users table
INSERT INTO users (username, password, email, first_name, last_name, phone_number, address, city, state, zip_code, country) VALUES
('johndoe', MD5('password123'), 'johndoe@example.com', 'John', 'Doe', '1234567890', '123 Main St', 'Anytown', 'Anystate', '12345', 'USA'),
('janedoe', MD5('mypassword'), 'janedoe@example.com', 'Jane', 'Doe', '0987654321', '456 Elm St', 'Othertown', 'Otherstate', '54321', 'USA'),
('alice', MD5('alicepassword'), 'alice@example.com', 'Alice', 'Smith', '1112223333', '789 Maple Ave', 'Sometown', 'Somestate', '67890', 'USA'),
('bob', MD5('bobpassword'), 'bob@example.com', 'Bob', 'Johnson', '4445556666', '321 Oak St', 'Differenttown', 'Differentstate', '09876', 'USA');