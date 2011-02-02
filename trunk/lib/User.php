<?php
class User
{
    private $id;
	private $email;
	private $title;
	private $firstname;
	private $secondname;
	private $lastname;
	private $telephone;
	private $address;
	private $branchid;
	private $photofilename;
	private $registrationdate;
	
	public function __construct($email)
	{
		$dbHandler = new dbHandler;
		$dbHandler->dbConnect();
        $email = mysql_real_escape_string($email);
        $query = "SELECT * FROM Users WHERE Email = {$email}";
        $reply = mysql_query($query,$dbHandler->connection());
        $result = mysql_fetch_array($reply);
        
        $this->email = $result['Email'];
        $this->title = $result['Title'];
        $this->firstname = $result['FirstName'];
        $this->secondname = $result['SecondName'];
        $this->lastname = $result['LastName'];
        $this->telephone = $result['Telephone'];
        $this->address = $result['Address'];
        $this->branchid = $result['BranchID'];
        $this->photofilename = $result['PhotoFileName'];
        $this->registrationdate = $result['RegistrationDate'];
        
        $recordLogin = "INSERT INTO Logins (PersonID) 
                        VALUES ({$this->id})";
        mysql_query($recordLogin,$dbHandler->connection());
        $dbHandler->dbDisconnect();
        unset($dbHandler);
	}
	
	public function __get($property)
	{
		return $this->$property;
	}
	
	public function __set($propery,$value)
	{
		$this->$property = $value;
	}
	
	public static function Login($email,$pwd)
	{
		$dbHandler = new dbHandler;
		$dbHandler->dbConnect();
		if($dbHandler->LoginIsCorrect($email,$pwd))
		{
			$_SESSION['Username']=$email;
			echo "Hello ".$_SESSION['Username']."!";
		}
		else
		{
			echo "Incorrect username or password";
		}
		$dbHandler->dbDisconnect();
		unset($dbHandler);
	}
}
?>