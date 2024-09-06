<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>User Profile</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../WebStyle/mystyle.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='profile.css'>
</head>
<body>
    <?php include('../includes/navigationList.php'); ?>
    <h1>User Profile</h1>
    <form action='profile.php' method='post'>
        <label for='name'>Name:</label>
        <input type='text' name='name' id='name'>
        <label for='email'>Email:</label>
        <input type='text' name='email' id='email'>
        <label for='password'>Password:</label>
        <input type='password' name='password' id='password'>
        <button type='submit' class='login-btn'>Save Changes</button>
    </form>


    <?php include('../includes/footerPolicy.php'); ?>
</body>
</html>