<?php

session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

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
                    $value = filter_var($cell->getValue(), FILTER_SANITIZE_STRING);
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