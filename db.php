<?php

$conn = mysqli_connect(
    "127.0.0.1",
    "root",
    "",
    "restaurant_db",
    3307
);

if(!$conn){
    die("Connection failed : " . mysqli_connect_error());
}

?>