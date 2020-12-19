<?php

$server     = "localhost";
$username   = "root";
$password   = "root";
$db         = "db_clientaddressbook1";

// create a connection

$conn = mysqli_connect( $server, $username, $password, $db );

// check the connection

if ( !$conn ){
    die( "connection failed: " . mysqli_connect_error() );
}

?>