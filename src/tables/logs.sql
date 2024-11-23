-- Create the logs table
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    log TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert data into the logs table
INSERT INTO logs (log) VALUES
('User johndoe logged in successfully'),
('User janedoe attempted to access restricted area'),
('User alice updated profile information'),
('User bob logged out');