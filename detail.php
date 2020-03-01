<?php
require('./inc/functions.php');
require_once('./inc/db.php');

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $db->prepare('select * from entries where id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    die('No journal entry selected');
}
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
            <div class="entry-list single">
                <article>
                    <h1><?php echo $article['title']; ?></h1>
                    <time datetime="<?php echo $article['date']; ?>"><?php echo dateString($article['date']); ?></time>
                    <div class="entry">
                        <h3>Time Spent: </h3>
                        <p><?php echo $article['time_spent']; ?></p>
                    </div>
                    <div class="entry">
                        <h3>What I Learned:</h3>
                        <p><?php echo $article['learned']; ?></p>
                    </div>
                    <?php
                    if (!empty($article['resources'])) { ?>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <ul>
                                <?php
                                foreach ($article['resources'] as $re)
                                    echo "<li><a href=''>$re</a></li>";
                                ?>
                                <!-- <li><a href="">Cras accumsan cursus ante, non dapibus tempor</a></li>
                            <li>Nunc ut rhoncus felis, vel tincidunt neque</li>
                            <li><a href="">Ipsum dolor sit amet</a></li> -->
                            </ul>
                        </div>
                    <?php }; ?>
                </article>
            </div>
        </div>
        <div class="edit">
            <p><a href="edit.php?id=<?php echo $article['id']; ?>">Edit Entry</a></p>
        </div>
    </section>
    <footer>
        <div>
            &copy; MyJournal
        </div>
    </footer>
</body>

</html>