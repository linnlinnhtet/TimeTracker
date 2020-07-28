<?php
include ("inc/header.php");
require ("inc/function.php");
$project_id = $title = $date = $time= ''; 
if (isset($_GET['id'])){
    list($task_id, $title, $date, $time, $project_id) = get_task(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}
$project_id = $title = $date = $time = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $task_id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_NUMBER_INT);
    $project_id = trim(filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_NUMBER_INT));
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT));

    $dateMatch = explode('/', $date);

    if (empty($project_id) || empty($title) || empty($date) || empty($time) ){
        $error_message  = 'Please fill in the required fields: Project_id, Title, Data, Time';
    } else if(count($dateMatch) != 3 || strlen($dateMatch[0]) != 2
                                     || strlen($dateMatch[1]) != 2
                                     || strlen($dateMatch[2]) != 4
                                     || !checkdate($dateMatch[0], $dateMatch[1], $dateMatch[2])) {
        $error_message = 'Invaid Date';

    }  else {
        if(add_task($project_id, $title, $date, $time,$task_id)){
            header('location: task_list.php');
            exit;
        } else {
            $error_message = "Could not add task";
        }
    }
}
?>
 <div class="container text-center mt-5 mb-5">
    <h1><?php
    if(!empty($task_id)){
        echo "Updating";
    }else{
        echo "ADD";
    }?>
      TASK</h1>
        <?php
        if (isset($error_message)){
            echo "<p class='message'> $error_message </p>";
        }
    ?>
    <form method="post" action="task.php" class="myform pt-5">
        <table class="table">
            <tbody>
                <tr>
                <th scope="row">Project *</th>
                    <td>
                        <select class="custom-select" name="project_id" id="inputGroupSelect01">
                            <option value="">Select one</option>
                            <?php 
                            foreach (get_task_list() as $items){
                                echo "<option value='". $items['project_id']. "'";
                                if($project_id = $items['project_id']){
                                    echo 'selected';
                                }
                                echo ">"
                                .$items['title']."</option>";
                            }
                            ?>
                        </select>
                    </td>
                <tr>
                    <th scope="row">Title *</th>
                    <td>
                    <input type="text" name="title" value="<?php echo $title; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Date *</th>
                    <td>
                        <input type="text" name="date" value="<?php echo $date; ?>" class="form-control" placeholder="mm/dd/yy" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Time *</th>
                    <td>
                        <input type="text" name="time" value="<?php echo $time; ?>" class="form-control time" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"> <span class="minute">minutes</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
        if($task_id){
            echo '<input type="hidden" name="id" value="'. $task_id .'" />';
        }
        ?>
        <input type="submit" class="btn btn-lg btn-block" value="Submit"/>
    </form>
 </div>
 <?php
include ("inc/footer.php");
?>