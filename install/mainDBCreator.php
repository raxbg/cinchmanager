<?php
$Queries['SetCollation'] = "ALTER DATABASE {$_POST['Database']}
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";

$Queries['BEGIN_TRAN'] = "BEGIN";

$Queries['createBranches'] = "CREATE  TABLE Branches 
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
Name VARCHAR(100) NOT NULL,
UNIQUE (Name),
Address TINYTEXT NOT NULL,
Telephone VARCHAR(20)
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
BranchID int NOT NULL,
FOREIGN KEY (BranchID) REFERENCES Branches(ID),
RegistrationDate DATE NOT NULL,
CreatorID INT,
FOREIGN KEY (CreatorID) REFERENCES Users(ID),
Language VARCHAR(5),
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
CanCreateAccounts CHAR(1),
IsAdmin BOOLEAN,
AssignmentDay DATE NOT NULL,
EndDate DATE,
lft int,
rgt int
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
StartDate DATE,
Status int NOT NULL DEFAULT 1,
Description MEDIUMTEXT,
INDEX(Name)
) ENGINE=InnoDB";

$Queries['createTasks'] = "CREATE TABLE Tasks
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
ProjectID int NOT NULL,
FOREIGN KEY (ProjectID) REFERENCES Projects(ID),
UserID int NULL DEFAULT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
ShortDescription VARCHAR(150) NOT NULL,
Description MEDIUMTEXT,
AssignmentTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
Deadline  TIMESTAMP NULL DEFAULT NULL,
DateFinnished TIMESTAMP NULL DEFAULT NULL,
Priority int NOT NULL,
Status int NOT NULL,
Visibility int NOT NULL
) ENGINE = InnoDB";

$Queries['cerateProjectsAndMembers'] = "CREATE TABLE ProjectsAndMembers
(
ProjectID int NOT NULL,
FOREIGN KEY (ProjectID) REFERENCES Projects(ID),
UserID int NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
PRIMARY KEY(ProjectID,UserID),
IsLeader BOOLEAN,
IsOwner BOOLEAN
)ENGINE = InnoDB";

$Queries['createSalaries'] = "CREATE TABLE Salaries
(
UserID int NOT NULL,
FOREIGN KEY (UserID) REFERENCES Users(ID),
FromDate DATE NOT NULL,
PRIMARY KEY(UserID,FromDate),
ToDate DATE,
Amount DECIMAL(15,2) NOT NULL
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

$Queries['insertBranch'] = "INSERT INTO Branches (Name, Address)
VALUES ('{$_POST['BranchName']}','{$_POST['BranchAddress']}')";

$Queries['insertTitle0'] = "INSERT INTO Titles (Title)
VALUES ('')";

$Queries['insertTitle1'] = "INSERT INTO Titles (Title) 
VALUES ('Mr.')";

$Queries['insertTitle2'] = "INSERT INTO Titles (Title) 
VALUES ('Mrs.')";

$Queries['insertTitle3'] = "INSERT INTO Titles (Title) 
VALUES ('Ms.')";

$Queries['insertTitle4'] = "INSERT INTO Titles (Title) 
VALUES ('Dr.')";

$Queries['insertTitle5'] = "INSERT INTO Titles (Title) 
VALUES ('Pr.')";

$Queries['insertPosition'] = "INSERT INTO Positions (Position)
VALUES ('Administrator')";

$Queries['COMMIT'] = "COMMIT";

$dbHandler = new dbHandler();
$dbHandler->dbConnect();
foreach ($Queries as $query)
{
  if(!$dbHandler->ExecuteQuery($query))
  {
      echo mysql_error();
      $dbHandler->ExecuteQuery("ROLLBACK");
      break;
  }
}
$dbHandler->dbDisconnect();
unset($dbHandler);
?>