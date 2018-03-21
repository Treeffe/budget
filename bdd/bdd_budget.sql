CREATE TABLE Visiteur ( 
ID int NOT NULL AUTO_INCREMENT, 
nomUser varchar(255) NOT NULL, 
prenomUser varchar(255) NOT null, 
emailUser varchar(255) not null, 
loginUser varchar(255) not null, 
mdpUser varchar(255), 
salt varchar(255), 
role varchar(255) not null,
PRIMARY KEY (ID) );

CREATE TABLE categorieCompte ( 
ID int NOT NULL AUTO_INCREMENT, 
libelleCategorieCompte varchar(255) NOT NULL,  
PRIMARY KEY (ID) );

CREATE TABLE categorieTransaction ( 
ID int NOT NULL AUTO_INCREMENT, 
libelleCategorieTansaction varchar(255) NOT NULL,  
PRIMARY KEY (ID) );

CREATE TABLE Compte(
ID int NOT NULL AUTO_INCREMENT, 
IDUser int not null,
IDCategorieCompte int NOT NULL,
MontantCompte float not null,
libelleCompte varchar(255) NOT NULL,  
PRIMARY KEY (ID) );

CREATE TABLE Transaction( 
ID int NOT NULL AUTO_INCREMENT, 
IDCategorieTransaction int NOT NULL,
IDCompteCredit int NOT NULL,
IDCompteDebit int NOT NULL,
idUser int not null,
date dateTime NOT NULL,
montant float NOT NULL,
libelleTransaction varchar(255) NOT NULL,  
PRIMARY KEY (ID) );


INSERT INTO visiteur VALUES (1, 'cornado', 'thibaut', 'cornado@hotmail.fr', 'treef', 'YRKBx8oeQ2sLBrEqjJeqc8UwC9HPp+Ed6dhCeeHPQJ9vY4vbMepUbS14/rE6njWr4RZd4E+tU4pcOMI0h8Z6UA==', 'mnPEaJNz6,rUPbAYGg6$UXt', 'ROLE_ADMIN')

INSERT INTO `categoriecompte` (`ID`, `libelleCategorieCompte`) VALUES ('1', 'aucune categorie de compte');

INSERT INTO `categorietransaction` (`ID`, `libelleCategorieTansaction`) VALUES ('1', 'Aucune catégorie de transaction');