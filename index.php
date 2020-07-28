<?php
    include ("inc/header.php");
    echo "<div class='container text-center pt-5 pb-5'>";
        echo "<h1>Welcome</h1>";
        echo "<p class='text-dark'>What would You Like to do today? </p>";
        echo "<div class='row'>";
            echo "<div class='col-4'>";
                echo "<img src='task-icon-55.png' alt='addtasks'>";
                echo "<a href='task.php'>Add Task</a>";
            echo "</div>";
            echo "<div class='col-4'>";
                echo "<img src='project.png' alt='addproject'>";
                echo "<a href='project.php'>Add Project</a>";
            echo "</div>";
            echo "<div class='col-4'>";
                echo "<img src='report.png' alt='report'>";
                echo "<a href='report.php'>View Report</a>";
            echo "</div>";
        echo "</div>";
    echo "</div>";


    include ("inc/footer.php");
?>