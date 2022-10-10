<?php

// directory name
$dir = './Data';

// file name
$fileName = "$dir/employees.txt";


function cleanInput($input)
{
    $cleanedText = htmlspecialchars($input);
    $cleanedText = trim($input);
    $cleanedText = stripslashes($input);
    return $cleanedText;
}
?>