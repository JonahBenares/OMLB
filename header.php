<?php
session_start();
if(empty($_SESSION)) echo "<script>alert('You are not logged in. Please login to continue.'); window.location='index.php';</script>";
?>

<!doctype html>
<html><head>
    <meta charset="utf-8">
    <title>Operations and Maintenance Logbook </title>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="CENPRI">
    <link rel="icon" href="images/oplogo.png">

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    

    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-style.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <link href="css/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/css/font-awesome.css" rel="stylesheet">

<!--     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.7.3/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->
    

    <script type="text/javascript" src="js/jquery.js"></script>       
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="js/gauge.js"></script>	
	<script src="js/jquery.flexslider.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/admin.js"></script>   
    <link href="css/header.css" rel="stylesheet">
   


  </head>