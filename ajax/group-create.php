<?php
include "../config.php";

/**
 * @var object $pdo
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get the JSON data from the request body and decode it
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        $groupName = $data['groupName'];
        $fontIdList = $data['fontIdList'];

        // Check Exist
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `groups` WHERE `group_name`=?;");
        $stmt->execute([$groupName]);
        if ($stmt->fetchColumn()) {
            throw new Exception('Group name already exist');
        }

        // Find the next ID (Group)
        $stmt = $pdo->prepare("SELECT COALESCE(MAX(`id`) + 1, 1) FROM `groups`;");
        $stmt->execute();
        $groupId = $stmt->fetchColumn();

        // Create a new group
        $stmt = $pdo->prepare("INSERT INTO `groups`(`id`, `group_name`) VALUES (?,?);");
        $stmt->execute([$groupId, $groupName]);

        // Insert data into the database
        foreach ($fontIdList as $fontId) {
            $stmt = $pdo->prepare("INSERT INTO `grouping`(`group_id`, `font_id`) VALUES (?,?);");
            $stmt->execute([$groupId, $fontId]);
        }

        // Success response
        $response = [
            'status' => 'SUCCESS',
            'message' => "Query success"
        ];
    } catch (Exception $exception) {
        // Handle exceptions
        $response = [
            'status' => 'ERROR',
            'message' => $exception->getMessage()
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

