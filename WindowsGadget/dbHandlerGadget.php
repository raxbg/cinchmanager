<?php
class dbHandlerGadget extends dbHandler
{    
    public function numberOfNewTasks($userID)
    {
        $userID = mysql_real_escape_string($userID);
        $query = "SELECT TaskID FROM TasksAndEmployees WHERE ToUserID = {$userID}";
        $result = mysql_query($query, $this->con);
        return mysql_num_rows($result);
    }
}
?>
