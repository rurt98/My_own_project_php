<?php

session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {

    // send them to the login page
    header("Location: index.php");
}


// connect to database
include('includes/connection.php');

// query & result
$query = "SELECT * FROM products" ;
$result = mysqli_query( $conn, $query );

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>


<h1>Products Book</h1>

<table class="table table-striped table-bordered">
    <tr>
        <th>Brand</th>
        <th>Ad</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>

    <?php


    if( mysqli_num_rows($result) > 0 ) {

        // we have data
        // output the data
        while ( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";

            echo "<td>" . $row ['brand'] . "</td><td>" . $row ['ad'] . "</td><td>" . $row ['notes'] ."</td>";

            echo '<td><a href="editProduct.php?id=' . $row ['id'] .'" type="button" class="btn btn-primary btn-sm">
             <span class="glyphicon glyphincon-edit"></span>
            </a></td>';

            echo "</tr>";
        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no Products!</div>";
    }

    mysqli_close($conn);

    ?>

    <tr>
        <td colspan="7"><div class="text-center"><a href="addproduct.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Products</a></div></td>
    </tr>
</table>

