<?php
include ("inc/header.php");
$filter = 'all';
if (!empty($_GET['filter'])){
    $filter = explode(':', filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING));
}

require ("inc/function.php");
?>
<div class="container mt-5 mb-5">
    <div class="reports">
        <h1 class="text-center">Reports on <?php
            if (!is_array($filter)){
                echo "All Tasks by Project";
            } else {
                echo ucwords($filter[0]) . ":";
                switch ($filter[0]){
                    case 'projects':
                        $project = get_project($filter[1]);
                        echo $project;
                        break;
                    case 'category':
                        echo $filter[1];
                        break;
                    case 'date':
                        echo $filter[1];
                }
            }
        ?></h1>
        <div class="form-container">
             <form class="form-reports" action="report.php" method="get">
                <label for='filter'>Filter:</label>
                <select id='filter' name='filter' class='form-control form-control-lg'>
                    <option value=''>Select One</option>
                        <optgroup label='project'>
                            <?php 
                                foreach (get_project_list() as $item){
                                    echo '<option value="project:' . $item['project_id'] .'">';
                                    echo $item['title'] ."</option>\n";
                                }
                                    ?>
                        </optgroup>
                        <optgroup label='category'>
                            <option value="category:Billable">Billable</option>
                            <option value="category:Charity">Charity</option>
                            <option value="category:Personal">Personal</option>
                        </optgroup>
                        <optgroup label='date'>
                            <option value="date:
                            <?php 
                                echo date('m/d/Y', strtotime('-2 Sunday'));
                                echo ":";
                                echo date('m/d/Y', strtotime('-1 Saturday'));
                            
                            ?>">Last Week</option>
                            <option value="date:
                            <?php 
                                echo date('m/d/Y', strtotime('-1 Sunday'));
                                echo ":";
                                echo date('m/d/Y');
                            ?>">This Week</option>
                            <option value="date:
                            <?php 
                                echo date('m/d/Y', strtotime('first day of last month'));
                                echo ":";
                                echo date('m/d/Y', strtotime('end day of last month'));
                            ?>">Last Month</option>
                            <option value="date:
                            <?php 
                                echo date('m/d/Y', strtotime('first day of this month'));
                                echo ":";
                                echo date('m/d/Y');
                            ?>">This Month</option>
                        </optgroup>

                    <input classs="btn btn-lg btn-block" type="submit" value="Run" />
                </select>
           </form>
        </div>
        <div class="reports-list ">
            <table>
                <?php
                $total = $project_id = $project_total = 0;
                $tasks = get_task_list($filter);
                foreach ( $tasks as $item){
                    if ($project_id != $item['project_id']){
                        $project_id = $item['project_id'];
                        echo "<thead>\n";
                        echo "<tr>\n";
                        echo "<th>" . $item['project'] ."</th>\n";
                        echo "<th> Date</th>\n";
                        echo "<th> Time </th>\n";
                        echo "</tr>\n";
                        echo "</thead>\n";
                    }
                    $project_total += $item['time'];
                    $total += $item['time'];
                    echo "<tr>\n";
                    echo "<td>". $item['title'] . "</td>\n";
                    echo "<td>". $item['date'] . "</td>\n";
                    echo "<td>". $item['time'] . "</td>\n";
                    echo "</tr>\n";
                    if (next($tasks)['project_id'] != $item['project_id']) {
                        echo "<tr>\n";
                        echo "<th class='project_total_label' colspan='2'>Project Total </th>\n";
                        echo "<th class='project_total_number'> $project_total </th>\n";
                        echo "</tr>\n";
                        $project_total=0;
                    }
                }
                ?>
                <tr>
                    <th class="grand-total-lable" colspan="2">Grand Total</th>
                    <td class="grand-total-number"><?php echo $total;?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
include ("inc/footer.php");
?>