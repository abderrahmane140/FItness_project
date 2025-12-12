CREATE DATABASE fitness;

USE DATABASE fitness;

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    start_hour TIME NOT NULL,
    duration INT NOT NULL,
    max_participants INT NOT NULL
);

CREATE TABLE equipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    state VARCHAR(255) DEFAULT 'bon'
);

CREATE TABLE course_equipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    equipment_id INT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (equipment_id) REFERENCES equipments(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,

    FOREIGN KEY (role_id) REFERENCES roles(id)
)


CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);



-- inserting


--roles table
INSERT INTO roles (name) VALUES 
('admin'),
('user');

--users table 
INSERT INTO users (username, email, password, role_id) VALUES
('ahmed', 'ahmed@example.com', 'password123', 1),  -- admin
('hassan', 'hassan@example.com', 'password123', 2),      -- user
('aymen', 'aymen@example.com', 'password123', 2); -- user
--bsarabderrahmane01@gmail.com  password123

--courses table
INSERT INTO courses (title, category, date, start_hour, duration, max_participants) VALUES
('Yoga Basics', 'Yoga', '2025-12-05', '09:00:00', 60, 15),
('Cardio Blast', 'Cardio', '2025-12-05', '11:00:00', 45, 20),
('Pilates', 'Pilates', '2025-12-06', '10:00:00', 50, 10);


--Equipments table
INSERT INTO equipments (name, type, quantity, state) VALUES
('Yoga Mat', 'Mat', 20, 'bon'),
('Dumbbell', 'Weights', 10, 'moyen'),
('Exercise Ball', 'Ball', 15, 'bon');


--Course_Equipments
INSERT INTO course_equipments (course_id, equipment_id) VALUES
(1, 1), 
(1, 3),  
(2, 2),  
(3, 1),  
(3, 3);  




INSERT INTO roles (name) VALUES ('user'), ('admin');


ALTER TABLE users
MODIFY role_id INT NOT NULL DEFAULT 1;
