$(document).ready(function(){
	var offset = new Date().getTimezoneOffset();
	var timestamp = new Date().getTime();
	var utc_timestamp = timestamp + (60000 * offset);

	$('#time_zone_offset').val(offset); //selecting  time_zone_offset id and setting value
	$('#utc_timestamp').val(utc_timestamp); //selecting utc_timestamp id  ,,,,,,

});