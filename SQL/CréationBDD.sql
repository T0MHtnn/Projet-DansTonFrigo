INSERT INTO `recettes` (`idrecette`, `nomRecette`, `tempsPrepa`, `tempsCuisson`, `tempsRepos`, `tempsTotal`, `noteGlobale`, `nbNotes`, `difficulte`, `nbPersonnes`) VALUES
(1, 'Pot au feu', 40, 5, 10, 60, 3, 27, 2, 2),
(2, 'Tajine', 15, 35, 5, 55, 2, 13, 5, 4),
(3, 'Pâtes à la carbonara traditionelles', 5, 12, 0, 17, 4, 87, 2, 2),
(4, 'Riz et poulet au curry', 5, 15, 0, 20, 3, 540, 2, 4),
(11, 'Omelette aux champignons', 2, 15, 0, 17, 0, 0, 2, 2),
(14, 'Sauté de pommes de terres', 23, 2, 12, 37, 2, 28, 1, 2),
(15, 'Melon au jambon', 5, 0, 0, 5, 1, 35, 1, 2),
(16, 'Patate à l\'eau', 10, 15, 5, 30, 1, 7, 1, 2),
(18, 'Gâteau à l\'orange', 2, 2, 2, 6, 0, 0, 0, 2),
(19, 'Tacos saucisse', 10, 15, 0, 25, 3, 673, 2, 1),
(21, 'Gateau au chocolat', 10, 25, 5, 40, 4, 67, 2, 8),
(26, 'Tarte aux pommes', 10, 30, 15, 55, 3, 0, 3, 8),
(27, 'Pâtes jambon fromage', 5, 15, 0, 20, 3, 3, 2, 2);

INSERT INTO `ingredients` (`idingredient`, `nomIngre`, `uniteMesure`) VALUES
(2, 'melon', 'unite'),
(3, 'semoule', 'grammes'),
(4, 'riz', 'grammes'),
(5, 'saucisse de toulouse', 'unite'),
(6, 'pomme de terre', 'unite'),
(7, 'huile de tournesol', 'cuil. à soupe'),
(8, 'poulet', 'grammes'),
(9, 'crème fraîche épaisse', 'cuil. à soupe'),
(10, 'gruyère rapé', 'grammes'),
(11, 'pates', 'unité'),
(12, 'curry en poudre', 'cuil. à soupes'),
(13, 'jambon cru', 'tranches'),
(14, 'rhubarbe', 'unite'),
(17, 'pomme golden', 'unite'),
(18, 'Petits pois', 'grammes'),
(22, 'carotte', 'unité'),
(24, 'Oeuf', 'unité'),
(25, 'Lait', 'ml'),
(26, 'farine', 'cuill. à soupe');
	
INSERT INTO `categoriesrecettes` (`idcategorieRecette`, `libCategorieRecette`) VALUES
(1, 'français'),
(2, 'indien'),
(3, 'mexicain'),
(4, 'marocain'),
(5, 'tunisien'),
(6, 'plat d\'été'),
(7, 'plat d\'hiver'),
(8, 'basique'),
(10, 'végétarien'),
(11, 'végan'),
(12, 'gourmand');

INSERT INTO `categoriesingredients` (`idcategorieIngredient`, `libCategorieIngredient`) VALUES
(1, 'basique'),
(3, 'hiver'),
(4, 'fruit'),
(5, 'légume'),
(6, 'féculent'),
(9, 'viande'),
(10, 'asiatique'),
(11, 'tropicale'),
(12, 'fruit de mer'),
(13, 'Sucré'),
(14, 'végétal');

INSERT INTO `compte` (`nomUtilisateur`, `mdp`, `estAdmin`, `mail`) VALUES

('Robert', '9c3917e7d311b515c64797649519c2143423ebffcdbc1527f66973f8ad1b6d91', 1, 'roro_dubois@gmail.com'),
('Isabelle', '3ebd7b1093df97853793b505517ab8527b96af62b867ac1b26f7794ca8ac1c0d', 1, 'Isamrqs@gmail.com'),
('Ant0nin', '623fcb28602998e949b30028007efce3583683f6cd68a9527aff60fb8cb73202', 0, 'Anto@gmail.com'),
('Eve', '3c0abcd9f8091d7fb593d037b4316770e668f24644fec046e686c8089b275559', 0, 'evee_laporte@gmail.com');

/*
roro_dubois@gmail.com
R37db

Isamrqs@gmail.com
22miQs%

Anto@gmail.com
A3N7T5O5

evee_laporte@gmail.com
512%*

*/

INSERT INTO `imagesingre` (`idimgIngre`, `imgIngreNom`, `imgIngreDesc`, `imgIngreChemin`, `idingredient`) VALUES
(1, 'carotte.jpg', 'image de carottes', 'Images\\carotte.jpg', 22),
(3, 'saucisse.jpg', 'Image d\'une saucisse', 'Images\\saucisse.jpg', NULL),
(12, 'melon.jpg', 'Image d\'un melon', 'Images\\melon.jpg', 2);


INSERT INTO `ustensiles` (`idustensile`, `nomUstensile`) VALUES
(1, 'fouet'),
(2, 'spatule'),
(3, 'cuillère à soupe'),
(4, 'cuillère à café'),
(5, 'verre doseur'),
(6, 'saladier'),
(8, 'planche à découper'),
(9, 'casserole'),
(10, 'poêle'),
(11, 'cocotte minute'),
(12, 'cuillère en bois'),
(14, 'Bol'),
(15, 'moule à gateau'),
(16, 'moule à tarte');

INSERT INTO `imagesrecettes` (`idimgRecettes`, `imgRecetteNom`, `imgRecetteDesc`, `imgRecetteChemin`, `idrecette`) VALUES
(1, 'Potaufeu.png', 'image d\'un pot au feu ', 'Images/Potaufeu.jpg', 1),
(5, 'Potaufeu2.jpg', 'image de pot au feu', 'Images/Potaufeu2.jpg', 1),
(7, 'GateauChocolat.jpg', 'Gateau au chocolat', 'Images/GateauChocolat.jpg', 21),
(11, 'patesJambonFromage.jpg', 'Plat de pâtes au jambon et au fromage', 'Images\\patesJambonFromage.jpg', 27);


INSERT INTO `etapespreparations` (`idetape`, `descEtape`, `numEtape`, `idrecette`) VALUES
(1, '100g de riz  -  150g de poulet  -  2 cuil. à soupe de crème fraîche épaisse  -  2 cuil. à soupe de curry en poudre', 0, 4),
(2, 'Faites cuire du riz et en parallèle faites cuire à la poêle votre poulet', 1, 4),
(3, 'Mettez le poulet à feu doux puis mettez votre riz dans la poêle', 2, 4),
(4, 'Rajoutez la crème fraîche épaisse ainsi que le curry dans poêle, mélangez puis dégustez !', 3, 4),
(102, 'Epluchez vos pommes de terre ainsi que les carottes', 1, 1),
(106, '4 pommes de terre - 2 carottes - 500g de boeuf', 0, 1),
(108, 'Découpez votre melon', 1, 15),
(109, 'Accompagnez les tranches de melon avec votre jambon', 2, 15),
(110, '1 melon - 4 tranches de jambon sec', 0, 15),
(111, '100 grammes de pâtes - 100 grammes de lardon - 1 œuf - 2 cuillère à soupe  de crème fraiche épaisse', 0, 3),
(112, '150 grammes de pâtes - 1 tranche de jambon - 50grammes de gruyère rapé', 0, 27),
(113, 'Mettez les pâtes à cuire 10min dans une casserole', 1, 27),
(114, 'Une fois la cuisson terminée, ajoutez le jambon et le fromage rapé dans la casserole', 2, 27),
(115, 'Laissez fondre le fromage, mélangez et dégustez !', 3, 27);


INSERT INTO est_favori (idrecette, idcompte) VALUES
(21, 1),
(26, 1),
(4, 2),
(2, 2)
;

INSERT INTO `compose` (`idingredient`, `idrecette`) VALUES
(2, 15),
(3, 2),
(4, 4),
(5, 19),
(6, 1),
(6, 14),
(6, 16),
(7, 14),
(8, 4),
(9, 3),
(10, 27),
(11, 3),
(11, 27),
(12, 2),
(12, 4),
(13, 27),
(17, 26),
(22, 1),
(22, 2),
(24, 11),
(24, 18),
(24, 21),
(24, 26),
(25, 18),
(25, 21),
(25, 26),
(26, 18),
(26, 21);

INSERT INTO `categorise_ingredient` (`idingredient`, `idcategorieIngredient`) VALUES
(2, 1),
(2, 4),
(3, 1),
(4, 1),
(6, 6),
(7, 1),
(8, 1),
(11, 1),
(24, 1),
(25, 1),
(26, 1);


INSERT INTO `categorise_recette` (`idrecette`, `idcategorieRecette`) VALUES
(1, 1),
(1, 7),
(2, 5),
(3, 8),
(4, 2),
(15, 6),
(21, 8),
(26, 10),
(27, 8),
(27, 12);

INSERT INTO `a_besoin_de` (`idrecette`, `idustensile`) VALUES
(1, 5),
(1, 8),
(1, 11),
(2, 6),
(2, 9),
(2, 10),
(3, 9),
(3, 10),
(3, 12),
(4, 3),
(4, 9),
(4, 10),
(11, 2),
(11, 10),
(14, 10),
(16, 9),
(16, 12),
(18, 15),
(19, 10),
(21, 1),
(21, 6),
(21, 15),
(26, 16),
(27, 9),
(27, 12);

