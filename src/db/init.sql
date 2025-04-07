CREATE TABLE recipes (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    prep_time INT NOT NULL,
    difficulty INT NOT NULL CHECK (difficulty BETWEEN 1 AND 3),
    vegetarian BOOLEAN NOT NULL
);
INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES
    ('Spaghetti Bolognese', 30, 2, TRUE),
    ('Chicken Curry', 45, 3, FALSE),
    ('Vegan Quinoa Salad', 20, 1, TRUE),
    ('Beef Stroganoff', 60, 2, FALSE),
    ('Vegetable Stir Fry', 25, 1, TRUE);
    
