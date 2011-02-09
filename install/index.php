<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Cinch Manager installator</title>
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
    </head>
    <body>
        <div id="header">
        </div>
        <div id="page">
            <form method="post" action="install.php">
                <h2>Installation information</h2>
                Host:<br />
                <input type="text" name="Host" value="localhost" /><br />
                Database:<br />
                <input type="text" name="Database" /><br />
                DB username:<br />
                <input type="text" name="DBUsername" /><br />
                Password:<br />
                <input type="password" name="DBPassword" /><br />
                <br />
                Default language:<br />
                <select name="DefaultLanguage">
                    <option value="bg">BG</option>
                    <option value="en">EN</option>
                </select>
                <h2>Company information:</h2>
                Company name:<br />
                <input type="text" name="CompanyName" /><br />
                Main bracnh name:<br />
                <input type="text" name="BranchName" /><br />
                Main bracnh address:<br />
                <textarea name="BranchAddress"></textarea><br />
                <h2>Create an admin account</h2>
                Email:<br />
                <input type="text" name="Email" /><br />
                First name:<br />
                <input type="text" name="FirstName" /><br />
                Last name:<br />
                <input type="text" name="LastName" /><br />
              Address:<br />
                <textarea name="AdminAddress"></textarea><br />
                <input type="submit" value="Install"/><br />
            </form>
        </div>        
    </body>
</html>