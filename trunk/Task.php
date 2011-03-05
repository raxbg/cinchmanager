<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    if(isset($_GET['id'])&&$_GET['id']!="")
    {
        $dbHandler=new dbHandler();
        $dbHandler->dbConnect();
        $TaskID=mysql_real_escape_string($_GET['id']);
            $TaskQuery="SELECT Tasks.*, CONCAT(Users.FirstName,' ',Users.Lastname) AS User, Projects.Name AS Project
                        FROM Tasks
                        LEFT JOIN Users ON Users.ID = Tasks.UserID
                        LEFT JOIN Projects ON Projects.ID = Tasks.ProjectID
                        Where Tasks.ID = {$TaskID}";
            $TaskResult=$dbHandler->ExecuteQuery($TaskQuery);
            echo mysql_error();
            $Task=mysql_fetch_array($TaskResult);
            if($Task)
            {
                switch ($Task['Priority'])
                {
                    case 1:
                        $Priority = URGENT_TEXT;
                        break;
                    case 2:
                        $Prioriry = HIGH_PRIORITY_TEXT;
                        break;
                    case 3:
                        $Prioriry = NORMAL_PRIORITY_TEXT;
                        break;
                    case 4:
                        $Prioriry = LOW_PRIORITY_TEXT;
                        break;
                    case 5:
                        $Prioriry = LOWEST_PRIORITY_TEXT;
                        break;
                    default:
                        $Prioriry = NORMAL_PRIORITY_TEXT;
                }
                switch ($Task['Visibility'])
                {
                    case 1:
                        $Visibility = PRIVATE_TEXT;
                        break;
                    case 2:
                        $Visibility = INTERNAL_TEXT;
                        break;
                    case 3:
                        $Visibility = EVERYONE_TEXT;
                        break;
                    default:
                        $Visibility = "";
                }
?>
<div class="TaskHeader">
    <?php if($Task['Deadline']){ ?>
    <div>
        <span class="LittleText"><?php echo DEADLINE_TEXT; ?></span><br />
        <span><?php echo $Task['Deadline']; ?></span>
    </div>
    <?php }?>
    <div>
        <span class="LittleText"><?php echo PRIORITY_TEXT; ?></span><br />
        <span><?php echo $Prioriry; ?></span>
    </div>
    <div>
        <span class="LittleText"><?php echo ASIGNED_AT_TEXT; ?></span><br />
        <span><?php echo $Task['AssignmentTime']; ?></span>
    </div>
    <?php if($Task['DateFinnished']){ ?>
    <div>
        <span class="LittleText"><?php echo FINISHED_AT_TEXT; ?></span><br />
        <span><?php echo $Task['DateFinnished']; ?></span>
    </div>
    <?php }?>
    <div>
        <span class="LittleText"><?php echo PROJECT_TEXT; ?></span><br />
        <span><?php echo $Task['Project']; ?></span>
    </div>
    <?php if($Task['User']){ ?>
    <div>
        <span class="LittleText"><?php echo ASSIGNED_TO_TEXT; ?></span><br />
        <span><?php echo $Task['User']; ?></span>
    </div>
    <?php }?>
    <div>
        <span class="LittleText"><?php echo VISIBILITY_TEXT; ?></span><br />
        <span><?php echo $Visibility; ?></span>
    </div>
</div>
<div class="clearer"></div>
<h2><?php echo $Task['ShortDescription']; ?></h2>
<?php if($Task['Description']){ echo DESCRIPTION1_TEXT; ?>
<div class="Description"><?php echo $Task['Description']; ?></div>
<?php } ?>
<?php
                echo STATUS1_TEXT." {$Task['Status']}%";
                echo "<span onClick=\"PopUpBox('./EditTask.php?id={$Task['ID']}')\" class=\"right ActiveField\" >".EDIT_TEXT."</span>";
                ?><div class="clearer"></div><?php
            }
            else
            {
                echo "<span class=\"NegativeMessage\">".TASK_NOT_FOUND_TEXT."</span>";
            }
       
        $dbHandler->dbDisconnect();
        unset($dbHandler);
    }
    else
    {
        echo "<span class=\"NegativeMessage\">".TASK_NOT_FOUND_TEXT."</span>";
    }
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";
}
?>
