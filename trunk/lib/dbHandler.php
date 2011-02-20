<?php
require_once("Globals.php");
require_once("Autoload.php");

class dbHandler
{
    private $host;
    private $username;
    private $password;
    private $con;
    private $db;
       
    public function __construct()
    {
        $this->host = HOST;
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->db = DATABASE;
    }
    
    public function dbConnect()
    {
        $this->con = mysql_connect($this->host,$this->username,$this->password);
        if (!$this->con)
          {
            die('Could not connect: ' . mysql_error());
          }
        mysql_select_db($this->db, $this->con);
        mysql_query("SET NAMES 'utf8'", $this->con);
    }
    
    public function RecordLogin($userID)
    {
        $query = "INSERT INTO Logins (UserID) VALUES ('{$userID}')";
        mysql_query($query,$this->con);
    }
    
    public function EncryptPwd($password)
    {
        $password = mysql_real_escape_string($password);
        $query = "SELECT SHA1('{$password}')";
        $result = mysql_query($query);
        $password = mysql_fetch_row($result);
        return $password[0];
    }
    
    public function LoginIsCorrect($email,$password)
    {
        $email = mysql_real_escape_string($email);
        $password = $this->EncryptPwd($password);
        $query = "SELECT Users.*,
        Titles.Title,
        Employees.CanCreateAccounts
        FROM Users
        LEFT JOIN Titles 
        ON Users.TitleID = Titles.ID
        LEFT JOIN Employees ON Users.ID = Employees.UserID
        WHERE Email = '{$email}' 
        AND Password = '{$password}'";
        $reply = mysql_query($query,$this->con);
        $userIsCorrect = mysql_num_rows($reply);
        if($userIsCorrect == 1) 
        {
            return $reply;
        }
        else
        {
            return false;
        }
    }
    
    public function dbDisconnect()
    {
        mysql_close($this->con);
    }
    
    public function Connection()
    {
        return $this->con;
    }
    
    public function ExecuteQuery($query)
    {
        return mysql_query($query,$this->con);
    }
}
?>