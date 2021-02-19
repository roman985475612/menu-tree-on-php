CREATE TABLE categories(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(40) NOT NULL,
    parent_id INT NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO categories(title, parent_id) VALUES
    ('Category 1', 0),
    ('Category 2', 0),
    ('Category 3', 0),
    ('Category 2.1', 2),
    ('Category 2.2', 2),
    ('Category 2.1.1', 4),
    ('Category 2.1.2', 4);
