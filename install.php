<?php
    if(version_compare(PHP_VERSION, '5.6', '>=')){
        $prefix = 'https://raw.githubusercontent.com/AlixSperoza/LFW/master/';

        $files_c = [
            'Configuration/.htaccess',
            'Configuration/config.yml',
            'Configuration/database.yml',
            'Configuration/dependencies.yml',
            'Configuration/routing.yml',
            'Configuration/routing_dev.yml',
            'Console/Bundle/GenerateBundle.php',
            'Console/Bundle/GenerateController.php',
            'Console/ORM/Addentity.php',
            'Console/ORM/Createdb.php',
            'Console/listcommand.php',
            'Framework/Controller/Annotations/AnnotationFactory.php',
            'Framework/Controller/Annotations/AnnotationObject.php',
            'Framework/Controller/Controller.php',
            'Framework/Controller/Determinate.php',
            'Framework/Controller/GetUrl.php',
            'Framework/Controller/Redirect.php',
            'Framework/Controller/TraductionFactory.php',
            'Framework/Controller/View.php',
            'Framework/CreateLog/CreateErrorLog.php',
            'Framework/CreateLog/CreateHTTPLog.php',
            'Framework/CreateLog/CreateRequestLog.php',
            'Framework/DIC/Dic.php',
            'Framework/Exception/Exception.php',
            'Framework/Forms/Type/Checkbox.php',
            'Framework/Forms/Type/Color.php',
            'Framework/Forms/Type/Csrf.php',
            'Framework/Forms/Type/Date.php',
            'Framework/Forms/Type/Email.php',
            'Framework/Forms/Type/File.php',
            'Framework/Forms/Type/Input.php',
            'Framework/Forms/Type/Number.php',
            'Framework/Forms/Type/Password.php',
            'Framework/Forms/Type/Range.php',
            'Framework/Forms/Type/Select.php',
            'Framework/Forms/Type/StartForm.php',
            'Framework/Forms/Type/Submit.php',
            'Framework/Forms/Type/Text.php',
            'Framework/Forms/Type/Textarea.php',
            'Framework/Forms/CreateForm.php',
            'Framework/Forms/CreateFormSql.php',
            'Framework/Forms/FormFactory.php',
            'Framework/Forms/FormTypeInterface.php',
            'Framework/Forms/VerifForm.php',
            'Framework/Globals/Files.php',
            'Framework/Globals/Get.php',
            'Framework/Globals/Server.php',
            'Framework/Globals/Session.php',
            'Framework/Mail/Mailer.php',
            'Framework/Routing/DefineGet.php',
            'Framework/Routing/Router.php',
            'Framework/Routing/RouterDev.php',
            'Framework/Systems/Ressources/css/logs.css',
            'Framework/Systems/Ressources/Views/Logs/logs_choice.html.twig',
            'Framework/Systems/Ressources/Views/Logs/logs_no_choice.html.twig',
            'Framework/Systems/Logs/Logs.php',
            'Framework/Templating/TemplateFactory.php',
            'Framework/Templating/View.php',
            'Framework/Utility/GenPass.php',
            'Logs/.htaccess',
            'Logs/access.log',
            'Logs/error.log',
            'Logs/request.log',
            'ORM/MySQL/Request/ComplexWhere.php',
            'ORM/MySQL/Request/Delete.php',
            'ORM/MySQL/Request/Functions.php',
            'ORM/MySQL/Request/Insert.php',
            'ORM/MySQL/Request/Select.php',
            'ORM/MySQL/Request/Update.php',
            'ORM/MySQL/Request/Where.php',
            'ORM/MySQL/QueryBuilder.php',
            'ORM/PDO/PDO.php',
            'ORM/PGSQL/Request/ComplexWhere.php',
            'ORM/PGSQL/Request/Delete.php',
            'ORM/PGSQL/Request/Functions.php',
            'ORM/PGSQL/Request/Insert.php',
            'ORM/PGSQL/Request/ResetAutoInc.php',
            'ORM/PGSQL/Request/Select.php',
            'ORM/PGSQL/Request/Update.php',
            'ORM/PGSQL/Request/Where.php',
            'ORM/PGSQL/Counter.php',
            'ORM/PGSQL/Finder.php',
            'ORM/PGSQL/QueryBuilder.php',
            'ORM/Hydrator.php',
            'ORM/Orm.php',
            'ORM/OrmFactory.php',
            'ORM/RequestInterface.php',
            'Yaml/Exception/DumpException.php',
            'Yaml/Exception/ExceptionInterface.php',
            'Yaml/Exception/ParseException.php',
            'Yaml/Exception/RuntimeException.php',
            'Yaml/Dumper.php',
            'Yaml/Escaper.php',
            'Yaml/Inline.php',
            'Yaml/LICENSE',
            'Yaml/Parser.php',
            'Yaml/Unescaper.php',
            'Yaml/Yaml.php',
            'Yaml/composer.json'
        ];

        $files_trad = [
            'TradFr.php'
        ];

        $files_master = [
            '.htaccess',
            'composer.json',
            'console',
            'index.php'
        ];

        mkdir('Bundles');
            mkdir('Bundles/AppBundle');
                mkdir('Bundles/AppBundle/Controllers');
                mkdir('Bundles/AppBundle/Entity');
                    mkdir('Bundles/AppBundle/Entity/Mapping');
                mkdir('Bundles/AppBundle/Requests');
                mkdir('Bundles/AppBundle/Ressources');
                mkdir('Bundles/AppBundle/Views');
        mkdir('LFW');
            mkdir('LFW/Cache');
                mkdir('LFW/Cache/TWIG');
            mkdir('LFW/Configuration');
            mkdir('LFW/Console');
                mkdir('LFW/Console/Bundle');
                mkdir('LFW/Console/ORM');
            mkdir('LFW/Framework');
                mkdir('LFW/Framework/Controller');
                    mkdir('LFW/Framework/Controller/Annotations');
                mkdir('LFW/Framework/CreateLog');
                mkdir('LFW/Framework/DIC');
                mkdir('LFW/Framework/Exception');
                mkdir('LFW/Framework/Forms');
                    mkdir('LFW/Framework/Forms/Type');
                mkdir('LFW/Framework/Globals');
                mkdir('LFW/Framework/Mail');
                mkdir('LFW/Framework/Routing');
                mkdir('LFW/Framework/Systems');
                    mkdir('LFW/Framework/Systems/Logs');
                    mkdir('LFW/Framework/Systems/Ressources');
                        mkdir('LFW/Framework/Systems/Ressources/css');
                        mkdir('LFW/Framework/Systems/Ressources/Views');
                            mkdir('LFW/Framework/Systems/Ressources/Views/Logs');
                mkdir('LFW/Framework/Templating');
                    mkdir('LFW/Framework/Templating/Fonctions');
                mkdir('LFW/Framework/Utility');
            mkdir('LFW/Logs');
            mkdir('LFW/ORM');
                mkdir('LFW/ORM/MySQL');
                    mkdir('LFW/ORM/MySQL/Request');
                mkdir('LFW/ORM/PDO');
                mkdir('LFW/ORM/PGSQL');
                    mkdir('LFW/ORM/PGSQL/Request');
        mkdir('Traductions');

        foreach($files_c as $v){
            file_put_contents('Composants/'.$v, file_get_contents($prefix.'Composants/'.$v));
            echo $prefix.'Composants/'.$v.PHP_EOL;
        }

        foreach($files_trad as $v){
            file_put_contents('Traductions/'.$v, file_get_contents($prefix.'Traductions/'.$v));
            echo $prefix.'Traductions/'.$v.PHP_EOL;
        }

        foreach($files_master as $v){
            file_put_contents($v, file_get_contents($prefix.$v));
            echo $prefix.$v.PHP_EOL;
        }
    }
    else{
        echo 'Version de PHP incompatible. Mettez-le à jour !';
    }