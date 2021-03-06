<?php

require('./inc/Form.php');
require('./inc/functions.php');
require_once('./inc/db.php');
$actionURL =  $_SERVER['PHP_SELF'];

$form = new Form();

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $actionURL .= "?id=$id";

    // get data from database
    if (empty($_POST)) {
        try {
            $sql = 'SELECT * FROM entries where id = :id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        $form->insertData($data);
    }

    if (isset($_GET['delete']) && $_GET['delete']) {
        try {
            $sql = 'DELETE FROM entries WHERE id = :id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: /');
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}

if (!empty($_POST)) {
    // if user is redirected from submit w/ POST data
    $form->validateDate();
    if (!$form->isEmpty(['title', 'date', 'time_spent', 'learned'])) {

        if (isset($_GET['id'])) {
            // update post
            try {
                $sql = 'UPDATE entries 
                        SET title = :title, 
                            date = :date, 
                            time_spent = :time_spent, 
                            learned = :learned, 
                            resources = :resources
                        WHERE id = :id;';
                $stmt = $db->prepare($sql);

                $data = $form->getAssoArrayProps();
                $data['id'] = $id;
                $stmt->execute($data);
                header('Location: /');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            // create post
            try {
                $sql = 'INSERT INTO entries (title, date, time_spent, learned, resources)
                            VALUES (:title, :date, :time_spent, :learned, :resources)';
                $stmt = $db->prepare($sql);

                $stmt->execute($form->getAssoArrayProps());
                header('Location: /');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    } else
        $missingKey = $form->isEmpty(['title', 'date', 'time_spent', 'learned']);
}

require_once('./inc/header.php');
?>
<section>
    <div class="container">
        <div class="<?php echo isset($_GET['id']) ?  'edit-entry' : 'new-entry'; ?>">

            <h2><?php echo isset($_GET['id']) ?  'Edit Entry' : 'New Entry'; ?></h2>

            <?php if (isset($missingKey)) { ?>
                <!-- copy from w3schools  -->
                <!-- https://www.w3schools.com/howto/howto_js_alert.asp -->
                <div class='alert'>
                    <span class='closebtn' onclick='this.parentElement.style.display="none"'>&times;</span>
                    <?php echo "$missingKey cannot be empty"; ?>
                </div>
            <?php }; ?>

            <form method="POST" action="<?php echo $actionURL; ?>">

                <label for="title"> Title</label>
                <input id="title" type="text" name="title" <?php echo "value='$form->title'"; ?>><br>

                <label for="date">Date</label>
                <input id="date" type="date" name="date" <?php echo "value='$form->date'"; ?>><br>

                <label for="time-spent"> Time Spent</label>
                <input id="time-spent" type="text" name="time_spent" <?php echo "value='$form->time_spent'"; ?>><br>

                <label for="what-i-learned">What I Learned</label>
                <textarea id="what-i-learned" rows="5" name="learned"><?php echo $form->learned; ?></textarea>

                <label for="resources-to-remember">Resources to Remember</label>
                <textarea id="resources-to-remember" rows="5" name="resources"><?php echo $form->resources; ?></textarea>

                <input type="submit" value="Publish Entry" class="button">

                <a href="#" class="button button-secondary">Cancel</a>

            </form>
        </div>
    </div>
</section>

<?php require_once('./inc/footer.php');
