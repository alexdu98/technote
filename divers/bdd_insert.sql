# Insertion pour la table groupe
INSERT INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (1, 'administrateur');
INSERT INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (2, 'modérateur');
INSERT INTO `technote`.`groupe` (`id_groupe`, `libelle`) VALUES (3, 'membre');

#Insertion pour la table membre
INSERT INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('admin', 'admin@outlook.fr', 'admin', '1', '0'); 
INSERT INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('admin', 'admin@outlook.fr', 'admin', '1', '0');
INSERT INTO `technote`.`membre` (pseudo, email, password, id_groupe, bloquer) VALUES ('admin', 'admin@outlook.fr', 'admin', '1', '0');