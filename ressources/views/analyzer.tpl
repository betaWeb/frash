<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Analyzer</title>
        <link rel="stylesheet" media="screen" type="text/css" href="{{ internal vendor/LFW/Framework/Analyzer/css/design.css }}">
        <link rel="stylesheet" media="screen" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div id="corps">
            <div class="well">
                Route : <a href="{{ route @true_route }}">{{ @true_route }}</a>
            </div>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab">
                        <h4 class="panel-title"><a role="collapsed" data-toggle="collapse" data-parent="#accordion" href="#info_php" aria-expanded="true">Informations PHP</a></h4>
                    </div>
                    <div id="info_php" class="panel-collapse collapse" role="tabpanel">
                        <div class="panel-body">
                            User : {{ @config.user }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>