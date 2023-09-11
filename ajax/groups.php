<?php
include "../config.php";

/**
 * @var object $pdo
 */

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Select all data from the database
        $sql = "SELECT
                    t1.id AS group_id,
                    t1.group_name,
                    GROUP_CONCAT(
                        SUBSTRING_INDEX(t3.font_name, '.', 1) SEPARATOR ', '
                    ) AS fonts
                FROM
                    `groups` t1
                LEFT JOIN `grouping` t2 ON
                    t2.group_id = t1.id
                INNER JOIN fonts t3 ON
                    t3.id = t2.font_id
                GROUP BY
                    t1.group_name,t1.id;";
        $stmt = $pdo->prepare($sql);
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
