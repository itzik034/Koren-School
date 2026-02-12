<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=UTF-8');

require_once __DIR__ . '/../lib/PhpSpreadsheet/vendor/autoload.php';
include_once __DIR__ . '/function.php';
include_once __DIR__ . '/connection.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// חיבור למסד נתונים
$conn = mysqli_connect("localhost", "u657160054_usrKS", "$2zOMhU+k!9", "u657160054_KS");
if (!$conn) {
    http_response_code(500);
    exit("DB connection failed: " . mysqli_connect_error());
}

function get_last_que_id(mysqli $conn)
{
    $sql = "SELECT id FROM questions ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        return (int)$row['id'];
    }
    return 0;
}

function auto_select_bin($sub_id, mysqli $conn)
{
    include_once(__DIR__ . '/function.php');
    $nob = get_num_of_bins_by_sub_id($sub_id, $conn);
    $int_nob = intval($nob);
    return rand(1, max(1, $int_nob));
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_FILES['excel_file'])) {
    http_response_code(400);
    exit("no file uploaded");
}

$uploadFile = $_FILES['excel_file']['tmp_name'];
if (!file_exists($uploadFile)) {
    exit("Temporary file not found");
}

try {
    $spreadsheet = IOFactory::load($uploadFile);
} catch (Throwable $e) {
    http_response_code(500);
    exit("Excel load error: " . $e->getMessage());
}

$worksheet = $spreadsheet->getActiveSheet();

$its_first_row = true;
foreach ($worksheet->getRowIterator() as $row) {
    $data = [];
    foreach ($row->getCellIterator() as $cell) {
        $col = $cell->getColumn();
        $data[$col] = trim((string)$cell->getValue());
    }

    if (!$its_first_row && !empty($data['A']) && !empty($data['B'])) {
        $sub_id = $data['A'];
        $selected_sub = $sub_id;
        $selected_bin = auto_select_bin($sub_id, $conn);
        $que_id = get_last_que_id($conn) + 1;

        mysqli_query($conn, "INSERT INTO questions (id, que_text, que_bin, que_subject, que_video, que_img)
                             VALUES ('$que_id', '{$data['B']}', '$selected_bin', '$selected_sub', '{$data['C']}', '{$data['D']}')");

        // תשובה נכונה
        if (!empty($data['E'])) {
            mysqli_query($conn, "INSERT INTO answears (ans_text, ans_question, ans_correct)
                                 VALUES ('{$data['E']}', '$que_id', 1)");
        }

        // תשובות נוספות
        foreach (['F','G','H','I','J','K'] as $col) {
            if (!empty($data[$col])) {
                mysqli_query($conn, "INSERT INTO answears (ans_text, ans_question, ans_correct)
                                     VALUES ('{$data[$col]}', '$que_id', 0)");
            }
        }
    }

    $its_first_row = false;
}

echo "Excel processed successfully.";
