<?php
require_once("lib/LoadSystem.php");
if(isset($_SESSION['LoggedIn']))
{
    
            
?>
<form method="post">
    <input type="hidden" name="ProjectID" value="<?php echo $_GET['ProjectId']; ?>" />
    <?php echo PRIORITY_TEXT; ?><br />
    <select name="Prioriry">
        <option value="1" <?php if($Priority == "1"){ echo "selected=\"selected\"";} echo "/>".URGENT_TEXT; ?></option>
        <option value="2" <?php if($Priority == "2"){ echo "selected=\"selected\"";} echo "/>".HIGH_PRIORITY_TEXT; ?></option>
        <option value="3" <?php if($Priority == "3"){ echo "selected=\"selected\"";} echo "/>".NORMAL_PRIORITY_TEXT; ?></option>
        <option value="4" <?php if($Priority == "4"){ echo "selected=\"selected\"";} echo "/>".LOW_PRIORITY_TEXT; ?></option>
        <option value="5" <?php if($Priority == "5"){ echo "selected=\"selected\"";} echo "/>".LOWEST_PRIORITY_TEXT; ?></option>
    </select><br />
    <?php echo PROJECT_TEXT; ?><br />
    <select name="Project">
        <?php echo $Projects; ?>
    </select>
    <?php echo SHORT_DESCRIPTION_TEXT; ?><br />
    <input type="text" name="ShortDescription" value="<?php echo $ShortDescription; ?>" /><br />
    <?php echo DESCRIPTION_TEXT; ?><br />
    <textarea name="Description"><?php echo $Description; ?></textarea><br />
    <?php echo VISIBILITY_TEXT; ?><br />
    <input type="radio" name="Visibility" value="1" <?php if($Visibility == "1"){ echo "checked=\"checked\"";} echo "/>".PRIVATE_TEXT; ?>
    <input type="radio" name="Visibility" value="2" <?php if($Visibility == "2"){ echo "checked=\"checked\"";} echo "/>".INTERNAL_TEXT; ?>
    <input type="radio" name="Visibility" value="3" <?php if($Visibility == "3"){ echo "checked=\"checked\"";} echo "/>".EVERYONE_TEXT; ?><br />
    <?php echo DEADLINE_TEXT; ?><br />
    <input type="text" name="Deadline" value="<?php echo $Deadline; ?>" /><br />
    <input type="submit" name="Add" value="<?php echo ADD_TEXT ?>" />
    <input type="hidden" name="TaskID" value="<?php echo $TaskId; ?>" />
    <input type="hidden" name="Status" value="<?php echo $Status; ?>" />
    <input type="submit" name="Edit" value="<?php echo EDIT_TEXT ?>" />

</form>

<?php           
    
}
else
{
    echo "<span class=\"NegativeMessage\">".PLEASE_LOGIN_TEXT."</span>";;
}
?>
