<?php
require('./inc/functions.php');
require_once('./inc/db.php');

$stmt = $db->query('select * from entries');
$articles = $stmt->fetchAll();


require_once('./inc/header.php');
?>

<section>
    <div class="container">
        <div class="entry-list">
            <?php
            foreach ($articles as $a) {
                $dateString = dateString($a['date']);
                echo "
                        <article>
                            <h2><a href='detail.php?id=$a[id]'>$a[title]</a></h2>
                            <time datetime='$a[date]'>$dateString</time>
                        </article>";
            }
            ?>

        </div>
    </div>
</section>
<?php require_once('./inc/footer.php');
