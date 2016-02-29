# Insertion pour la table groupe
INSERT IGNORE INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (1, 'administrateur');
INSERT IGNORE INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (2, 'modérateur');
INSERT IGNORE INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (3, 'membre');

#Insertion pour la table membre
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('admin', 'admin@outlook.fr', 'admin', '1', '0'); 
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('mod', 'mod@outlook.fr', 'mod', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('membre', 'membre@outlook.fr', 'membre', '1', '0');

#Insertion pour la table technote
INSERT IGNORE INTO `technote`.`technote` (titre, contenu, id_auteur, url_image) VALUES (
'Les expressions regulieres en C',
'Les expressions régulières sont des chaînes de caractères qui se contentent de décrire un motif. 
Elles ont la réputation d\'avoir une syntaxe difficile à apprendre et à relire, ce qui, j\'espère vous en convaincre, est faux.',
'1',
'/assets/images/technotes/'
); 

INSERT IGNORE INTO `technote`.`technote` (titre, contenu, id_auteur, url_image) VALUES (
'Le design pattern MVC',
'Le patron d\'architecture logicielle modèle-vue-contrôleur (en abrégé MVC, en anglais model-view-controller), 
tout comme les patrons modèle-vue-présentation ou présentation, abstraction, contrôle, 
est un modèle destiné à répondre aux besoins des applications interactives 
en séparant les problématiques liées aux différents composants au sein de leur architecture respective',
'2',
'/assets/images/technotes/'
); 
