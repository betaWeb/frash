<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Exception</title>
        <link rel="stylesheet" href="{{ internal vendor/alixsperoza/frash/ressources/css/exception.css }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    </head>
    <body>
        <div id="corps">
            <div class="card card-block bg-faded">
                Route : {{ $true_route }}
            </div><br><br>
            <div>
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    {{ foreach $stacktrace :: key, array }}
                        <div class="card">
                            <div class="card-header" role="tab" id="heading{{ !key }}">
                                <h5 class="mb-0"><a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ !key }}" aria-expanded="true" aria-controls="collapse{{ !key }}">{{ !array.trace }}</a></h5>
                            </div>
                            <div id="collapse{{ !key }}" class="collapse show" role="tabpanel" aria-labelledby="heading{{ !key }}">
                                <div class="card-block div_content_code">
                                    <pre>{{ foreach !array.code_before :: col, line }}{{ !line }}{{ end_foreach }}</pre>
                                    <div class="principal_line"><pre>{{ foreach !array.code_line :: col, line }}{{ !line }}{{ end_foreach }}</pre></div>
                                    <pre>{{ foreach !array.code_after :: col, line }}{{ !line }}{{ end_foreach }}</pre>
                                </div>
                            </div>
                        </div>
                    {{ end_foreach }}
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    </body>
</html>