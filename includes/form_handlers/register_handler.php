<?php
//Declaring variables to prevent errors
$fname = ""; //First name
$lname = ""; //Last name
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date 
$error_code = null;
$error_codes = array(

    "E100" => "Email already in use<br>",
    "E101" => "Invalid email format<br>",
    "E102" => "Your first name must be between 2 and 25 characters<br>",
    "E103" => "Your last name must be between 2 and 25 characters<br>",
    "E104" => "Your passwords do not match<br>",
    "E105" => "Your password can only contain english characters or numbers<br>",
    "E106" => "Your password must be betwen 5 and 30 characters<br>",
    "E107" => "<span style='color: #14C800;'>¡Registro completado!</span><br>"

); //Holds error messages



if (isset($_POST['register_button'])) {

    

    //First name
    $fname = strip_tags($_POST['reg_fname']); //Remove html tags
    $fname = str_replace(' ', '', $fname); //remove spaces
    $fname = ucfirst(strtolower($fname)); //Uppercase first letter
    $_SESSION['reg_fname'] = $fname; //Stores first name into session variable

    //Last name
    $lname = strip_tags($_POST['reg_lname']); //Remove html tags
    $lname = str_replace(' ', '', $lname); //remove spaces
    $lname = ucfirst(strtolower($lname)); //Uppercase first letter
    $_SESSION['reg_lname'] = $lname; //Stores last name into session variable

    //email
    $em = strip_tags($_POST['reg_email']); //Remove html tags
    $em = str_replace(' ', '', $em); //remove spaces
    $em = ucfirst(strtolower($em)); //Uppercase first letter
    $_SESSION['reg_email'] = $em; //Stores email into session variable

    

    //Password
    $password = strip_tags($_POST['reg_password']); //Remove html tags
    $password2 = strip_tags($_POST['reg_password2']); //Remove html tags

    $date = date("Y-m-d"); //Current date

    
    //Check if email is in valid format 
    if (filter_var($em, FILTER_VALIDATE_EMAIL)) {

        $em = filter_var($em, FILTER_VALIDATE_EMAIL);

        //Check if email already exists 
        $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

        //Count the number of rows returned
        $num_rows = mysqli_num_rows($e_check);

        if ($num_rows > 0) {
            $error_code = "E100";

        }

    } else {
        $error_code = "E101";

    }

    if (strlen($fname) > 25 || strlen($fname) < 2) {
        $error_code = "E102";

    }

    if (strlen($lname) > 25 || strlen($lname) < 2) {
        $error_code = "E103";

    }

    if ($password != $password2) {
        $error_code = "E104";

    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            $error_code = "E105";

        }
    }

    if (strlen($password) > 30 || strlen($password) < 5) {
        $error_code = "E106";
        echo $password;

    }

    
    $pais = $_POST['pais'];
    $provincia = $_POST['provincia'];
    $ciudad = $_POST['ciudad'];

    if (empty($error_code)) {
        $password = md5($password); //Encrypt password before sending to database

        //$query = mysqli_query($con, "INSERT INTO users VALUES (NULL, '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

        $error_code = "E107";


        //Clear session variables 
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }

   

}

?>