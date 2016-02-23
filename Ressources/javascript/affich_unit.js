function add_input_unit(unit){
	$.ajax({
		url : 'includes/ajax/add_affich_unit.php',
		type : 'POST',
		data : 'unit='+unit,
		dataType : 'json',
		success: function(data){ $('#liste_unite').append(data); }
	});
}

// $('document').ready(function(){
// 	$('.unit').live('click', function() {
// 		alert('balibadou');
// 		var unit = $(this).attr('id_input');
// 		console.log(unit);
// 		$('#'+unit).hide;
// 	});
// });