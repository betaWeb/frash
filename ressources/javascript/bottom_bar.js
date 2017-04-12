$('#href_dump').click(function(){
	if($('.div_dump').css('display') == 'none'){
		$('.div_dump').show();
	} else {
		$('.div_dump').hide();
	}
});

$('.name_dump').click(function(){
	var dump = $(this).attr('id');

	$('#names_dump').text().split('/').forEach(function(name){
		if(dump == name){
			$('#content_'+dump).show();
		} else {
			$('#content_'+name).hide();
		}
	});
});