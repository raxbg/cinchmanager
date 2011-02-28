<?php
if(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['EmployeeOrClient'] == "e")
{
    $dbHandler = new dbHandler();
    $dbHandler->dbConnect();
    $id=mysql_real_escape_string($_GET['id']);
    $query="SELECT Users.ID, Titles.Title, Users.FirstName,Users.SecondName, Users.LastName,Users.Telephone, Users.Email, Users.Address, Branches.Name AS Branch, Positions.Position
                FROM Users
                LEFT JOIN Employees
                ON Users.ID = Employees.UserID
                LEFT JOIN Positions ON Employees.PositionID = Positions.ID
                LEFT JOIN Branches ON Users.BranchID = Branches.ID
                LEFT JOIN Titles ON Users.TitleID = Titles.ID
                WHERE Users.ID ={$id}";
    $result = $dbHandler->ExecuteQuery($query);
    $User=mysql_fetch_array($result);
    $dbHandler->dbDisconnect();
?>
    <div class="UserInfo">
        <img alt="Georgi Antonov" src="avatars/user_1.jpg" />
        <h2 id="name"><?php echo $User['Title']." ".$User['FirstName']." ".$User['SecondName']." ".$User['LastName']; ?></h2>
        <span><b><?php echo $User['Position'];?></b><?php echo " at ".COMPANY_NAME." ".$User['Branch'];?></span><br /><br />
        <div>
            <b>Telephone:</b>0883417986<br />
            <b>Email:</b>antonov_g@gsvision.eu
        </div>
        <div id="address">
            <h4>Address</h4>
            Veliko turnovo<br />
            ul. Stoyancho Ahtar 10
        </div>
        <h3>Projects</h3>
        <table class="cooltable">
            <thead>
                <tr>
                    <td>Project name</td>
                    <td>Start date</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td>CinchManager</td>
                    <td>01.02.2011</td>
                    <td>Active</td>
                </tr>
                <tr class="even">
                    <td>Laptopia</td>
                    <td>02.09.209</td>
                    <td>Active</td>
                </tr>
            </tbody>
        </table>
        <h3>Salary</h3>
        <table class="cooltable">
            <thead>
                <tr>
                    <td>Salary</td>
                    <td>From</td>
                    <td>To</td>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td>1000</td>
                    <td>01.01.2011</td>
                    <td>01.02.2011</td>
                </tr>
                <tr class="even">
                    <td>2000</td>
                    <td>01.02.2011</td>
                    <td> - </td>
                </tr>
            </tbody>
        </table>
        <h3>Payments</h3>
        <table class="cooltable">
            <thead>
                <tr>
                    <td>Sum</td>
                    <td>Date</td>
                </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td>100</td>
                    <td>24.01.2011</td>
                </tr>
                <tr class="even">
                    <td>250</td>
                    <td>15.02.2011</td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}
elseif(isset($_SESSION['LoggedIn']) && $_SESSION['userinfo']['EmployeeOrClient'] == "c")
{
    echo NOT_ALLOWED_TO_ACCESS_INFO_TEXT;
}
else
{
    echo PLEASE_LOGIN_TEXT;
}
?>