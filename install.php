<?php
    if(version_compare(PHP_VERSION, '5.6', '>=')){
        $prefix = 'https://raw.githubusercontent.com/AlixSperoza/LFW/master/';

        $files_c = [
            'Configuration/.htaccess',
            'Configuration/config.yml',
            'Configuration/database.yml',
            'Configuration/dependencies.yml',
            'Configuration/routing.yml',
            'Configuration/routing_ajax.yml',
            'Configuration/routing_dev.yml',
            'Console/Bundle/GenerateBundle.php',
            'Console/Bundle/GenerateController.php',
            'Console/ORM/Addentity.php',
            'Console/ORM/Createdb.php',
            'Console/listcommand.php',
            'Framework/Ajax/ajax.js',
            'Framework/Ajax/ajax.php',
            'Framework/Controller/TraductionFactory.php',
            'Framework/Controller/View.php',
            'Framework/CreateLog/CreateErrorLog.php',
            'Framework/CreateLog/CreateHTTPLog.php',
            'Framework/CreateLog/CreateRequestLog.php',
            'Framework/DIC/Dic.php',
            'Framework/Exception/ActionChargementFail.php',
            'Framework/Exception/ConnexionORMFail.php',
            'Framework/Exception/ControllerChargementFail.php',
            'Framework/Exception/FailFactory.php',
            'Framework/Exception/GetChargementFail.php',
            'Framework/Exception/RouteChargementFail.php',
            'Framework/Exception/TwigChargementTemplateFail.php',
            'Framework/Globals/Files.php',
            'Framework/Globals/Get.php',
            'Framework/Globals/Server.php',
            'Framework/Globals/Session.php',
            'Framework/Routing/Router.php',
            'Framework/Utility/Forms/Type/Checkbox.php',
            'Framework/Utility/Forms/Type/Color.php',
            'Framework/Utility/Forms/Type/Csrf.php',
            'Framework/Utility/Forms/Type/Date.php',
            'Framework/Utility/Forms/Type/Email.php',
            'Framework/Utility/Forms/Type/File.php',
            'Framework/Utility/Forms/Type/Input.php',
            'Framework/Utility/Forms/Type/Number.php',
            'Framework/Utility/Forms/Type/Password.php',
            'Framework/Utility/Forms/Type/Range.php',
            'Framework/Utility/Forms/Type/Select.php',
            'Framework/Utility/Forms/Type/StartForm.php',
            'Framework/Utility/Forms/Type/Submit.php',
            'Framework/Utility/Forms/Type/Text.php',
            'Framework/Utility/Forms/Type/Textarea.php',
            'Framework/Utility/Forms/CreateForm.php',
            'Framework/Utility/Forms/FormFactory.php',
            'Framework/Utility/Forms/VerifForm.php',
            'Framework/Utility/GenPass.php',
            'Framework/Controller.php',
            'Framework/ControllerFactory.php',
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
            'ORM/RequestFactory.php',
            'ORM/VerifParamDbYaml.php',
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
                mkdir('Bundles/AppBundle/Requests');
                mkdir('Bundles/AppBundle/Views');
        mkdir('Composants');
            mkdir('Composants/Configuration');
            mkdir('Composants/Console');
                mkdir('Composants/Console/Bundle');
                mkdir('Composants/Console/ORM');
            mkdir('Composants/Framework');
                mkdir('Composants/Framework/Ajax');
                    mkdir('Composants/Framework/Ajax/AjaxClass');
                mkdir('Composants/Framework/Controller');
                mkdir('Composants/Framework/CreateLog');
                mkdir('Composants/Framework/DIC');
                mkdir('Composants/Framework/Exception');
                mkdir('Composants/Framework/Globals');
                mkdir('Composants/Framework/Routing');
                mkdir('Composants/Framework/Utility');
                    mkdir('Composants/Framework/Utility/Forms');
                        mkdir('Composants/Framework/Utility/Forms/Type');
            mkdir('Composants/Logs');
            mkdir('Composants/ORM');
                mkdir('Composants/ORM/MySQL');
                    mkdir('Composants/ORM/MySQL/Request');
                mkdir('Composants/ORM/PGSQL');
                    mkdir('Composants/ORM/PGSQL/Request');
            mkdir('Composants/Yaml');
                mkdir('Composants/Yaml/Exception');
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