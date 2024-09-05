<!DOCTYPE html>
<html>
    <head><title>Search a store</title>
    <link rel="stylesheet" href="../WebStyle/mystyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<section id="findbranch">
<div class="branch">
<h1>Find the nearest "JavaRoma"! Sleep</h1>
<img src="../images/branch.png">
</div>
<?php include('../includes/navigationList.php');?>
<?php include ('header.php');?>
<div class="search">
<form action="search.php" method="POST">
    <input type="text" name="search" placeholder="Find a store">
    <button type="submit" name="submit-search">Search</button>
</form>
</div>
</section>
<?php include('../includes/footerPolicy.php'); ?>
</body>
</html>