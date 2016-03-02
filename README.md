# LFW
Light FrameWork

 - <kbd>Framework</kbd> : 3.24.19
 - <kbd>Jeu</kbd> : 7.8

Installation
----------

> - git clone https://github.com/AlixSperoza/LFW
> - php composer.phar install
> - Pour générer la documentation : php vendor/bin/phpdoc -d ./ -i vendor/ -i Views/

----------
Pour générer une entité et une table :
> php Console.php ORM:addentity:**nombundle**:**nomtable** "nom_colonne!int(11)!unsigned!NOT NULL!auto_increment/nom_colonne!...".

Pour créer la base de données renseignée dans le fichier routing.yml :
> php Console.php ORM:createdb

Pour créer une entité à partir d'une table :
> php Console.php ORM:updentity:**nombundle**:**nomtable**

Pour accéder aux commandes disponibles par la console :
> php Console.php console:listcommand

----------

Pour la configuration :

 - env : prod/local
 - log_error : yes/no
 - log_request (SQL) : yes/no
 - log_access (HTTP) : yes/no

----------

**A venir**

> - Un mailer
> - Un debugger
> - Une refonte de la configuration