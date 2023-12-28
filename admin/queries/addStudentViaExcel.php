<?php

include('../../includes/connection.php');
require 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
            $excelFile = $_FILES['excelFile']['tmp_name'];
            $spreadsheet = IOFactory::load($excelFile);
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                $stmt = $conn->prepare("INSERT INTO tbl_students (student_id, first_name, last_name, gender, email) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute($rowData);
            }
        }

        $response = ['success' => 'Data added successfully'];
        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error processing Excel file: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
