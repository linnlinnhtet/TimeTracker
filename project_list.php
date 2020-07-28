<?php
include ("inc/function.php");
include ("inc/header.php");

if(isset($_POST['delete'])){
    if (delete_project(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT))){
    header('location: project_list.php?msg=Project+Deleted');
    exit;
} else{
    header('location: project_list.php?msg=Unable+to+Delete+Project');
    exit;
 }
}
if (isset($_GET['msg'])){
    $error_message = trim(filter_input(INPUT_GET, 'msg', FILTER_SANITIZE_STRING));
}
?>
<div class='container text-center mt-5 mb-5'>
    <div class='row'>
        <div class='col-12'>
        <img src='project.png' alt='addproject'>
        <a href='project.php'>Add Project</a>
    </div>
    </div>
    <?php
        if (isset($error_message)){
        echo "<p class='message'> $error_message </p>";
    }
    ?>
    <div class="form-container mt-5">
        <ul class="items">
            <?php 
            foreach (get_project_list() as $items){
                echo "<li><a href='project.php?id=" . $items['project_id'] ."'>" .$items['title']."</a>";
                    echo "<form method='post' action='project_list.php' onsubmit=\"return confirm('Are you sure you want to delete this project?');\">\n";
                    echo "<input type='hidden' value='". $items['project_id'] . "' name='delete' />\n";
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
