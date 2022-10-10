<?php

require('common.php');

// initializing variables
$_name = $_email = $_sid = $_gender = $_school = "";
$_nameIsOK = $_emailIsOK = $_sidIsOK = $_genderIsOK = $_schoolIsOK = true;
$_nameErrMsg = $_emailErrMsg = $_sidErrMsg = $_genderErrMsg = $_schoolErrMsg = "";
$_isSubmitted = false;

// check if the dirctory exists
if (file_exists($dir)) {
    if (isset($_POST['submit'])) {

        if (!empty(cleanInput($_POST['name']))) {
            $_name = cleanInput($_POST['name']);
        } else {
            $_nameErrMsg = "Name is required";
            $_nameIsOK = false;
        }

        if (!empty(cleanInput($_POST['email']))) {
            $_email = cleanInput($_POST['email']);
        } else {
            $_emailErrMsg = "Email is required";
            $_emailIsOK = false;
        }

        if (!empty(cleanInput($_POST['sid']))) {
            $_isUnique = true;
            $_sid = cleanInput($_POST['sid']);

            if(!empty(file_get_contents($fileName))){
                $file = fopen($fileName, 'r');

                while (!feof($file)) {
                    $line = fgets($file);
                    $data = explode("|", $line);
                    $sid = substr($data[2], 5);
                    if ($_sid == $sid) {
                        $_isUnique = false;
                        $_sidIsOK = false;
                        $_sidErrMsg = "Staff ID must be unique.";
                    }
                }
    
                fclose($file);
            }
        } else {
            $_sidErrMsg = "Staff ID is required";
            $_sidIsOK = false;
        }

        if (!empty(cleanInput($_POST['gender']))) {
            $_gender = cleanInput($_POST['gender']);
        } else {
            $_genderErrMsg = "Gender is required";
            $_genderIsOK = false;
        }

        if (!empty(cleanInput($_POST['school']))) {
            $_school = cleanInput($_POST['school']);
        } else {
            $_schoolErrMsg = "School is required";
            $_schoolIsOK = false;
        }

        if ($_nameIsOK && $_emailIsOK && $_sidIsOK && $_genderIsOK && $_schoolIsOK) {
            // opening the file with append mode
            $file = fopen($fileName, "a");


            // data to be written to file
            $dataString = "";

            // check if the file is empty
            if (empty(file_get_contents($fileName))) {
                $dataString = "Name: $_name|Email: $_email|SID: $_sid|Gender: $_gender|School: $_school";
            } else {
                $dataString = "\nName: $_name|Email: $_email|SID: $_sid|Gender: $_gender|School: $_school";
            }

            if (fwrite($file, $dataString)) {
                $_isSubmitted = true;
            }


            // close file 
            fclose($file);


            // opening the file with read mode
            $file = fopen($fileName, 'r');
            while (!feof($file)) {
                $line = fgets($file);
            }
            // close file 
            fclose($file);
        }
    }
} else {
    if (mkdir($dir)) {
        $file = fopen($fileName, 'a');
        fclose($file);
    }
}



?>

<!doctype html>
<html lang="en">

<?php
require('header.php');
?>

<body>
    <?php require('nav.php') ?>
    <div class="container">


        <div class="row">
            <div class="col-md-12">
                <h1>Employee Management System</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <form action="index.php" class="row needs-validation" method="POST" novalidate>
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" required>
                        <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
                        <div class="invalid-feedback">
                            <?php echo $_nameErrMsg ?>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        <div class="invalid-feedback">
                            <?php echo $_emailErrMsg ?>
                        </div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="sid" class="form-label">Staff ID</label>
                        <input type="text" class="form-control" id="sid" name="sid" aria-describedby="sidHelp" required>
                        <div id="sidHelp" class="form-text">Do not share your staff ID to avoid unauthorized access.
                        </div>
                        <div class="invalid-feedback">
                            <?php echo $_sidErrMsg ?>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select form-select-md mb-3" aria-label=".form-select-lg example" required>
                            <option selected></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <div class="invalid-feedback">
                            <?php echo $_genderErrMsg ?>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="school" class="form-label">School</label>
                        <select name="school" id="school" class="form-select form-select-md mb-3" aria-label=".form-select-lg example" required>
                            <option selected></option>
                            <option value="FECS">FECS</option>
                            <option value="SFS">SFS</option>
                            <option value="FDBA">FDBA</option>
                        </select>
                        <div class="invalid-feedback">
                            <?php echo $_schoolErrMsg ?>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        <?php

                        if (isset($_isUnique)) {
                            if (!$_isUnique) {
                                echo "<div class='alert alert-danger mt-3' role='alert'>$_sidErrMsg</div>";
                            }
                        }

                        if ($_isSubmitted) {
                            echo '<div class="alert alert-success mt-3" role="alert">Successfully added an employee!</div>';
                        }
                        ?>

                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
</body>

</html>