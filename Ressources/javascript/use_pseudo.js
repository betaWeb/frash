$('#pseudo').keyup(function(){
    $.ajax({
        url : 'includes/ajax/use_pseudo.php',
        type : 'POST',
        data : 'pseudo='+$(this).val(),
        dataType : 'json',
        success: function(data){ $('#use_pseudo').html('').html(data); }
    });
});