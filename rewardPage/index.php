<!DOCTYPE html>
<html>

<head>
    <title>Reward content</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="chatbot/style.css">
    <link rel="stylesheet" href="../WebStyle/mystyle.css">
    <?php include('../includes/navigationList.php'); ?>
</head>
<style>
    @keyframes appear{
        from{
            opacity:0;
            scale:0.5;
            clip-path: insert(100% 100% 0 0);
        }
        to{
            opacity:1;
            clip-path: insert(0 0 0 0);
        }
    }
.javaromareward{
    animation: appear linear;
    animation-timeline: view();
    animation-range: entry 0% cover 40%;
}

</style>

<body>
    <section id="Downloadapps">
        <div class="downloadapps">
            <img src="../images/JavaRomaApps.png" width="500" height="200" class="javaromaapp">
        </div>
    </section>

    <section id="reward1">
        <div class="rewardOne">
        <img src="../images/reward1.png" width="500" height="200" class="javaromareward">
        </div>
    </section>
</body>

</html>