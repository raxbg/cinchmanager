<?php
if(isset($_SESSION['LoggedIn']))
{
    $message="";
    $dbHandler=new dbHandler();
    $dbHandler->dbConnect();

    $Tasks="";
    $UserID = mysql_real_escape_string($_SESSION['userinfo'][ID]);
    //trqbva da opravq zaqvkata da ne vry6ta li4nite zada4i koito sa za nqkoi drug i na klientite da im pokazva samo tehnite li4ni i publi4nite
    //liderite na proekta trqbva da vijdat vsi4ko za nego
    //zavyr6enite zada4i ne trqbva da se pokazvat
    $query="SELECT Tasks.ID, Tasks.Priority, Projects.Name AS Project, Tasks.ShortDescription, Tasks.Deadline, Tasks.Status
            FROM ProjectsAndMembers
            LEFT JOIN Projects ON Projects.ID = ProjectsAndMembers.ProjectID
            LEFT JOIN Tasks ON Tasks.ProjectID = ProjectsAndMembers.ProjectID
            WHERE ProjectsAndMembers.UserID = {$UserID}
            ORDER BY Tasks.Priority ASC";
    $result = $dbHandler->ExecuteQuery($query);
    while($Task = mysql_fetch_array($result))
    {
        if ($i%2==0)
        {
            $class="class=\"odd ActiveField\"";
        }
        else
        {
            $class="class=\"even ActiveField\"";
        }
        $i++;

        $Tasks.="<tr {$class} onClick=\"PopUpBox('./Task.php?id={$Task['ID']}')\">".
                    "<td>{$Task['Project']}</td>\n".
                    "<td>{$Task['ShortDescription']}</td>\n".
                    "<td>{$Task['Deadline']}</td>\n".
                    "<td>{$Task['Status']}%</td>\n".
                    "</tr>";
    }
    $dbHandler->dbDisconnect();
    unset($dbHandler);
?>
<h1><?php echo TASKS_TEXT; ?></h1>
<table class="cooltable">
    <thead>
        <tr>
            <td><?php echo PROJECT1_TEXT; ?></td>
            <td><?php echo SHORT_DESCRIPTION1_TEXT; ?></td>
            <td><?php echo DEADLINE1_TEXT; ?></td>
            <td><?php echo STATUS_TEXT; ?></td>
        </tr>
    </thead>
    <tbody>
        <?php echo $Tasks; ?>
    </tbody>
</table>

<?php
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";
}
?>
