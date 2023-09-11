<?php
include "../config.php";

/**
 * @var object $pdo
 */

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        if (!isset($_GET['id'])) {
            throw new Exception('Invalid request');
        }

        // Select a record from the database
        $stmt = $pdo->prepare("SELECT * FROM `fonts` WHERE `id`=?;");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if (empty($row)) {
            throw new Exception('Record not found');
        }

        // Delete record from the database
        $stmt = $pdo->prepare("DELETE FROM `fonts` WHERE `id`=?;");
        $stmt->execute([$_GET['id']]);

        // Delete file
        $filePath = APP_PATH . 'uploads/' . $row->font_name;
        if (is_file($filePath)) {
            unlink($filePath);
        }

        http_response_code(204); // No content

    } catch (Exception $exception) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => $exception->getMessage()]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed.']);
}

sleep(1);