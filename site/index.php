<?php
header("Content-Type: application/json");
include 'configBdd.php';
require __DIR__ . '/API/bateau.php';


$method = $_SERVER['REQUEST_METHOD'];
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $path);

$pdo = getPDO();
$resultat = null;

if ($segments[0] === 'bateaux') {
    switch ($method) {
        case 'GET':
            if (isset($segments[1]) && is_numeric($segments[1])) {
                $resultat = getBateau($pdo, intval($segments[1]));
            } else {
                $resultat = getBateaux($pdo);
            }
            break;
        case 'POST':
            $resultat = createBateau($pdo, json_decode(file_get_contents('php://input'), true));
            break;

        case 'PUT':
            if (isset($segments[1]) && is_numeric($segments[1])) {
                $resultat = updateBateau($pdo, intval($segments[1]), json_decode(file_get_contents('php://input'), true));
            } else {
                $resultat = json_encode(["status" => "error", "message" => "ID manquant"]);
            }
            break;
        case 'DELETE':
            if (isset($segments[1]) && is_numeric($segments[1])) {
                $resultat = deleteBateau($pdo, intval($segments[1]));
            } else {
                $resultat = json_encode(["status" => "error", "message" => "ID manquant"]);
            }
            break;
        default:
            $resultat = json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
    }
} else {
    $resultat = json_encode(["status" => "error", "message" => "Ressource non trouvée"]);
}


echo $resultat;