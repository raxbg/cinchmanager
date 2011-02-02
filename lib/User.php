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
	
	public function __construct($userInfo)
	{
        $result = mysql_fetch_array($userInfo);
        
        $this->id = $result['ID'];
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
    
    public function ID()
    {
        return $this->id;
    }
    
    public function Email()
    {
        return $this->email;
    }
    
    public function Title()
    {
        return $this->title;
    }
    
    public function FirstName()
    {
        return $this->firstname;
    }
    
    public function SecondName()
    {
        return $this->secondname;
    }
    
    public function LastName()
    {
        return $this->lastname;
    }
    
    public function Telephone()
    {
        return $this->telephone;
    }
    
    public function Address()
    {
        return $this->address;
    }
    
    public function BranchID()
    {
        return $this->branchid;
    }
    
    public function PhotoFileName()
    {
        return $this->photofilename;
    }
    
    public function RegistrationDate()
    {
        return $this->registrationdate;
    }
	
	public static function Login($email,$pwd)
	{
		$dbHandler = new dbHandler;
		$dbHandler->dbConnect();
        $login = $dbHandler->LoginIsCorrect($email,$pwd);
		if($login)
		{
            $result = mysql_fetch_array($login);
			$user = new User($result['Email']);
			echo "Hello ".$user->Title().$user->LaststName()."!";
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