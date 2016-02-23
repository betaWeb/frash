$(document).ready(function(){
  oTable=$('#classement_gauche').dataTable({
    "sDom": '<"top"rf>t<"bottom"ip><"clear">',
    "bProcessing": true, 
    "bAutoWidth":false,
    "sPaginationType": "full_numbers",
    "bFilter": true,
    "iDisplayLength": 30,
    "bLengthChange": false,
    "aoColumns": [ 
      { "bSearchable": true, "sWidth" : "10px", "bSortable": true },
      { "bSearchable": true, "sWidth" : "10px", "bSortable": true },
      { "bSearchable": true, "sWidth" : "10px", "bSortable": true }
    ],
    "aaSorting":[[0, 'asc']],
    "oLanguage": {
      "sProcessing": "Recherche...",
      "sLengthMenu": "affichage _MENU_ fiche par page",
      "sZeroRecords": "Aucune correspondance",
      "sInfo": "Joueurs _START_ / _END_ sur _TOTAL_",
      "sInfoEmpty": "0 joueur",
      "sInfoFiltered": "",
      "sInfoPostFix": "",
      "sSearch": "Recherche &nbsp;",
      "sUrl": "",
      "oPaginate": { "sFirst": "D&eacutebut", "sPrevious": "Pr&eacutec&eacutedent", "sNext": "Suivant", "sLast": "Fin" }
    }
  });
});