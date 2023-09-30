# ECF_7

## Installation du projet ECF_7

1. S'assurer d'avoir une installation de Phalcon 4.0 opérationnelle (https://docs.phalcon.io/4.0/fr-fr/installation)
2. Récupérer le projet sur Github si ce n'est pas déjà fait, ainsi que le script de la base de données
3. Déplacer le dossier du projet dans le répertoire: var/www/html
4. Si vous désirez renommer le dossier du projet
   1. Aller dans le dossier: config.php
   2. Trouver cette ligne: defined('VIEW_PATH') || define('VIEW_PATH', 'ECF_7');
   3. Modifier "ECF_7" par le nouveau nom du dossier du projet
5. Créer une base de données en utilisant le script fourni: script-bdd.sql
6. Dans le dossier config, créer un fichier "local.php" contenant ce code à l'intérieur d'une balise php:

      $localConfiguration =
     ['database'=>[
          'adapter'=>'Mysql',
          'host' => '',
          'username' => '',
          'password'=>'',
          'dbname' =>'',
          'charset' => 'utf8',
      ]];
    
- **host**: le nom de votre serveur.
- **username**: votre identifiant de connexion au serveur.
- **password**: votre mot de passe de connexion au serveur.
- **dbname**: le nom de la base de données que vous avez créée au préalable.


8. Vérifier que vous possédez tout les droits en lecture et écriture sur le dossier du projet, si ce n'est pas le cas:
   1. Clique droit sur le dossier du projet
   2. Choisissez "Propiétés"
   3. Aller dans l'onglet "Permissions"
   4. Se donner toutes les permissions en Lecture/Ecriture
10. Sur votre navigateur favori, taper l'url: host/nomDuDossier    Exemple: localhost/ECF_7
