// Custom JS for this project



// check user
$("#formSelectUser").submit(function( event ) {
  var user = $( "select#selectUser option:checked" ).val();
  
  if (user == 'no_user') {
    if (!$('#no_user').length) {
      var alertMsg = '<div class="alert alert-warning" role="alert" id="no_user">Selecciona primero un usario<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
      $("#formSelectUser").before(alertMsg);      
    }
    event.preventDefault();
    $('.mister-container').remove();
  } 
  
});

// collapse
$('#collapseMyTeam').on('show.bs.collapse', function () {
  $('#collapseMyTeamSorted').collapse('hide');
  $('#buttonMyTeam').addClass('active');
  $('#buttonMyTeamSorted').removeClass('active');
});

$('#collapseMyTeamSorted').on('show.bs.collapse', function () {
  $('#collapseMyTeam').collapse('hide');
  $('#buttonMyTeamSorted').addClass('active');
  $('#buttonMyTeam').removeClass('active');
});