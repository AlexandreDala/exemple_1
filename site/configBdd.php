<?php
/**
 * Fichier de configuration de la base de données
 */

$_ENV["DB_USER"] = "oceane-web"; // utilisateur de la base de données
$_ENV["DB_PASSWORD"] = "oceane-intra"; // mot de passe de l'utilisateur de la base de données
$_ENV["DSN"] = "mysql:host=127.0.0.1;dbname=oceane;port=3306"; // data source name
$_ENV["OPTIONS"] = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'', 
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC); // options pour le driver PDO : UTF8 pour gérer les accents


/**
 * Connexion à la base de données et retourne l'objet PDO
 *
 * @return PDO
 */
function getPDO() : PDO {
    $dsn = $_ENV["DSN"];
    $user = $_ENV["DB_USER"];
    $password = $_ENV["DB_PASSWORD"];
    return new PDO($dsn, $user, $password, $_ENV["OPTIONS"]);
}
