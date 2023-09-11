<?php
const HOSTNAME = 'localhost';
const USERNAME = 'root';
const PASSWORD = '';
const DATABASE = 'programming_hero_task';
const APP_PATH = __DIR__ . DIRECTORY_SEPARATOR;

try {
    $dns = sprintf("mysql:host=%s;dbname=%s", HOSTNAME, DATABASE);
    $pdo = new PDO($dns, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $exception) {
    exit("Connection failed: " . $exception->getMessage());
}