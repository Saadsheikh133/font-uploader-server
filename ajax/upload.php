<?php
include "../config.php";

/**
 * @var object $pdo
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get file details
        $fileName = $_FILES['file']['name'];
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Check file extension
        if (strtoupper($extension) !== 'TTF') {
            throw new Exception('Only TTF Files are Allowed');
        }

        // Check Exist
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `fonts` WHERE `font_name`=?;");
        $stmt->execute([$fileName]);
        if ($stmt->fetchColumn()) {
            throw new Exception('File already exist');
        }

        // Find the next ID
        $stmt = $pdo->prepare("SELECT COALESCE(MAX(`id`) + 1, 1) FROM `fonts`;");
        $stmt->execute();
        $id = $stmt->fetchColumn();

        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO `fonts`(`id`, `font_name`) VALUES (?,?);");
        $stmt->execute([$id, $fileName]);

        // Copy file to directory
        move_uploaded_file($fileTmpPath, APP_PATH . "uploads/$fileName");

        // Success response
        $response = [
            'status' => 'SUCCESS',
            'message' => "Upload success [$fileName]"
        ];
    } catch (Exception $exception) {
        // Handle exceptions
        $response = [
            'status' => 'ERROR',
            'message' => $exception->getMessage() . " [$fileName]"
        ];
    }

    // Send JSON response
    header('Content-type: application/json');
    echo json_encode($response);
} else {
    // Handle invalid request method
    http_response_code(405);
    echo 'Method Not Allowed';
}

sleep(1);