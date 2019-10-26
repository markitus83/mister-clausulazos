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

// collapse players table
$('#collapseMyTeam').on('show.bs.collapse', function () {
  $('#collapseMyTeamSorted').collapse('hide');
  $('#buttonMyTeam').addClass('active');
  $('#buttonMyTeamSorted').removeClass('active');
});
$('#collapseMyTeam').on('hidden.bs.collapse', function () {
  $('#buttonMyTeam').removeClass('active');
})

$('#collapseMyTeamSorted').on('show.bs.collapse', function () {
  $('#collapseMyTeam').collapse('hide');
  $('#buttonMyTeamSorted').addClass('active');
  $('#buttonMyTeam').removeClass('active');
});
$('#collapseMyTeamSorted').on('hidden.bs.collapse', function () {
  $('#buttonMyTeamSorted').removeClass('active');
})

$('#goalkeeper').on('show.bs.collapse', function () {
  $('#defender').collapse('hide');
  $('#midfielder').collapse('hide');
  $('#forward').collapse('hide');    
  $('#buttonGoalkeeper').addClass('active');  
  $('#buttonDefender').removeClass('active');
  $('#buttonMidfielder').removeClass('active');
  $('#buttonForward').removeClass('active');
});
$('#goalkeeper').on('hidden.bs.collapse', function () {
  $('#buttonGoalkeeper').removeClass('active');
})

$('#defender').on('show.bs.collapse', function () {
  $('#goalkeeper').collapse('hide');
  $('#midfielder').collapse('hide');
  $('#forward').collapse('hide');    
  $('#buttonDefender').addClass('active');  
  $('#buttonGoalkeeper').removeClass('active');
  $('#buttonMidfielder').removeClass('active');
  $('#buttonForward').removeClass('active');
});
$('#defender').on('hidden.bs.collapse', function () {
  $('#buttonDefender').removeClass('active');
})

$('#midfielder').on('show.bs.collapse', function () {
  $('#goalkeeper').collapse('hide');
  $('#defender').collapse('hide');
  $('#forward').collapse('hide');    
  $('#buttonMidfielder').addClass('active');  
  $('#buttonGoalkeeper').removeClass('active');
  $('#buttonDefender').removeClass('active');
  $('#buttonForward').removeClass('active');
});
$('#midfielder').on('hidden.bs.collapse', function () {
  $('#buttonMidfielder').removeClass('active');
})

$('#forward').on('show.bs.collapse', function () {
  $('#goalkeeper').collapse('hide');
  $('#defender').collapse('hide');
  $('#midfielder').collapse('hide');    
  $('#buttonForward').addClass('active');  
  $('#buttonGoalkeeper').removeClass('active');
  $('#buttonDefender').removeClass('active');
  $('#buttonMidfielder').removeClass('active');
});
$('#forward').on('hidden.bs.collapse', function () {
  $('#buttonForward').removeClass('active');
})

