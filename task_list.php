<?php
include ("inc/function.php");

if(isset($_POST['delete'])){
    if (delete_task(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))){
    header('location: task_list.php?msg=Task+Deleted');
    exit;
} else{
    header('location: task_list.php?msg=Unable+to+Delete');
    exit;
 }
}
if (isset($_GET['msg'])){
    $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
}

include ("inc/header.php");
?>

 <div class="container text-center mt-5 mb-5">
    <div class="row">
        <div class="col-12">
        <img src="task-icon-55.png" alt="addtasks">
        <a href="task.php">Add Task</a>
        </div>
    </div>
    <?php
    if (isset($error_message)){
        echo "<p class='message'> $error_message </p>";
    }
    ?>
    <div class="form-container">
        <ul class="items">
            <?php 
                foreach (get_task_list() as $items){
                    echo "<li><a href='task.php?id=". $items['task_id'] . "'>" .$items['title'] ."</a>";
                    echo "<form method='post' action='task_list.php' onsubmit=\"return confirm('Are you sure you want to delete this task?');\">\n";
                    echo "<input type='hidden' value='". $items['task_id'] . "' name='delete' />\n";
                    echo "<input type='submit' class='delete' value='Delette' />\n";
                    echo "</form>";
                    echo "</li>";
                }
            ?>
        </ul>
    </div>
 </div>
 <?php
include ("inc/footer.php");
?>
