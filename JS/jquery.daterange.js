;(function ( $ ) {
$.fn.dateRange = function( options ) {
	var settings = $.extend({
		toDay: new Date(),
		fromDate:'#fromDate',
		toDate:'#toDate',
		fy:'2014-2015'
		}, options );
	Date.daysBetween = function( date1, date2 ) {
		var one_day=1000*60*60*24;
		var date1_ms = date1.getTime();
		var date2_ms = date2.getTime();
		var difference_ms = date2_ms - date1_ms;
		return Math.round(difference_ms/one_day); 
	}
	var fy=settings.fy.split('-');
	var minDate1=fy[0];
	var maxDate1=fy[1];
	var minDate  = new Date(minDate1, 3, 1);
	var maxDate  = new Date(maxDate1, 2, 31);
	var toDay = typeof settings.toDay === 'Date' ? settings.toDay : new Date(settings.toDay);
	var beforeDays=Date.daysBetween(minDate, toDay);
	var afterDays=Date.daysBetween(toDay, maxDate);
	$( settings.fromDate ).datepicker({
		dateFormat:"dd/mm/yy",
		changeMonth: true,
		minDate: -beforeDays,
		maxDate: afterDays,				
		onClose: function( selectedDate ) {
			if (selectedDate!= null && selectedDate !='') {
				$( settings.toDate ).datepicker( "option", "minDate", selectedDate );
			}
			else{
				$( settings.toDate ).datepicker( "option", "minDate", -beforeDays );						
			}
		}
	});
	$( settings.toDate ).datepicker({
		dateFormat:"dd/mm/yy",				
		changeMonth: true,
		minDate: -beforeDays,				
		maxDate: afterDays,
		onClose: function( selectedDate ) {
			if (selectedDate!= null && selectedDate !='') {					
				$( settings.fromDate ).datepicker( "option", "maxDate", selectedDate );
			}
			else{
				$( settings.fromDate ).datepicker( "option", "maxDate", afterDays );
			}					
		}
	});
///////////////////////////////
};
}( jQuery ));