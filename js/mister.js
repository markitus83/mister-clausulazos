// Custom JS for this project

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