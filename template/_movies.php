<?php 
    $query = mysqli_query($db, "SELECT * FROM `movies` {$where}");
    while($row = mysqli_fetch_array($query)){ 
        $kinopoiskId = $row['kinopoiskId'];
?>
    <div class="movieItem">
        <a href="film/<?=$row['kinopoiskId']?>" class="moviePreview">
            <span class="rating"><?=$row['ratingKinopoisk']?></span>
            <div class="genreMask">
                <p>
                    <?php 
                    $queryGenres = mysqli_query($db, "SELECT * FROM `genres` WHERE `kinopoiskId` = '$kinopoiskId'"); 
                    while($rowGenre = mysqli_fetch_array($queryGenres)){
                        echo $rowGenre['genre'].", ";
                    }
                    ?>
                </p>
            </div>
            <img src="<?=$row['posterUrlPreview'];?>" alt="">
        </a>
        <div class="movieInfo">
            <a href="#" data-id="<?=$row['id']?>" class="btnView">Будем смотреть</a>
            <h2><?=$row['nameRu']?></h2>
            <p><?=$row['year']?></p>
        </div>
    </div>
<?php } ?>
<script>
    var btnView = document.getElementsByClassName("btnView");
    for (var i = 0; i < btnView.length; i++) {
        btnView[i].addEventListener('click', function(e) {
            e.preventDefault();
            var id = this.getAttribute("data-id");
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../template/save_movie.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    var button = e.target;
                    if (response === "success") {
                        button.textContent = "В избранном";
                        button.classList.add("added");
                        button.disabled = true;
                    } else if (response === "removed") {
                        button.textContent = "Будем смотреть";
                        button.classList.remove("added");
                        button.disabled = false;
                    }
                }
            };
            xhr.send("id=" + id);
        });
    }
</script>