# LFW
Light FrameWork

 - <kbd>Framework</kbd> : 1.5.3
 - <kbd>Jeu</kbd> :

Installation
----------

> - git clone https://github.com/AlixSperoza/LFW
> - php composer.phar install
> - Pour générer la documentation : php vendor/bin/phpdoc -d ./ -i vendor/ -i Views/

----------
Pour générer une entité et une table :
> php Console/Console.php ORM:addentity:**nomtable** "nom_colonne!int(11)!unsigned!NOT NULL!auto_increment/nom_colonne!...".

Pour créer la base de données renseignée dans le fichier routing.yml :
> php Console/Console.php ORM:createdb

Pour créer une entité à partir d'une table :
> php Console/Console.php ORM:updentity:**nomtable**

Pour accéder aux commandes disponibles par la console :
> php Console/Console.php console:listcommand

----------

Pour la configuration :

 - env : prod/local

----------

**A venir**

> - Un mailer
> - Un debugger
> - Une refonte de la configuration