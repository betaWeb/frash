# LFW
Light FrameWork

 - <kbd>Framework</kbd> : 3.24.21
 - <kbd>Jeu</kbd> : 7.17

Installation
----------

> - git clone https://github.com/AlixSperoza/LFW
> - php composer.phar install
> - Pour générer la documentation : php vendor/bin/phpdoc -d ./ -i vendor/ -i Views/

----------
Pour générer une entité et une table :
> php console ORM:addentity:**nombundle**:**nomtable** "nom_colonne!int(11)!unsigned!NOT NULL!auto_increment/nom_colonne!...".

Pour créer la base de données renseignée dans le fichier routing.yml :
> php console ORM:createdb

Pour créer une entité à partir d'une table :
> php console ORM:updentity:**nombundle**:**nomtable**

Pour générer un bundle :
> php console Bundle:generate:**nombundle**

Pour accéder aux commandes disponibles par la console :
> php console console:listcommand

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