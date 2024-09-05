<?php include('header.php');?>


<div class="article-container">
    <?php if(isset($_POST['submit-search'])){
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        if(empty($search)){
            include('index.php');
        }
        else{
            $sql = "SELECT*FROM store WHERE area LIKE '%$search%' OR details LIKE '%$search%'";
            $result = mysqli_query($conn, $sql);
            $queryResults = mysqli_num_rows($result);

            if($queryResults > 0){
                echo"<div class='map'>
                    <img src='../images/map.png' alt='mapJavaRoma'>
                    </div>";
                while($row = mysqli_fetch_assoc($result)){
                    include('../includes/navigationList.php');
                    echo"<div class='article-box'>
                    <h3>".$row['name']."</h3>
                    <p>".$row['area']."</p>
                    <p>".$row['details']."</p>
                    <img src='".($row['images'])."' alt='Store Image'>
                    </div>";
                }
        }
        else{
            include('index.php');
        }
     }
        

        
}
?>
</div>