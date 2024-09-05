<!DOCTYPE html>
<html>

<head>
    <title>Home page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="WebStyle/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="chatbot/style.css">
</head>

<body>
    <?php include('includes/navigationList.php'); ?>

    <section id="slogan">
        <div class="video-container">
            <div class="videoSrc">
                <video autoplay loop muted>
                    <source src="slogan.mp4" type="video/mp4" />
                    <source src="slogan.ogg" type="video/ogg" />
                </video>
            </div>
        </div>
    </section>
    <section id="latestrelease">
        <div class="slider-frame">
            <div class="slide-images">
                <div class="img-container">
                    <a href="#">
                        <img src="images/JavaRomacoffee.png" alt="promotion1"></a>
                </div>
                <div class="img-container">
                    <a href="#">
                        <img src="images/Collaboration.png" alt="promotion2"></a>
                </div>
                <div class="img-container">
                    <a href="#">
                        <img src="images/getapps.png" alt="promotion3"></a>
                </div>
            </div>
        </div>
    </section>

    <section id="brandintroduction" class="show-animate">
        <div class="introbackground">
            <img src="images/companyintro.png">
            <div class="companylogoword">
                <img src="JavaRomaLogo.png" width="500" height="200" class="javaromalogo">
            </div>
        </div><br>
        <p class="paragraph">hhh The history of the coffee brand JavaRoma is extensive and inspirational. JavaRoma,
            which was founded in 2018 by a Malaysian girl who studied in Italy, is an embodiment of the merging of
            Malaysian entrepreneurial energy with Italian coffee traditions. The brand's aim is to convey the fragrant
            essence of coffee ("Java") and the romanticism of Italian coffee culture ("Roma"). This is reflected in the
            name "JavaRoma".
            <br><br>
            JavaRoma has expanded since its founding thanks to the cautious direction of a committed management group.
            They have put in
            countless hours to uphold the brand's dedication to excellence, making sure that each cup of coffee is of
            the greatest caliber.
            JavaRoma is a popular option among coffee lovers since the team is always looking for new and creative ways
            to develop and improve,
            whether it's by finding the best organic beans or improving the customer experience.
        </p>
    </section>

    <script src="script.js"></script>

    <section id="aboutus">
        <img src="images/aboutus.png" alt="" class="aboutusimg">
        <div class="fadein">
            <div class="aboutUs">
                <h1>About us</h1><br>
                <button class="btn-founder" onclick="window.location.href='founderNaboutus/index.php';">More
                    details</button>
            </div>
            <div class="founder">
                <h1>"Drink and Discover"</h1>
                <img src="images/company.png" alt="company image" class="company">
                <p class="introduceFounder">Welcome to <span style="color:brown">"JavaRoma"</span>
                    where every cup is a story of passion, quality, and sustainability.
                    We believe that the journey to the perfect cup of coffee begins with the finest ingredients. </p>
            </div>
        </div>
    </section>

    <div id="chatbot">
        <?php include("chatbot/index.php"); ?>
    </div>

    <script src="chatbot/script.js"></script>

    <?php include('includes/footerPolicy.php'); ?>

</body>

</html>



<!-- <br>


<br>

<div class="collaboration">
<a href="/Web/contentPage"><img src="Collaboration.png"></a></li> 
</div>


<div class="coffeeIntro">
    <div clss="titleIntro">
        <h2>What bean we used?</h2>
    </div>
<pre class ="introduction">
Welcome to [Your Company Name] 
where every cup is a story of passion, quality, and sustainability.
We believe that the journey to the perfect cup of coffee begins with the finest ingredients. 
That's why we carefully source our coffee beans from the world's most 
renowned coffee-growing regions, selecting only the highest quality beans 
that are cultivated with care and expertise. Our beans are 100% organic,
grown without the use of synthetic fertilizers or pesticides, 
ensuring that every sip is not only delicious but also healthy and environmentally friendly.
</pre>
</div>

<div class="video-container">
  <div class="videoSrc">
<video width="1600" height="500" autoplay loop muted>
    <source src="coffeeVideo.mp4" type="video/mp4" />
    <source src="coffeeVideo.ogg" type="video/ogg" />
</video>
</div>  
</div>
<h2>Our Company Name</h2>
<img src="images/CompanyLogo.jpg" width="230" height="230">
<p>The introduction of company<b>
    our goals, mission and vision.</b><br>
    MA Me Mi Mo Mu.
    <br><h1>Tham Lai Yee</h1>
    <b>The founder</b>
</p>
<br>

<div class="socialMedia">
    <div class="header">
    <h3>Follow us</h3>
    </div>
    
    <div class="icon">
        <div class="facebook">
           <img src="images/facebookPage.png"> 
        </div>
        
        <div class="instagram">
        <img src="images/insPage.png">
        </div>

        <div class="youtube">
        <img src="images/youtube.png">
        </div>    

    </div>
</div>
<br>
<div class="footer-container">
    <div class="footer-background">
    <div class="footer-content">
        <?php include('includes/footer.php'); ?>
        <?php include('includes/footerPolicy.php'); ?>
    </div>
</div> -->