<!DOCTYPE html>
<html>
<head>
    <title>Contact Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../WebStyle/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<?php include('../includes/navigationList.php');?>
<section id="contactPage">
    <div class="Contactbackground">
    <img src="../images/contactBackground.png">
</div>
</section>


<style>
        .error{
            color:red;
        }
        </style>
    <body>
    <?php
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $name = $_POST['name']??'';
            $email = $_POST['email']??'';
            $messages =$_POST['messages']??'';
        

        $errors=[];

        if(empty($name)){
            $errors['name'] ='Name is required';
        }else if(!preg_match("/^[a-zA-Z ]*$/",$name)){
            $errors['name'] = "Only alphabets and white space are allowed";
        }

        if(empty($email)){
            $errors['email'] = 'Email is required';
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'A valid email is required';
        }

        if(empty($messages)){
            $errors['messages'] = 'message is required';
        }

        if (empty($errors)) {
            include('database.php');
            // Process the input (send mail, etc.)
            // For example:
            header("Location: /Javaroma/index.php");

        } else {
            // Redisplay the form, with error messages
            include('form.php');
        }
    }
    else {
        // Display the form for the first time
        $name = $email = $messages = '';
        $errors = [];
        include('form.php');
    }
 
?>
<?php include('../includes/footerPolicy.php'); ?>
</body>
</html>