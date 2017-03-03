# Frash

Pour installer Frash, il faut exécuter les commandes suivantes :

```sh
$ php composer.phar create-project alixsperoza/frash-install DIRECTORY
$ cd DIRECTORY
$ php console.php Framework:init
```

Il se peut qu'après l'installation des packages, et par la suite, après la configuration du framework par la dernière commande, il faille exécuter ces deux commandes :

```sh
$ chown -R user:www-data ./
$ chmod 770 -R ./
```