<?php

require '../lib/PhpSpreadsheet/vendor/autoload.php';
include_once("function.php");
include_once("connection.php");
use PhpOffice\PhpSpreadsheet\IOFactory;

$conn = mysqli_connect("localhost", "u657160054_usrKS", "$2zOMhU+k!9", "u657160054_KS");

function get_last_que_id()
{
    $conn = mysqli_connect("localhost", "u657160054_usrKS", "$2zOMhU+k!9", "u657160054_KS");
    $sql = "SELECT * FROM questions ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            return $row['id'];
        }
    }
}

function auto_select_bin($sub_id, $conn)
{
    include_once('function.php');
    $nob = get_num_of_bins_by_sub_id($sub_id, $conn);
    $int_nob = intval($nob);
    $output = rand(1, $int_nob);
    return $output;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $uploadFile = $_FILES['excel_sub_file']['tmp_name'];

    $spreadsheet = IOFactory::load($uploadFile);
    $worksheet = $spreadsheet->getActiveSheet();

    $its_first_row = true;
    $its_not_first_row = false;
    
    foreach ($worksheet->getRowIterator() as $row) 
    {
        $quiz_id = "";
        $sub_name = "";
        $bin_num = "";
        $sub_txt = "";
        $sub_img = "";
        $sub_vid = "";

        foreach ($row->getCellIterator() as $cell) 
        {
            $rowIndex = $row->getRowIndex();
            $columnIndex = $cell->getColumn();
            $cellValue = $cell->getValue();
            
            // Upload new subject with the following data
            if ($columnIndex === 'A') 
            {
                $quiz_id = $cellValue;
            } 
            elseif ($columnIndex === 'B') 
            {
                $sub_name = $cellValue;
            } 
            elseif ($columnIndex === 'C') 
            {
                $bin_num = $cellValue;
            }
            elseif ($columnIndex === 'D') 
            {
                $sub_txt = $cellValue;
            }
            elseif ($columnIndex === 'E') 
            {
                $sub_img = $cellValue;
            }
            elseif ($columnIndex === 'F') 
            {
                $sub_vid = $cellValue;
            }
        }
        
        if($its_not_first_row)
        {
            if(!empty($quiz_id) && !empty($sub_name) && !empty($bin_num))
            {
                $sql = "INSERT INTO `subjects`(`id`, `sub_name`, `sub_quiz_id`, `sub_bin_num`, `sub_video`, `sub_img`, `sub_text`, `sub_status`) 
                                    VALUES (NULL,'$sub_name','$quiz_id','$bin_num','$sub_vid','$sub_img','$sub_txt','publish')";
                mysqli_query($conn, $sql);
            }
        }
        if($its_first_row)
        {
            $its_not_first_row = true;
        }
    }
    
    $html = "<table border='1'>";
    $is_it_first_row = true;
    foreach ($worksheet->getRowIterator() as $row) 
    {
        $row_has_content = false;
        if($is_it_first_row)
        {
            $html .= "<tr class='excel_output_table_first_row'>";
            $is_it_first_row = false;
        }
        else
        {
            $html .= "<tr class='excel_output_table_row'>";
        }

        foreach ($row->getCellIterator() as $cell) 
        {
            $val = $cell->getValue();
            $cell_id = "";
            if(!empty($val))
            {
                if(str_starts_with($val, 'http'))
                {
                    $html .= "<td><img src='" . $val . "'></td>";
                }
                else
                {
                    $html .= "<td>" . $val . "</td>";
                }
                $row_has_content = true;
            }
        }
        if($row_has_content)
        {
            $html .= "</tr>";
        }
    }
    $html .= "</table>";
    
    echo $html;
}
else
{
    echo "error by reading the file";
}

?>