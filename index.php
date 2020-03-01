<?php
require_once('./inc/db.php');

$stmt = $db->query('select * from entries');
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MyJournal</title>
    <link href="https://fonts.googleapis.com/css?family=Cousine:400" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/site.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="site-header">
                <a class="logo" href="index.html"><i class="material-icons">library_books</i></a>
                <a class="button icon-right" href="new.html"><span>New Entry</span> <i class="material-icons">add</i></a>
            </div>
        </div>
    </header>
    <section>
        <div class="container">
            <div class="entry-list">
                <?php
                foreach ($articles as $a) {
                    $dateString = date('F d, Y', strtotime($a['date']));
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
    <footer>
        <div>
            &copy; MyJournal
        </div>
    </footer>
</body>

</html>