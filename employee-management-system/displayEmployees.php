<?php require('common.php'); ?>

<!DOCTYPE html>
<html lang="en">
<?php
require('header.php');
?>

<body>
    <?php require('nav.php') ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Employees</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php
                if (file_exists($fileName)) {
                    if (!empty(file_get_contents($fileName))) {
                        $file = fopen($fileName, 'r');

                        echo '<ol class="list-group list-group-numbered">';
                        while (!feof($file)) {
                            $line = fgets($file);
                            $data = explode("|", $line);
                            $name = substr($data[0], 6);
                            $sid = substr($data[2], 5);
                            $school = substr($data[4], 8);
                            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
                    <div class='ms-2 me-auto'>
                    <div class='fw-bold'><a href='viewEmployee.php?sid=$sid'>$name</a></div>
                    $sid
                  </div>
                  <span class='badge bg-primary rounded-pill'>$school</span>
                    
                    </li>";
                        }
                        echo '</ol>';
                        fclose($file);
                    } else {
                        echo "<div class='card'>
                        <div class='card-body'>
                            Currently, there are no employees.
                        </div>
                    </div>
                    ";
                    }
                } else {
                    echo "<div class='card'>
                        <div class='card-body'>
                            The data file does not exists.
                        </div>
                    </div>
                    ";
                }

                ?>
            </div>
        </div>
    </div>


</body>

</html>