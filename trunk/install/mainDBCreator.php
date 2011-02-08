<?php
$dbHandler = new dbHandler;

$Queries['createBranches'] = "CREATE  TABLE Branches 
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
Address TINYTEXT NOT NULL,
Name VARCHAR(100) NOT NULL
) ENGINE=InnoDB";

$Queries['createTitles'] = "CREATE TABLE Titles
(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
Title VARCHAR(50) NOT NULL
)ENGINE=InnoDB";

$Queries['createPositions'] = "CREATE TABLE Positions
(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
Position VARCHAR(20)
) ENGINE=InnoDB";

$Queries['createUsers'] = "CREATE TABLE Users
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
Email VARCHAR(50) NOT NULL,
UNIQUE (Email),
Password VARCHAR(40) NOT NULL,
Gender CHAR(1),
TitleID int,
FOREIGN KEY (TitleID) REFERENCES Titles(ID),
FirstName VARCHAR(15) NOT NULL,
SecondName VARCHAR(15),
LastName VARCHAR(15) NOT NULL,
Telephone VARCHAR(20),
Address TINYTEXT,
PhotoFileName VARCHAR(50),
BranchID int NOT NULL,
FOREIGN KEY (BranchID) REFERENCES Branches(ID),
RegistrationDate DATE NOT NULL,
INDEX(Email,FirstName,LastName),
EmployeeOrClient CHAR(1)
)ENGINE=InnoDB";

$Queries['createEmployees'] = "CREATE TABLE Employees
(
UserID int NOT NULL,
PRIMARY KEY(UserID),
FOREIGN KEY (UserID) REFERENCES Users(ID),
PositionID int NOT NULL,
FOREIGN KEY (PositionID) REFERENCES Positions(ID),
ManagerID int,
FOREIGN KEY (ManagerID) REFERENCES Users(ID),
AssignmentDay DATE NOT NULL,
EndDate DATE
) ENGINE=InnoDB";

$Queries['createLogins'] = "CREATE TABLE Logins
(
ID INT NOT NULL AUTO_INCREMENT,
UserID int NOT NULL,
PRIMARY KEY(ID),
FOREIGN KEY (UserID) REFERENCES Users(ID),
Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB";

$Queries['createProjects'] = "CREATE TABLE Projects
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
BranchID int NOT NULL,
FOREIGN KEY (BranchID) REFERENCES Branches(ID),
Name VARCHAR(50) NOT NULL,
StartDate DATE NOT NULL,
Status int NOT NULL,
Description MEDIUMTEXT,
INDEX(Name)
) ENGINE=InnoDB";

$Queries['createTasks'] = "CREATE TABLE Tasks
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
ProjectID int NOT NULL,
FOREIGN KEY (ProjectID) REFERENCES Projects(ID),
ShortDescription VARCHAR(150) NOT NULL,
Description MEDIUMTEXT,
AssignmentTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
Deadline TIMESTAMP,
DateFinnished TIMESTAMP,
Priority int NOT NULL,
Status int NOT NULL,
Visibility int NOT NULL
) ENGINE = InnoDB";

$Queries['createTasksAndEmployees'] = "CREATE TABLE TasksAndEmployees
(
TaskID int NOT NULL,
FOREIGN KEY (TaskID) REFERENCES Tasks(ID),
ToUserID int NOT NULL,
FOREIGN KEY (ToUserID) REFERENCES Users(ID),
FromUserID int NOT NULL,
FOREIGN KEY (FromUserID) REFERENCES Users(ID),
PRIMARY KEY(TaskID,ToUserID)
)ENGINE = InnoDB";

$Queries['cerateProjectsAndmembers'] = "CREATE TABLE ProjectsAndMembers
(
ProjectID int NOT NULL,
FOREIGN KEY (ProjectID) REFERENCES Projects(ID),
UserID int NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
PRIMARY KEY(ProjectID,UserID)
)ENGINE = InnoDB";

$Queries['createExpenses'] = "CREATE TABLE Expenses
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
ShortDescription VARCHAR(150) NOT NULL,
Description MEDIUMTEXT,
Date Date NOT NULL,
Amount DECIMAL(15,2) NOT NULL
)ENGINE=InnoDB";

$Queries['createIncomes'] = "CREATE TABLE Incomes
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
ShortDescription VARCHAR(150) NOT NULL,
Description MEDIUMTEXT,
Date Date NOT NULL,
Amount DECIMAL(15,2) NOT NULL
)ENGINE=InnoDB";

$Queries['createSalaries'] = "CREATE TABLE Salaries
(
UserID int NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
FromDate DATE NOT NULL,
PRIMARY KEY(UserID,FromDate),
ToDate DATE,
Amount DECIMAL(15,2) NOT NULL
)ENGINE=InnoDB";

$Queries['createPayments'] = "CREATE TABLE Payments
(
TaskID int NOT NULL,
UserID int NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
Amount DECIMAL(15,2) NOT NULL,
PRIMARY KEY(TaskID,UserID),
Date DATE NOT NULL
)ENGINE=InnoDB";

$Queries['createBonuses'] = "CREATE TABLE Bonuses
(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
UserID int NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
Date DATE NOT NULL,
Amount DECIMAL(15,2) NOT NULL,
Description VARCHAR(200)
)ENGINE=InnoDB";

$Queries['createProjectsMaitenance'] ="CREATE TABLE ProjectsMaintenance
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
ProjectID int NOT NULL,
Description MEDIUMTEXT,
FomDate DATE NOT NULL,
ToDate DATE NOT NULL,
Cost DECIMAL(15,2) NOT NULL,
Type VARCHAR(20) NOT NULL
)ENGINE=InnoDB";

$Queries['createPeriodicalPayments'] ="CREATE TABLE PeriodicalPayments
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
ProjectID int,
Description MEDIUMTEXT,
FomDate DATE NOT NULL,
ToDate DATE NOT NULL,
Cost DECIMAL(15,2) NOT NULL,
Type VARCHAR(20) NOT NULL
)ENGINE=InnoDB";

$Queries['createComments'] ="CREATE TABLE Comments
(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
TaskID INT NOT NULL,
FOREIGN KEY (TaskID) REFERENCES Tasks(ID),
UserID INT NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
Comment MEDIUMTEXT  NOT NULL,
Time TIMESTAMP DEFAULT NOW()
)ENGINE=InnoDB";

$Queries['createAttachments'] = "CREATE TABLE Attachments
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
TaskID INT NOT NULL,
FOREIGN KEY (TaskID) REFERENCES Tasks(ID),
UserID INT NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
Date TIMESTAMP DEFAULT NOW(),
Filename VARCHAR(50) NOT NULL
)ENGINE=InnoDB";

$Queries['createProjectHistory'] = "CREATE TABLE ProjectHistory
(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
ProjectID INT NOT NULL,
FOREIGN KEY (ProjectID) REFERENCES Projects(ID),
UserID INT NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
Timestamp TIMESTAMP DEFAULT NOW(),
Event VARCHAR(150) NOT NULL
)ENGINE=InnoDB";

$Queries['createCostOfTasks'] = "CREATE TABLE CostOfTasks
(
ID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
TaskID INT NOT NULL,
FOREIGN KEY (TaskID) REFERENCES Tasks(ID),
Cost DECIMAL(15,2) NOT NULL,
Payed BOOL
)ENGINE=InnoDB";

$Queries['insertBranch'] = "INSERT INTO Branches (Address, Name) 
VALUES ('{$_POST['BranchName']}','{$_POST['BranchAddress']}')";

$password = User:GeneratePassword();
echo $password;
$encriptedPassword = dbHandler->EncryptPwd(User:GeneratePassword());
$Queries['insertAdmin'] = "INSERT INTO Users (Email, Password, FirstName, LastName, Address, BranchID, RegistrationDate, EmployeeOrClient)
VALUES ('{$_POST['Email']}','{$encriptedPassword},'{$_POST['FirstName']}','{$_POST['LastName']}','{$_POST['AdminAddress']}',1,15-02-2001,'е')";  //да оправим датата

foreach ($Queries as $query)
{
	mysql_query($query,dbHandler->con);
}
?>