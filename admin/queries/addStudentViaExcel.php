<?php

include('../../includes/connection.php');
require '../../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
            $excelFile = $_FILES['excelFile']['tmp_name'];
            $spreadsheet = IOFactory::load($excelFile);
            $worksheet = $spreadsheet->getActiveSheet();

            $stmt = $conn->prepare("INSERT INTO tbl_students (id, firstname, lastname, gender, email, password, isActive) VALUES (?, ?, ?, ?, ?, ?, ?)");

            foreach ($worksheet->getRowIterator() as $index => $row) {
                if ($index === 1) {
                    continue;
                }

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }
          
                if (count($rowData) === 7) {
                    $stmt->execute($rowData);
                } else {
                    echo json_encode(['error' => 'Invalid number of columns in the Excel file.']);
                    exit;
                }
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
?>
