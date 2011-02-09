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
    $consonants ="qwrtplkjhgfdszxcvbnm";
    $vowelsNumber = strlen($vowels);
    $consonantsNumber = strlen($consonants);
    for($i=0; $i<=$length;$i+=2)
    {
      $consonant = substr($consonants, mt_rand(0, $consonantsNumber-1), 1);
      $vowel = substr($vowels, mt_rand(0, $vowelsNumber-1), 1);
      $password .= $consonant.$vowel;
     }
     $password .=mt_rand(0, 999)
     return $password;
   }
}
?>