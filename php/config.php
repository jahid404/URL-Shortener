<?php 

    $domain = "http://aitoolscollection.epizy.com/URLShortener2/";
    $host = "sql111.epizy.com";
    $user = "epiz_33268459"; 
    $pass = "ts8wgZvh19lp";
    $db = "epiz_33268459_urlshortener2";

    $conn = mysqli_connect($host, $user, $pass, $db);
    if(!$conn){
        echo "Database connection error".mysqli_connect_error();
    }
?>