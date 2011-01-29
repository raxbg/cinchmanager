CREATE TABLE EmployeeAdditionalData
(
EmployeeID INT NOT NULL,
PRIMARY KEY(EmployeeID),
FOREIGN KEY (EmployeeID) REFERENCES People(ID),
EGN VARCHAR(10),
BirthDate DATE NOT NULL,
RepublicTaxID INT NOT NULL,
NationalInsuranceID INT NOT NULL,
AdditionalPensionInsuranceID INT NOT NULL,
HealthInsuranceID INT NOT NULL
)ENGINE=InnoDB;