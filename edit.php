<?php

require('./inc/class/Form.php');
require('./inc/functions.php');
require_once('./inc/db.php');
$formURL =  $_SERVER['PHP_SELF'];

$j = new Form();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $formURL .= "?id=$id";

    // get data from database
    $sql = 'SELECT * FROM entries where id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $j->insertData($data);
}
// } else {

// if (Form::hasPostData()) {
// create new entry
//     $journal = new Form();
//     $journal->retrievePostData();
//     $journal->validateDate();
//     $journal->linkDatabase($db);

//     try {
//         $journal->createNewEntry();
//         header('Location: ' . '/php_journal');
//     } catch (Exception $e) {
//         die($e->getMessage());
//     }
// }

// if ($journal->checkExist(['title', 'date', 'time_spent', 'learned'])) {
/**
 * vardump
 * object(Form)#2 (5) { 
 *  ["title"]=> string(6) "foobar" 
 *  ["date"]=> string(10) "2020-03-03" 
 *  ["time_spent"]=> string(7) "3 hours" 
 *  ["learn"]=> string(7) "nothing" 
 *  ["resources"]=> string(0) "" }
 */

// if ($journal->checkExist(['title', 'date', 'time_spent', 'learned'])) {
//     $sql = 'INSERT INTO entries (title, date, time_spent, learned, resources)
//             VALUES (:title, :date, :time_spent, :learned, :resources)';
//     $stmt = $db->prepare($sql);
//     $stmt->execute($journal->data);
// $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
// $stmt->bindParam(':date', $data['date'], PDO::PARAM_STR);
// $stmt->bindParam(':time_spent', $data['time_spent'], PDO::PARAM_STR);
// $stmt->bindParam(':learnd', $data['learned'], PDO::PARAM_STR);
// $stmt->bindParam(':resources', $data['resources'], PDO::PARAM_STR);
// }
// }
require_once('./inc/header.php');
?>
<section>
    <div class="container">
        <div class="<?php echo isset($_GET['id']) ?  'edit-entry' : 'new-entry'; ?>">

            <h2><?php echo isset($_GET['id']) ?  'Edit Entry' : 'New Entry'; ?></h2>

            <form method="POST" action="<?php echo $formURL; ?>">

                <label for="title"> Title</label>
                <input id="title" type="text" name="title" <?php if (isset($j)) echo "value='$j->title'"; ?>><br>

                <label for="date">Date</label>
                <input id="date" type="date" name="date" <?php if (isset($j)) echo "value='$j->date'"; ?>><br>

                <label for="time-spent"> Time Spent</label>
                <input id="time-spent" type="text" name="time_spent" <?php if (isset($j)) echo "value='$j->time_spent'"; ?>><br>

                <label for="what-i-learned">What I Learned</label>
                <textarea id="what-i-learned" rows="5" name="learned"><?php if (isset($j)) echo $j->learned; ?></textarea>

                <label for="resources-to-remember">Resources to Remember</label>
                <textarea id="resources-to-remember" rows="5" name="resources"><?php if (isset($j)) echo $j->resources; ?></textarea>

                <input type="submit" value="Publish Entry" class="button">

                <a href="#" class="button button-secondary">Cancel</a>

            </form>
        </div>
    </div>
</section>

<?php require_once('./inc/footer.php');
