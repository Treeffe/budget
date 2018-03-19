ALTER TABLE Compte
ADD CONSTRAINT FK_CompteUsers
FOREIGN KEY (IDUser) REFERENCES Visiteur(ID); 

ALTER TABLE Compte
ADD CONSTRAINT FK_CompteCategorieCompte
FOREIGN KEY (IDCategorieCompte) REFERENCES catgorieCompte(ID); 



ALTER TABLE Transaction
ADD CONSTRAINT FK_TransactionCategorieTransaction
FOREIGN KEY (IDCategorieTransaction) REFERENCES categorieTransaction(ID); 

ALTER TABLE Transaction
ADD CONSTRAINT FK_TransactionCompteCredit
FOREIGN KEY (IDCompteCredit) REFERENCES Compte(ID); 

ALTER TABLE Transaction
ADD CONSTRAINT FK_TransactionCompteDebit
FOREIGN KEY (IDCompteDebit) REFERENCES Compte(ID); 