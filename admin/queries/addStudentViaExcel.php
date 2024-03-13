<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
            $excelFile = $_FILES['excelFile']['tmp_name'];

            $spreadsheet = IOFactory::load($excelFile);
            $worksheet = $spreadsheet->getActiveSheet();

            $stmt = $conn->prepare("INSERT INTO tbl_students (id, firstname, lastname, gender, email, password, image, isActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            foreach ($worksheet->getRowIterator() as $index => $row) {
                if ($index === 1) {
                    continue;
                }

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $value = sanitizeInput($cell->getValue());
                    $rowData[] = $value;
                }

                $hashedPassword = sha1($rowData[5]);
                $rowData[5] = $hashedPassword;

                if (!empty(array_filter($rowData))) {
                    $stmt->execute($rowData);
                } else {
                    continue;
                }
            }

            // Insert audit log entry
            $logMessage = "Admin with admin id: {$_SESSION['admin_id']} added students from an Excel file";
            $auditStmt = $conn->prepare("INSERT INTO tbl_audit (action, table_name, log_message, admin_id, timestamp) VALUES ('insert', 'tbl_students', ?, ?, NOW())");
            $auditStmt->execute([$logMessage, $_SESSION['admin_id']]);

            $response = ['success' => 'Data added successfully'];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'File upload failed']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error processing Excel file: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
