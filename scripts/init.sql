-- Создание таблицы Position
CREATE TABLE Position (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          earth VARCHAR(64),
                          sun VARCHAR(64),
                          moon VARCHAR(64)
);

-- Создание таблицы Sector
CREATE TABLE Sector (
                        id INT  AUTO_INCREMENT PRIMARY KEY,
                        coordinates VARCHAR(255),
                        light_intensity DECIMAL(10,2),
                        foreign_objects VARCHAR(255),
                        count_stars INT,
                        count_unidentified_objects INT,
                        count_identified_objects INT,
                        notes VARCHAR(255),
                        date_update DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Создание таблицы Objects
CREATE TABLE Objects (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         type VARCHAR(50),
                         accuracy DECIMAL(5,3),
                         count INT,
                         detected_date DATE,
                         detected_time TIME,
                         notes VARCHAR(255)
);

CREATE TABLE NaturalObjects (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                type VARCHAR(255),
                                galaxy VARCHAR(255),
                                accuracy DECIMAL(5,3),
                                light_flux VARCHAR(255),
                                associated_objects VARCHAR(255),
                                note VARCHAR(255)
);

-- Создание таблицы Link
CREATE TABLE Link (
                      id INT PRIMARY KEY,
                      id_sector INT,
                      id_object INT,
                      id_naturalObject INT,
                      id_position INT,
                      FOREIGN KEY (id_sector) REFERENCES Sector (id) ON DELETE CASCADE,
                      FOREIGN KEY (id_object) REFERENCES Objects (id) ON DELETE CASCADE,
                      FOREIGN KEY (id_naturalObject) REFERENCES NaturalObjects (id) ON DELETE CASCADE,
                      FOREIGN KEY (id_position) REFERENCES Position (id) ON DELETE CASCADE
);

-- Создание триггера для таблицы Sector
DELIMITER //
CREATE TRIGGER after_sector_update
    AFTER UPDATE ON Sector
    FOR EACH ROW
BEGIN
    UPDATE Sector SET date_update = CURRENT_TIMESTAMP WHERE id = NEW.id;
END //
DELIMITER ;

-- Создание процедуры для объединения двух таблиц
DELIMITER //

CREATE PROCEDURE join_tables_data(IN table1_name VARCHAR(50), IN table2_name VARCHAR(50))
BEGIN
    SET @sql = CONCAT('SELECT * FROM ', table1_name, ' NATURAL JOIN ', table2_name);
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE edit_NaturalObjects(IN id_par INT,
                            IN type_par VARCHAR(255),
                            IN galaxy_par VARCHAR(255),
                            IN accuracy_par DECIMAL(5,3),
                            IN light_flux_par VARCHAR(255),
                            IN associated_objects_par VARCHAR(255),
                            IN note_par VARCHAR(255))
BEGIN
    UPDATE NaturalObjects
    SET type = type_par,
        galaxy = galaxy_par,
        accuracy = accuracy_par,
        light_flux = light_flux_par,
        associated_objects = associated_objects_par,
        note = note_par
    WHERE id = id_par;
END //

DELIMITER;

-- Данные для таблицы Position
INSERT INTO Position (id, earth, sun, moon) VALUES
        (1, '10.0000° N, 20.0000° W', '10.0000° N, 20.0000° W', '10.0000° N, 20.0000° W'),
        (2, '25.0000° N, 30.0000° W', '25.0000° N, 30.0000° W', '25.0000° N, 30.0000° W');

-- Данные для таблицы Sector
INSERT INTO Sector (id,
                    coordinates,
                    light_intensity,
                    foreign_objects,
                    count_stars,
                    count_unidentified_objects,
                    count_identified_objects,
                    notes) VALUES
                            (1, '00:38:38.3 / +27:27:27.3', 3.33, 'for objects', 25, 25, 25, 'some notes'),
                            (2, '00:38:38.3 / +27:27:27.3', 3.33, 'for objects', 25, 25, 25, 'some notes');

-- Данные для таблицы Objects
INSERT INTO Objects (id,
                    type,
                    accuracy,
                    count,
                    detected_date,
                    detected_time,
                    notes) VALUES
                            (1, 'some type', 87.200, 12, '2022-12-22', '11:11:11', 'some notes'),
                            (2, 'some type',  78.200, 156, '2023-01-12', '12:12:12', 'some notes');                                                                                                                                                                   
-- Данные для таблицы NaturalObjects
INSERT INTO NaturalObjects (id,
                            type,
                            galaxy,
                            accuracy,
                            light_flux,
                            associated_objects,
                            note) VALUES
                                    (1, 'some type', 'Milky Way', 99.400, '4.4', 'some associated objects', 'some notes'),
                                    (2, 'some type', 'Milky Way', 97.500, '9.3', 'some associated objects', 'some notes');

-- Данные для таблицы Link
INSERT INTO Link (id,
                id_sector,
                id_object,
                id_naturalObject,
                id_position) VALUES
                        (1, 1, 2, 1, 2),
                        (2, 2, 1, 2, 1);