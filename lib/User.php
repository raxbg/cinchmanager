<?php
require_once("Autoload.php");

class User
{
	public function __construct($userInfo,$dbHandler)
	{
        $result = mysql_fetch_array($userInfo);       
        $dbHandler->RecordLogin($result['ID']);
        $_SESSION['userinfo']=$result;
	}
	   
	public function __get($property)
	{
		return $this->$property;
	}
	
	public function __set($propery,$value)
	{
		$this->$property = $value;
	}
	
	public static function Login($email,$password)
	{
            $dbHandler = new dbHandler;
            $dbHandler->dbConnect();
            $login = $dbHandler->LoginIsCorrect($email,$password);
		if($login)
		{
                    $user = new User($login,$dbHandler);
                    $_SESSION['LoggedIn']=true;
		}
            $dbHandler->dbDisconnect();
            unset($dbHandler);
            if(isset($_SESSION['LoggedIn']))
            {
                $setLanguage = Environment::SetGetVariable("language",$_SESSION['userinfo']['Language']);
                header('Location: '.$setLanguage);
            }
	}
    
    public static function Remember()
    {
      if(isset($_POST['RememberMe']) && !is_null($_POST['RememberMe']) || isset($_COOKIE['Email']))
      {

          $expire=time()+3600*24*365;
          $path='';
          $domain='';
          $secure=false;
          $httponly=true;
          if(isset($_COOKIE['Email']))
          {
              $email = $_COOKIE['Email'];
              $password = $_COOKIE['Password'];
              setcookie("Email","",time()-3600);
              setcookie("Password","",time()-3600);   
              setcookie("Email",$email,$expire,$path,$domain,$secure,$httponly);
              setcookie("Password",$password,$expire,$path,$domain,$secure,$httponly); 
          }
          else
          {
              setcookie("Email",$_POST['Email'],$expire,$path,$domain,$secure,$httponly);
              setcookie("Password",$_POST['Password'],$expire,$path,$domain,$secure,$httponly); 
          }
      }
    }
  
    public static function AutoLogin()
    {
      if(isset($_COOKIE['Email']))
      {
          self::Login( $_COOKIE['Email'],$_COOKIE['Password']);
      }
    }

    public static function Logout()
    {
      unset($_SESSION['LoggedIn']);
      session_destroy();
      setcookie("Email","",time()-3600);
      setcookie("Password","",time()-3600); 
    }   
  
    public static function GeneratePassword ()
    {
        $length = 6;
        $password = "";
        $vowels = "eyioau";
        $consonants ="wrtplkjhgfdszxcvbnm";
        $vowelsNumber = strlen($vowels);
        $consonantsNumber = strlen($consonants);
        for($i=0; $i<$length;$i+=2)
        {
            $consonant = substr($consonants, mt_rand(0, $consonantsNumber-1), 1);
            $vowel = substr($vowels, mt_rand(0, $vowelsNumber-1), 1);
            $password .= $consonant.$vowel;
        }
        return $password;
    }
    
    public static function CreateAccount($email,$title,$firstName,$secondName,$lastName,$gender,$address,$telephone,
            $branchID,$creatorID,$employeeOrClient,$language)
    {
        $password = self::GeneratePassword();
        $message = Email::NewUserEmail($firstName,$lastName,$email,$password);
        
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $encriptedPassword = $dbHandler->EncryptPwd($password);
        $date  = date("Y-m-d");
        $dbHandler->ExecuteQuery("BEGIN");

        $email = mysql_real_escape_string($email);
        $title = mysql_real_escape_string($title);
        $firstName = mysql_real_escape_string($firstName);
        $secondName = mysql_real_escape_string($secondName);
        $lastName = mysql_real_escape_string($lastName);
        $gender = mysql_real_escape_string($gender);
        $address = mysql_real_escape_string($address);
        $telephone = mysql_real_escape_string($telephone);
        $branchID = mysql_real_escape_string($branchID);
        $date = mysql_real_escape_string($date);
        $creatorID = mysql_real_escape_string($creatorID);
        $employeeOrClient = mysql_real_escape_string($employeeOrClient);
        $language = mysql_real_escape_string($language);

        $createAccount = "INSERT INTO Users (Email, Password,TitleID, FirstName, SecondName, LastName, Gender,
        Address, Telephone, BranchID, RegistrationDate, CreatorID, EmployeeOrClient, Language)
        VALUES ('{$email}','{$encriptedPassword}','{$title}','{$firstName}','{$secondName}','{$lastName}','{$gender}',
        '{$address}','{$telephone}','{$branchID}','{$date}','{$creatorID}','{$employeeOrClient}','{$language}')";

        $IsQuerySuccessful = $dbHandler->ExecuteQuery($createAccount);
        if ($IsQuerySuccessful)
        {
            $mailSent = Email::SendEmail($email,$message);
            if($mailSent)
            {
                $query = "SELECT ID FROM Users WHERE Email='{$email}'";
                $result = $dbHandler->ExecuteQuery($query);
                if($result)
                {
                    $userID = mysql_fetch_row($result);
                    $dbHandler->ExecuteQuery("COMMIT");
                    $dbHandler->dbDisconnect();
                    return $userID[0];
                }
                else
                {
                    echo "Due to problems with mysql we couldn't create the account completely.";
                    echo "Please try the procedure again.";
                    echo mysql_error();
                    $dbHandler->ExecuteQuery("ROLLBACK");
                    $dbHandler->dbDisconnect();
                    return false;
                }
            }
            else
            {
                echo "Failed to send user's password to the given email.";
                echo "Registration was canceled.";
                echo mysql_error();
                $dbHandler->ExecuteQuery("ROLLBACK");
                $dbHandler->dbDisconnect();
                return false;
            }
        }
        else
        {
          echo "User registration failed due to problems with mysql.\n\n".mysql_error();
          $dbHandler->ExecuteQuery("ROLLBACK");
          $dbHandler->dbDisconnect();
          return false;
        }
    }
    //ve4e ne se izpolzva
    public static function CreateEmployee($userID,$positionID,$managerID,$canCreateAccounts,$isAdmin,$assignmentDay)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $date  = date("Y-m-d");
        $dbHandler->ExecuteQuery("BEGIN");

        $positionID = mysql_real_escape_string($positionID);
        $canCreateAccounts = mysql_real_escape_string($canCreateAccounts);
        $canCreateTPB = mysql_real_escape_string($canCreateTPB);
        $assignmentDay = mysql_real_escape_string($assignmentDay);

        if ($managerID == "none")
        {
            $createEmployee = "INSERT INTO Employees (UserID,PositionID,CanCreateAccounts,IsAdmin,AssignmentDay)
        VALUES ('{$userID}','{$positionID}','{$canCreateAccounts}','{$isAdmin}','{$assignmentDay}')";
        }
        else
        {
            $managerID = mysql_real_escape_string($managerID);
            $createEmployee = "INSERT INTO Employees (UserID,PositionID,ManagerID,CanCreateAccounts,CanCreateTPB,AssignmentDay)
        VALUES ('{$userID}','{$positionID}','{$managerID}','{$canCreateAccounts}','{$canCreateTPB}','{$assignmentDay}')";
        }

        $IsQuerySuccessful = $dbHandler->ExecuteQuery($createEmployee);
        if ($IsQuerySuccessful)
        {
            $dbHandler->ExecuteQuery("COMMIT");
            $dbHandler->dbDisconnect();
            return true;
        }
        else
        {
          echo "Employee registration failed due to problems with mysql.\n\n ".$mysqlError;
          $dbHandler->ExecuteQuery("ROLLBACK");
          $dbHandler->dbDisconnect();
          return false;
        }
    }
    
    public static function CanCreateAccounts($canCreateAccounts)
    {
        if(!is_null($canCreateAccounts))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function AddToHierarchy($managerID,$userID,$position,$canCreateAccounts,$isAdmin,$assignmentDay,$salary)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();

        $managerID=mysql_real_escape_string($managerID);
        $userID=mysql_real_escape_string($userID);
        $position=mysql_real_escape_string($position);
        $canCreateAccounts=mysql_real_escape_string($canCreateAccounts);
        $isAdmin=mysql_real_escape_string($isAdmin);
        $assignmentDay=mysql_real_escape_string($assignmentDay);
        $salary=mysql_real_escape_string($salary);
        if($managerID != "none")
        {
            $myLeftResult = $dbHandler->ExecuteQuery("SELECT lft FROM Employees WHERE UserID = {$managerID}");
            $myLeft=mysql_fetch_row($myLeftResult);
            $myLeft = $myLeft[0];
        }
        else
        {
            $myLeftResult = $dbHandler->ExecuteQuery("SELECT MAX(rgt) FROM Employees");
            $myLeft=mysql_fetch_row($myLeftResult);
            $myLeft = $myLeft[0];
        }
        $query="INSERT INTO Salaries (UserID, FromDate, Amount)
                Values ('{$userID}','{$assignmentDay}','{$salary}')";
        $dbHandler->ExecuteQuery($query);
        $dbHandler->ExecuteQuery("UPDATE Employees SET rgt = rgt + 2 WHERE rgt > {$myLeft}");
        $dbHandler->ExecuteQuery("UPDATE Employees SET lft = lft + 2 WHERE lft > {$myLeft}");
        $query="INSERT INTO Employees(UserID, PositionID, CanCreateAccounts,IsAdmin, AssignmentDay, lft, rgt)
            VALUES('{$userID}', '{$position}','{$canCreateAccounts}', '{$isAdmin}','{$assignmentDay}', {$myLeft} + 1, {$myLeft} + 2)";
        if ($dbHandler->ExecuteQuery($query))
        {
            return true;
        }
        else
        {
            return false;
        }
        $dbHandler->dbDisconnect();
    }

    public static function MoveInHierarchy($user,$toManager)
    {
        //stavat anomalii, raboti si kakto trqbva no ne prorabotva vinagi,
        //sqkash trqbva da mine opredeleno vreme sled poslednoto polzvane
        $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
        $user = $mysqli->real_escape_string($user);
        $toManager = $mysqli->real_escape_string($toManager);
        echo $user."->".$toManager;
        $query="SELECT @myRight := rgt,@myLeft := lft ,@myWidth:=rgt-lft+1 FROM Employees WHERE UserID='{$user}';

            SELECT @myNewLeft := lft, @myNewRight := rgt FROM Employees
            WHERE UserID='{$toManager}';

            UPDATE Employees SET rgt = -rgt WHERE rgt > @myLeft AND rgt <= @myRight;
            UPDATE Employees SET lft = -lft WHERE lft >= @myLeft AND lft < @myRight;

            UPDATE Employees SET rgt = rgt - @myWidth WHERE rgt > @myLeft;
            UPDATE Employees SET lft = lft - @myWidth WHERE lft > @myLeft;

            SELECT @myNewStartRight := rgt FROM Employees WHERE UserID='{$toManager}';
            SELECT @Step := @myNewStartRight-@myLeft;

            UPDATE Employees SET rgt = rgt + @myWidth WHERE rgt >= @myNewStartRight;
            UPDATE Employees SET lft = lft + @myWidth WHERE lft >= @myNewStartRight;

            UPDATE Employees SET rgt = -rgt + @Step WHERE rgt <0;
            UPDATE Employees SET lft = -lft + @Step WHERE lft <0;";
       if(!$mysqli->multi_query($query)) die("Error: ".$mysqli->error);
       $mysqli->close();
    }

    public function IsXManagerOfY($Employee,$Manager)
    {
        $dbHandler = new dbHandler();
        $dbHandler->dbConnect();
        $employee=mysql_real_escape_string($Employee);
        $query="SELECT parent.UserID
            FROM Employees AS node,
            Employees AS parent
            WHERE node.lft BETWEEN parent.lft AND parent.rgt
            AND node.UserID='{$employee}'
            ORDER BY parent.lft";

        $result=$dbHandler->ExecuteQuery($query);
        while($manager=mysql_fetch_row($result))
        {
            if($manager[0]==$Manager)
            {
                $dbHandler->dbDisconnect();
                return true;
            }    
        }
        $dbHandler->dbDisconnect();
        return false;
    }
}
?>