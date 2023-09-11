<?php
include "../config.php";

/**
 * @var object $pdo
 */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Select all data from the database
        $stmt = $pdo->prepare("SELECT * FROM `fonts` ORDER BY `font_name`;");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Success response
        $response = [
            'status' => 'SUCCESS',
            'message' => 'Query success',
            'data' => $result
        ];
    } catch (PDOException $PDOException) {
        // Handle PDOExceptions separately (e.g., for database connection issues)
        $response = [
            'status' => 'ERROR',
            'message' => 'Database Error: ' . $PDOException->getMessage()
        ];
    } catch (Exception $exception) {
        // Handle exceptions
        $response = [
            'status' => 'ERROR',
            'message' => 'Error: ' . $exception->getMessage()
        ];
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle invalid request method
    http_response_code(405);
    echo 'Method Not Allowed';
}

sleep(1);
