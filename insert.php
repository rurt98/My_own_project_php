<?php

session_start();

// include to database
include ('includes/connection.php');

// include to function file
include ('includes/functions.php');

if ( isset( $_POST['singUp'] ) ) {

    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function

    // set all variable to empty by default

    $email = $name = $password = "";

    if( !$_POST["email"] ) {
        $emailError = "Please enter usersname <br>";
    } else {
        $email = validateFormData( $_POST["email"] );

    }


    if ( !$_POST["name"] ){
        $nameError = "please enter your name <br>";
    } else {
        $name = validateFormData( $_POST["name"] );
    }


    if ( !$_POST["password"]){
        $passwordError = "please enter a pasword <br>";
    } else {
        $password = validateFormData( $_POST["password"] );
    }

    $password = password_hash($password, PASSWORD_BCRYPT);



    if ($email && $name && $password ) {



        // query contra la database, select all where email is igual a ?
        $check_duplicate_email = "SELECT email FROM users WHERE email = '$email'";

        // store the result
        $result = mysqli_query($conn, $check_duplicate_email);
        // if existe mas de 0 resultados, es que el email ya esta alli
       $count=mysqli_num_rows($result);
        if($count > 0){


   echo "<h1>Email already exist try again!</h1>";
   echo " <div>
        <a href=\"insert.php\"</a>
      <button type=\"submit\" class=\"btn btn-lg btn-success pull-right\" name=\"goBack\">Try again</button>
    </div>";

      return false;
        }

            $query = "INSERT INTO users (id, email, name, password) VALUES (NULL, '$email', '$name', '$password')";

            $result = mysqli_query($conn, $query);


            $_SESSION['loggedInUser'] = $password;

            if ($result) {

                header("location: clients.php?alert=singUp");
            } else {

                echo "Error" . $query . "<br>" . mysqli_error($conn);
            }



    }
}

mysqli_close($conn);

include('includes/header.php');

?>

<h1>Client Address Book</h1>
<p class="lead">Sing Up.</p>
<p class="text-danger">* Required fields</p>



<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">


    <small class="text-danger">* <?php echo $emailError; ?></small>
    <input type="text" placeholder="email" name="email"><br><br>

    <small class="text-danger">* <?php echo $nameError; ?></small>
    <input type="text" placeholder="name" name="name"><br><br>

    <small class="text-danger">* <?php echo $passwordError; ?></small>
    <input type="password" placeholder="password" name="password"><br><br>

    <button type="submit" class="btn btn-primary" name="singUp">Sing Up</button>
</form>

<?php
include('includes/footer.php');
?>
