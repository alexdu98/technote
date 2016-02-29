# Insertion pour la table groupe
INSERT IGNORE INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (1, 'administrateur');
INSERT IGNORE INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (2, 'modérateur');
INSERT IGNORE INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (3, 'membre');

#Insertion pour la table membre
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('alex', 'alexdu98@gmx.fr', '$2y$12$baWf8sziCXcnYb875dCoKe708LxeQI7AQoO8fskrRcQiQO2jyquSC', '1', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('modo', 'modo@outlook.fr', 'modo', '2', '0');
INSERT IGNORE INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('membre', 'membre@outlook.fr', 'membre', '3', '0');

#Insertion pour la table technote
INSERT IGNORE INTO `technote`.`technote` (titre, contenu, id_auteur, url_image) VALUES (
'Les expressions regulieres en C',
'Les expressions régulières sont des chaînes de caractères qui se contentent de décrire un motif. 
Elles ont la réputation d\'avoir une syntaxe difficile à apprendre et à relire, ce qui, j\'espère vous en convaincre, est faux.',
'1',
'http://www.zdnet.fr/i/edit/ne/2014/09/ngn-intro-hub-140x105.jpg'
);

INSERT IGNORE INTO `technote`.`technote` (titre, contenu, id_auteur, url_image) VALUES (
  'LocalStorage dans un navigateur',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non eleifend justo, quis gravida lacus. Nunc viverra tempus justo eu sollicitudin. Suspendisse volutpat velit in libero dignissim molestie. Vestibulum quis felis vitae justo fermentum viverra sit amet in purus. Nulla facilisi. Vestibulum eget quam eget nunc consectetur mollis. Mauris sodales tellus quam, nec viverra massa interdum ac. Nam at enim ac dolor rutrum sollicitudin et ut quam. Cras eget enim volutpat, pulvinar leo et, sodales orci.',
  '1',
  'http://news360x.fr/wp-content/uploads/2015/12/Internet1.jpg'
);

INSERT IGNORE INTO `technote`.`technote` (titre, contenu, id_auteur, url_image) VALUES (
  'Les sessions PHP',
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non eleifend justo, quis gravida lacus. Nunc viverra tempus justo eu sollicitudin. Suspendisse volutpat velit in libero dignissim molestie. Vestibulum quis felis vitae justo fermentum viverra sit amet in purus. Nulla facilisi. Vestibulum eget quam eget nunc consectetur mollis. Mauris sodales tellus quam, nec viverra massa interdum ac. Nam at enim ac dolor rutrum sollicitudin et ut quam. Cras eget enim volutpat, pulvinar leo et, sodales orci.',
  '1',
  'http://oleaass.com/wp-content/uploads/2014/09/PHP.png'
);

INSERT IGNORE INTO `technote`.`technote` (titre, contenu, id_auteur, url_image) VALUES (
'Le design pattern MVC',
'Le patron d\'architecture logicielle modèle-vue-contrôleur (en abrégé MVC, en anglais model-view-controller), 
tout comme les patrons modèle-vue-présentation ou présentation, abstraction, contrôle, 
est un modèle destiné à répondre aux besoins des applications interactives 
en séparant les problématiques liées aux différents composants au sein de leur architecture respective',
'2',
'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/MVC-Process.svg/2000px-MVC-Process.svg.png'
);

INSERT IGNORE INTO `technote`.`mot_cle` (`label`) VALUES ('C'), ('expressions régulières'), ('expressions régulières'), ('regexp'), ('mémoire'), ('PHP'), ('navigateur'), ('sessions');

INSERT IGNORE INTO `technote`.`decrire` (`id_technote`, `id_mot_cle`) VALUES ('1', '1'), ('1', '2'), ('1', '3'), ('2', '4'), ('2', '6'), ('3', '5'), ('3', '7');