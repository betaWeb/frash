# LFW
Light FrameWork

 - <kbd>Framework</kbd> : 0.5.111

Installation
----------

> - git clone https://github.com/AlixSperoza/LFW
> - php composer.phar install

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