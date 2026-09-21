<?php
function getBateaux(PDO $pdo) : string {
    $stmt = $pdo->query("SELECT * FROM bateau");
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getBateauData(PDO $pdo, int $id) : array {
    $stmt = $pdo->prepare("SELECT * FROM bateau WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data === false) {
        return array(); // Retourne un tableau vide si aucun bateau n'est trouvé
    } else {
        return $data; // Retourne les données du bateau trouvé
    }
}

function getBateau(PDO $pdo, int $id) : string {
    $data = getBateauData($pdo, $id);
    if(empty($data)){
        return json_encode(["status" => "error", "message" => "bateau non trouvé"]);
    }
    else {
        return json_encode($data); 
    }
}

function createBateau (PDO $pdo, array $data) : string {
    // vérifier que les champs nécessaires sont présents
    if (!isset($data['id']) || !isset($data['nom']) || !isset($data['description'])) {
        return json_encode(["status" => "error", "message" => "Champs manquants"]);
    }
    $stmt = $pdo->prepare("INSERT INTO bateau (id, nom, description) VALUES (:id, :nom, :description)");
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
     $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->execute();
    return json_encode(["status" => "Bateau ajouté avec succès","bateau"=> getBateauData($pdo, $data['id'])]);
}


function updateBateau (PDO $pdo, int $id, array $data) : string {
    if (!isset($data['nom']) || !isset($data['description'])) {
        return json_encode(["status" => "error", "message" => "Champs manquants"]);
    }
    $stmt = $pdo->prepare("UPDATE bateau SET nom = :nom, description = :description WHERE id = :id");
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $bateau = getBateauData($pdo, $id);
    return json_encode(["status" => "success", "bateau" => $bateau]);
}

function deleteBateau (PDO $pdo, int $id) {
    $stmt = $pdo->prepare("DELETE FROM bateau WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return json_encode(["status" => "Bateau supprimé avec succès"]);
}
