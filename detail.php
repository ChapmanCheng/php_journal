<?php
require('./inc/functions.php');
require_once('./inc/db.php');

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        $stmt = $db->prepare('select * from entries where id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch();
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else
    header('Location: /');


require_once('./inc/header.php');
?>

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
                            foreach ($article['resources'] as $resource)
                                echo "<li><a href=''>$resource</a></li>";
                            ?>
                        </ul>
                    </div>
                <?php }; ?>
            </article>
        </div>
    </div>
    <div class="edit">
        <p><a href="edit.php?id=<?php echo $article['id']; ?>">Edit Entry</a></p>
        <p><a href="edit.php?delete=1&id=<?php echo $article['id']; ?>">Delete Entry</a></p>
    </div>
</section>
<?php require_once('./inc/footer.php');
