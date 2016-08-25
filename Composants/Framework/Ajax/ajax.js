function callAjax(prefix, route, param){
    var donnees = '';

    var parameter = JSON.stringify(param);

    $.ajax({
        url: prefix+'/Composants/Framework/Ajax/ajax.php',
        type: 'POST',
        data: { route:route, params:parameter },
        dataType: 'json',
        async: false,
        success: function(data){
            donnees = data;
        }
    });

    return donnees;
}