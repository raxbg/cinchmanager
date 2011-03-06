<?php
if(isset($_GET['id']) && $_GET['id'] != "")
{
    if(isset($_POST["Attach"]))
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $taskId = mysql_real_escape_string($_GET['id']);
        $userId = mysql_real_escape_string($_SESSION['userinfo']['ID']);
        $today = date("Y-m-d");
        foreach($_FILES as $file)
        {
            $destination = HOME_FOLDER."attachments/";
            $destinationFile = $destination.$taskId."_".$file["name"];
            $query = ""
            if(move_uploaded_file($file["tmp_name"], $destinationFile))
            {
                if($dbHandler->ExecuteQuery($query))
                $message = "<span class=\"PositiveMessage\">";
                $message.= ALL_FILES_UPLOADED_TEXT;
                $message.= "</span>";
            }
            else
            {
                $message = "<span class=\"NegativeMessage\">";
                $message.= FAILED_TO_UPLOAD_SOME_FILES_TEXT;
                $message.= "</span>";
            }
        }
        echo $message;

    }
    else
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $id = mysql_real_escape_string($_GET['id']);
        $i=0;
        $table = "<table class=\"cooltable\">\n";
        $table.= "<thead>\n";
        $table.= "    <tr>\n";
        $table.= "        <td>".FILENAME_TEXT."</td>\n";
        $table.= "        <td>".UPLOADED_ON_TEXT."</td>\n";
        $table.= "        <td>".UPLOADED_BY_TEXT."</td>\n";
        $table.= "    </tr>\n";
        $table.= "</thead>\n";
        $table.= "<tbody>\n";
        $query.= "SELECT * FROM Attachments WHERE TaskID={$id}";
        $result = $dbHandler->ExecuteQuery($query);
        if(mysql_num_rows($result)>0)
        {
            $IsTableEmpty = false;
            while($row = mysql_fetch_array($result))
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
                $table.= "<tr {$class}><td><a href=\"".HOME_FOLDER."attachments/{$row['Filename']}\">{$row['Filename']}</a></td>";
                $table.= "<td>{$row['Date']}</td>";
                $table.= "<td>{$row['UserID']}</td>";
            }
        }
        else
        {
            $IsTableEmpty = true;
        }
        $table.= "</tbody>\n";
        $table.= "</table>\n";
        $dbHandler->dbDisconnect();
        unset($dbHandler);
        if(!$IsTableEmpty)
        {
            echo $table;
            echo "<br />";
        ?>
            <form method="post" enctype="multipart/form-data">
                <h2><?php echo ADD_NEW_ATTACHMENT_TEXT;?></h2><br />
                <input type="file" name="Attachment" /><br />
                <input type="submit" value="<?php echo ATTACH_TEXT;?>" name="Attach" />
            </form>
        <?php
        }
        else
        {
        ?>
            <form method="post" enctype="multipart/form-data">
                <h2><?php echo ADD_NEW_ATTACHMENT_TEXT;?></h2><br />
                <input type="file" name="Attachment" /><br />
                <input type="submit" value="<?php echo ATTACH_TEXT;?>" name="Attach" />
            </form>
        <?php
        }
    }
}
elseif(!isset($_GET['id']) || $_GET['id'] == "")
{
    echo "<span class=\"NegativeMessage\">";
    echo MISSING_PARAMETER_TEXT;
    echo "</span>";
}
elseif(!isset($_SESSION['LoggedIn']))
{
    echo "<span class=\"NegativeMessage\">";
    echo PLEASE_LOGIN_TEXT;
    echo "</span>";
}
?>
