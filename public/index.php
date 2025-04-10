<?php

phpinfo();

header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Recipe.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/db/init.sql';



$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$method = $_SERVER['REQUEST_METHOD'];
$db = (new Database())->getConnection();

// Routes
if ($uri[0] === 'recipes') {
    switch ($method) {
        case 'GET':
            if (isset($uri[1])) {
                // GET /recipes/{id}
                $stmt = $db->prepare("SELECT * FROM recipes WHERE id = :id");
                $stmt->execute(['id' => $uri[1]]);
                $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($recipe) {
                    echo json_encode($recipe);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Recipe not found']);
                }
            } else {
                // GET /recipes
                $stmt = $db->query("SELECT * FROM recipes");
                $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($recipes);
            }
            break;

        case 'POST':
            // POST /recipes
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name'], $data['prep_time'], $data['difficulty'], $data['vegetarian'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid input']);
                break;
            }

            $stmt = $db->prepare("INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES (:name, :prep_time, :difficulty, :vegetarian) RETURNING *");
            $stmt->execute([
                'name' => $data['name'],
                'prep_time' => $data['prep_time'],
                'difficulty' => $data['difficulty'],
                'vegetarian' => $data['vegetarian']
            ]);
            $newRecipe = $stmt->fetch(PDO::FETCH_ASSOC);

            http_response_code(201);
            echo json_encode($newRecipe);
            break;

        case 'DELETE':
            // DELETE /recipes/{id}
            if (!isset($uri[1])) {
                http_response_code(400);
                echo json_encode(['error' => 'Recipe ID required']);
                break;
            }

            $stmt = $db->prepare("DELETE FROM recipes WHERE id = :id");
            $stmt->execute(['id' => $uri[1]]);

            if ($stmt->rowCount()) {
                echo json_encode(['message' => 'Recipe deleted']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Recipe not found']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }

    exit;
}

// Fallback for all other routes
http_response_code(404);
echo json_encode(['error' => 'Not found']);


