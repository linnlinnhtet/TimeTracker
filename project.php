<?php
include ("inc/header.php");
require ("inc/function.php");

$title = $category ='';

if (isset($_GET['id'])){
    list($project_id, $title, $category) = get_project(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $project_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $category = trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING));
    if (empty($title) || empty($category)){
        $error_message  = 'Please fill in the required fields: Title, Category';
    } else {
        if(add_project($title,$category, $project_id)){
            header('location: project_list.php');
            exit;
        } else {
            $error_message = "Could not add project";
        }
    }
}
?>
<div class='container text-center mt-5 mb-5'>
    <h1><?php
    if (!empty($project_id)){
        echo "Updating";
    } else {
        echo "ADD";
    } ?>  Projects</h1>
    <?php
        if (isset($error_message)){
            echo "<p class='message'> $error_message </p>";
        }
    ?>
    <form method="post" class="myform pt-5" action="project.php">
        <table class="table">
        <tbody>
        <tr>
        <th scope="row">Title *</th>
        <td>
            <input type="text" class="form-control" value="<?php echo $title;?>" name="title" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </td>
        </tr>
        <tr>
            <th scope="row">Categroy *</th>
        <td>
            <select class="custom-select" name="category" id="inputGroupSelect01">
                <option selected>Select One</option>
                <option value="Billable"<?php
                if ($category == 'Billable'){
                    echo 'selected';
                }
                ?>>Billable</option>
                <option value="Charity"<?php
                if ($category == 'Charity'){
                    echo 'selected';
                }
                ?>>Charity</option>
                <option value="Personal"<?php
                if ($category == 'Personal'){
                    echo 'selected';
                }
                ?>>Personal</option>
        </select>
        </td>
        </tbody>
        </table>
        <?php
        if ($project_id){
            echo '<input type="hidden" name="id" value="'.$project_id .'" />';
        }
        ?>

        <input type="submit" class="btn btn-lg btn-block" valeu="Submit" />
    </form>
</div>
<?php
include ("inc/footer.php");
?>