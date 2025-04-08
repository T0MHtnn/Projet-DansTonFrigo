CREATE TABLE IF NOT EXISTS Ingredients(
   idingredient INT NOT NULL AUTO_INCREMENT,
   nomIngre VARCHAR(50) NOT NULL,
   uniteMesure VARCHAR(25) DEFAULT "unite",
   PRIMARY KEY(idingredient)
);

CREATE TABLE IF NOT EXISTS Recettes(
   idrecette INT NOT NULL AUTO_INCREMENT,
   nomRecette VARCHAR(255) NOT NULL,
   tempsPrepa INT NOT NULL,
   tempsCuisson INT NOT NULL,
   tempsRepos INT NOT NULL,
   tempsTotal INT NOT NULL,
   noteGlobale INT DEFAULT 0,
   nbNotes INT DEFAULT 0,
   difficulte INT DEFAULT 0,
   nbPersonnes INT NOT NULL,
   PRIMARY KEY(idrecette)
);

CREATE TABLE IF NOT EXISTS Compte(
   idcompte INT NOT NULL AUTO_INCREMENT,
   nomUtilisateur VARCHAR(50) NOT NULL,
   mdp VARCHAR(70) NOT NULL,
   estAdmin BOOLEAN DEFAULT FALSE,
   mail VARCHAR(50) NOT NULL,
   PRIMARY KEY(idcompte),
   UNIQUE(nomUtilisateur)
);

CREATE TABLE IF NOT EXISTS ImagesRecettes(
   idimgRecettes INT NOT NULL AUTO_INCREMENT,
   imgRecetteNom VARCHAR(50) NOT NULL,
   imgRecetteDesc TEXT NOT NULL,
   imgRecetteChemin VARCHAR(100) NOT NULL,
   idrecette INT,
   PRIMARY KEY(idimgRecettes),
   FOREIGN KEY(idrecette) REFERENCES Recettes(idrecette)
);

CREATE TABLE IF NOT EXISTS CategoriesIngredients(
   idcategorieIngredient INT NOT NULL AUTO_INCREMENT,
   libCategorieIngredient VARCHAR(30) NOT NULL,
   PRIMARY KEY(idcategorieIngredient)
);

CREATE TABLE IF NOT EXISTS Journees(
   idjour INT NOT NULL AUTO_INCREMENT,
   dateJournee VARCHAR(12) NOT NULL,
   idcompte INT NOT NULL,
   PRIMARY KEY(idjour),
   FOREIGN KEY(idcompte) REFERENCES Compte(idcompte)
);

CREATE TABLE IF NOT EXISTS Ustensiles(
   idustensile INT NOT NULL AUTO_INCREMENT,
   nomUstensile VARCHAR(50) NOT NULL,
   PRIMARY KEY(idustensile)
);

CREATE TABLE IF NOT EXISTS ImagesIngre(
   idimgIngre INT NOT NULL AUTO_INCREMENT,
   imgIngreNom VARCHAR(50) NOT NULL,
   imgIngreDesc TEXT NOT NULL,
   imgIngreChemin VARCHAR(100) NOT NULL,
   idingredient INT,
   PRIMARY KEY(idimgIngre),
   FOREIGN KEY(idingredient) REFERENCES Ingredients(idingredient)
);

CREATE TABLE IF NOT EXISTS CategoriesRecettes(
   idcategorieRecette INT NOT NULL AUTO_INCREMENT,
   libCategorieRecette VARCHAR(30) NOT NULL,
   PRIMARY KEY(idcategorieRecette)
);

CREATE TABLE IF NOT EXISTS etapesPreparations(
   idetape INT NOT NULL AUTO_INCREMENT,
   descEtape TEXT NOT NULL,
   numEtape INT NOT NULL,
   idrecette INT NOT NULL,
   PRIMARY KEY(idetape),
   FOREIGN KEY(idrecette) REFERENCES Recettes(idrecette)
);

CREATE TABLE IF NOT EXISTS est_favori(
   idrecette INT,
   idcompte INT,
   PRIMARY KEY(idrecette, idcompte),
   FOREIGN KEY(idrecette) REFERENCES Recettes(idrecette),
   FOREIGN KEY(idcompte) REFERENCES Compte(idcompte)
);

CREATE TABLE IF NOT EXISTS compose(
   idingredient INT,
   idrecette INT,
   PRIMARY KEY(idingredient, idrecette),
   FOREIGN KEY(idingredient) REFERENCES Ingredients(idingredient),
   FOREIGN KEY(idrecette) REFERENCES Recettes(idrecette)
);

CREATE TABLE IF NOT EXISTS categorise_ingredient(
   idingredient INT,
   idcategorieIngredient INT,
   PRIMARY KEY(idingredient, idcategorieIngredient),
   FOREIGN KEY(idingredient) REFERENCES Ingredients(idingredient),
   FOREIGN KEY(idcategorieIngredient) REFERENCES CategoriesIngredients(idcategorieIngredient)
);

CREATE TABLE IF NOT EXISTS a_besoin_de(
   idrecette INT,
   idustensile INT,
   PRIMARY KEY(idrecette, idustensile),
   FOREIGN KEY(idrecette) REFERENCES Recettes(idrecette),
   FOREIGN KEY(idustensile) REFERENCES Ustensiles(idustensile)
);

CREATE TABLE IF NOT EXISTS est_prevu_pour(
   idrecette INT,
   idjour INT,
   pourMidi BOOLEAN NOT NULL,
   PRIMARY KEY(idrecette, idjour),
   FOREIGN KEY(idrecette) REFERENCES Recettes(idrecette),
   FOREIGN KEY(idjour) REFERENCES Journees(idjour)
);

CREATE TABLE IF NOT EXISTS categorise_recette(
   idrecette INT,
   idcategorieRecette INT,
   PRIMARY KEY(idrecette, idcategorieRecette),
   FOREIGN KEY(idrecette) REFERENCES Recettes(idrecette),
   FOREIGN KEY(idcategorieRecette) REFERENCES CategoriesRecettes(idcategorieRecette)
);
