<?php require('common.php'); ?>

<?php
$_sid = "";
if (!empty(cleanInput($_GET['sid']))) {
    $_sid = cleanInput($_GET['sid']);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
require('header.php');
?>

<body>
    <?php require('nav.php') ?>
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php

                    $file = fopen($fileName, 'r');


                    echo '<ul class="list-group">';
                    while (!feof($file)) {
                        $line = fgets($file);
                        $data = explode("|", $line);
                        $name = substr($data[0], 6);
                        $sid = substr($data[2], 5);
                        $email = substr($data[1], 7);
                        $gender = substr($data[3], 8);
                        $school = substr($data[4], 8);

                        if ($_sid == $sid) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
                            <div class='ms-2 me-auto'>
                            <div class='fw-bold'>Name</div>
                            $name
                            </div>
                            </li>";

                            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
                            <div class='ms-2 me-auto'>
                            <div class='fw-bold'>Email</div>
                            $email
                            </div>
                            </li>";

                            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
                            <div class='ms-2 me-auto'>
                            <div class='fw-bold'>Staff ID</div>
                            $sid
                            </div>
                            </li>";

                            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
                            <div class='ms-2 me-auto'>
                            <div class='fw-bold'>Gender</div>
                            $gender
                            </div>
                            </li>";

                            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
                            <div class='ms-2 me-auto'>
                            <div class='fw-bold'>School</div>
                            $school
                            </div>
                            </li>";
                        }
                    }

                    echo '</ul>';


                    fclose($file);


                    ?>
                </div>
            </div>
        </div>
    </div>


</body>

</html>