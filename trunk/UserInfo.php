<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['EmployeeOrClient'] == "e")
{
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $id=mysql_real_escape_string($_GET['id']);
    $query="SELECT Users.ID, Titles.Title, Users.FirstName,Users.SecondName, Users.LastName,Users.Telephone,
                Users.Email, Users.Address, Branches.Name AS Branch, Positions.Position
                FROM Users
                LEFT JOIN Employees
                ON Users.ID = Employees.UserID
                LEFT JOIN Positions ON Employees.PositionID = Positions.ID
                LEFT JOIN Branches ON Users.BranchID = Branches.ID
                LEFT JOIN Titles ON Users.TitleID = Titles.ID
                WHERE Users.ID ={$id}";
    $result = $dbHandler->ExecuteQuery($query);
    $User=mysql_fetch_array($result);
    $Salaries="";
    $query="SELECT * FROM Salaries WHERE UserID ={$id}";
    $result = $dbHandler->ExecuteQuery($query);
    while($salary = mysql_fetch_array($result))
    {
        if ($i%2==0)
        {
            $class="class=\"odd\"";
        }
        else
        {
            $class="class=\"even\"";
        }
        $i++;

        $Salaries.="<tr {$class}><td>{$salary['Amount']}</td>\n".
                    "<td>{$salary['FromDate']}</td>\n".
                    "<td>{$salary['ToDate']}</td>\n".
                    "</tr>";
    }

    $Projects="";
    $query="SELECT Projects.ID, Projects.Name, ProjectsAndMembers.IsOwner, ProjectsAndMembers.IsLeader,
            Projects.StartDate, Projects.Status FROM ProjectsAndMembers 
            LEFT JOIN Projects ON Projects.ID = ProjectsAndMembers.ProjectID
            Where UserID={$id}";
    $result = $dbHandler->ExecuteQuery($query);
    while($project = mysql_fetch_array($result))
    {
        if ($i%2==0)
        {
            $class="class=\"odd\"";
        }
        else
        {
            $class="class=\"even\"";
        }
        $i++;

        $Projects.="<tr {$class}><td>".
                    "<a href=\"index.php?page=MembersOfProject&id={$project['ID']}\">{$project['Name']}</a></td>\n".
                    "<td>{$project['StartDate']}</td>\n".
                    "<td>{$project['Status']}</td>\n".
                    "</tr>";
    }
    $dbHandler->dbDisconnect();
    unset($dbHandler);
?>
    <div class="UserInfo">
        <!-- TRqbva da ima proverka dali faila sy6testvuva -->
        <img alt="<?php echo $User['FirstName']." ".$User['LastName']; ?>" src="avatars/user_<?php echo $User['ID']; ?>.jpg" />
        <h2 id="name">
            <?php echo $User['Title']." ".$User['FirstName']." ".$User['SecondName']." ".$User['LastName']; ?>
        </h2>
        <span><b><?php echo $User['Position'];?></b> <?php echo AT_TEXT." ".COMPANY_NAME." ".$User['Branch'];?></span>
        <div id="contacts">
            <?php 
            if($User['Telephone']!=null)
            {
                echo "<b>".TELEPHONE_TEXT."</b> {$User['Telephone']}<br />";
            }
            if($User['Email']!=null)
            {
                echo "<b>".EMAIL_TEXT."</b> {$User['Email']}<br />";
            }
         ?>
        </div>
        <?php if($User['Address']!=null){ ?>
        <div id="address">
            <h4><?php echo ADDRESS_TEXT; ?></h4>
            <?php echo $User['Address']; ?>
        </div>
        <?php } ?>
        <?php if((($_SESSION['userinfo']['EmployeeOrClient']=='e')||($_GET['id']==$_SESSION['userinfo']['ID']))&&($Projects!="")){?>
        <h3>Projects</h3>
        <table class="cooltable">
            <thead>
                <tr>
                    <td>Project name</td>
                    <td>Start date</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <?php echo $Projects; ?>
            </tbody>
        </table>
        <?php } ?>
        <?php if((User::IsXManagerOfY($_GET['id'],$_SESSION['userinfo']['ID'])||$_GET['id']==$_SESSION['userinfo']['ID'])&&($Salaries!="")){?>
            <h3><?php echo SALARY_TEXT; ?></h3>
            <table class="cooltable">
                <thead>
                    <tr>
                        <td><?php echo SALARY1_TEXT; ?></td>
                        <td><?php echo FROM_DATE1_TEXT; ?></td>
                        <td><?php echo TO_DATE_TEXT; ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $Salaries; ?>
                </tbody>
            </table>
        <?php } ?>

        <h3>Payments</h3>
        <table class="cooltable">
            <thead>
                <tr>
                    <td>Sum</td>
                    <td>Date</td>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td>100</td>
                    <td>24.01.2011</td>
                </tr>
                <tr class="even">
                    <td>250</td>
                    <td>15.02.2011</td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}
elseif(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['EmployeeOrClient'] == "c")
{
    echo NOT_ALLOWED_TO_ACCESS_INFO_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>