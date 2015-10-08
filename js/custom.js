var currentPageName;

$(document).ready(function() {
	// register slideHandler
	slideHandler();

	// init datetimepicker
	initDTP();

	$('#prev-day-btn').on('click', function(e) {
		e.preventDefault();
		console.log('prev-day-btn clicked');
	});

	$('#next-day-btn').on('click', function(e) {
		e.preventDefault();
		console.log('next-day-btn clicked');
	});

	$('.vote-btn').on('click', function(e) {
		var selectedMenuId;
		var selectedVoteOption;
		e.preventDefault();
		selectedMenuId = $(this).data('menu-id');
		selectedVoteOption = $('.vote-option-label.active.'+selectedMenuId+' input[type=radio]').data('select');

		if(!selectedVoteOption) {
			alert('You have to choose one option!');
			return false;
		}

		window.location.href='./vote_process.php?menu_id='+selectedMenuId+'&vote_option='+selectedVoteOption;
	});

	$('.voteresult-btn').on('click', function(e) {
		e.preventDefault();
		window.location.href='vote_result.php?menu_id='+$(this).data('menu-id');
	});

	$('#show-dtp-btn').on('click', function(e) {
		e.preventDefault();
		console.log('show-dtp-btn click');
		$('#datetimepicker1').data('DateTimePicker').show();
		$('div#smallCalendar').hide();
	});

	$('#datetimepicker1').on('dp.change', function(e) {
		//console.log($('#datetimepicker1').data('DateTimePicker').date().format('YYYYMMDD'));
		if(currentPageName === 'index') {
			window.location.href='./?menu_id='+$('#datetimepicker1').data('DateTimePicker').date().format('YYYYMMDD');
		} else if(currentPageName === 'vote_result') {
			window.location.href='./vote_result.php?menu_id='+$('#datetimepicker1').data('DateTimePicker').date().format('YYYYMMDD');
		}
	});

	$('#datetimepicker1 td.day.today').on('click', function(e) {
		e.preventDefault();
		if(currentPageName === 'index') {
			window.location.href='./?menu_id='+$('#datetimepicker1').data('DateTimePicker').date().format('YYYYMMDD');
		} else if(currentPageName === 'vote_result') {
			window.location.href='./vote_result.php?menu_id='+$('#datetimepicker1').data('DateTimePicker').date().format('YYYYMMDD');
		}
	});

	$('#datetimepicker1').on('dp.hide', function(e) {
		$('#dtp').hide();
		$('#datetimepicker1').data('DateTimePicker').hide();
		$('div#smallCalendar').show();
	});

	$('#datetimepicker1').on('dp.show', function(e) {
		$('div#smallCalendar').hide();
		$('#datetimepicker1').data('DateTimePicker').show();
		$('#dtp').show();
	});

	setInterval(function() {
		var formattedTime = timeConverter($.now());
		var selectedDayNoon = getSelectedDate(getUrlVars()['menu_id'], '')+'120000';
		selectedDayNoon = (getSelectedDate(getUrlVars()['menu_id'], '')) ? selectedDayNoon : formattedTime.substring(0,8)+'120000';

		console.log('formattedTime : ' + formattedTime);
		console.log('selectedDayNoon : ' + selectedDayNoon);

		if (formattedTime > selectedDayNoon) {
			// show votable indicator
			$('.vote-indicator').text('Votable');
			// show votable-area
			$('.votable-area').show('slow');
		} else { // exception case 
			// hide votable indicator
			$('.vote-indicator').text('');
			// hide votable-area
			$('.votable-area').hide('slow');
		}
	}, 1000);


	$('.panel-white > .panel-heading a').on('click', function(e) {
		if($(this).closest('.panel-heading').hasClass('acd-item-selected')) {
			$(this).closest('.panel-heading').removeClass('acd-item-selected');
		} else {
			$('.panel-white > .panel-heading').removeClass('acd-item-selected');
			$(this).closest('.panel-heading').addClass('acd-item-selected');
		}
	});

	/* User Defined Functions */

	// init Datetimepicker function
	function initDTP() {
        $('#datetimepicker1').datetimepicker({
        	dayViewHeaderFormat : 'MMMM YYYY',
        	format : 'YYYY-MM-DD',
        	daysOfWeekDisabled: [0, 6],
        	disabledDates : [],
        	showTodayButton: true,
        	showClose: true,
        	inline:true
        });

        addFocusSelectedDate();

	    // set show-dtp-btn title
	    var selectedDate = (getSelectedDate(getUrlVars()['menu_id'], '')) ? getSelectedDate(getUrlVars()['menu_id'], '') : timeConverter($.now()).substring(0,8);
		$('div#smallCalendar #show-dtp-btn').html('<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span> '+selectedDate);

		// hide dtp when loaded on mobile
		if($(window).width() < 992) {
		    $('#dtp').hide();
		    $('#datetimepicker1').data('DateTimePicker').hide();
		    $('div#smallCalendar').show();
		} else 
		// show dtp when loaded on PC
		{ 
			$('div#smallCalendar').hide();
			$('#datetimepicker1').data('DateTimePicker').show();
			$('#dtp').show();
		}
    }


    function addFocusSelectedDate() {
    	addFocusToDisabledToday();
        addFocusMenuId(getUrlVars()['menu_id']);
    }


    function addFocusToDisabledToday() {
    	if ($('td[data-action="selectDay"].day.today.disabled').length) {
    		$('td[data-action="selectDay"].active').removeClass('active');
    		$('td[data-action="selectDay"].day.today.disabled').addClass('active');
    	}
    }

    function addFocusMenuId(UrlVarMenuId) {
    	var selectedDate;
    	if(UrlVarMenuId) {
    		selectedDate = getSelectedDate(UrlVarMenuId, '/');
    		selectedDate2 = getSelectedDate(UrlVarMenuId, '');
    		//console.log(selectedDataDay);
    		$('td[data-action="selectDay"].active').removeClass('active');
    		$('td[data-day="'+selectedDate+'"]').addClass('active');
    		$('#datetimepicker1').data('DateTimePicker').date(selectedDate2);
    	}
    }

    function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

	function getSelectedDate(menuId, formatOption) {
		if(menuId) {
			var selectedDate = menuId.substring(0,8);
			if (formatOption === '/') {
				selectedDate = selectedDate.substring(4,6)+'/'+selectedDate.substring(6,8)+'/'+selectedDate.substring(0,4);
			} else if (formatOption === '') {
				selectedDate = selectedDate.substring(0,4)+selectedDate.substring(4,6)+selectedDate.substring(6,8);
			}
			return selectedDate;
		} else {
			return null;
		}
	}

	function timeConverter(milliseconds){
		var a = new Date(milliseconds);
		var year = a.getFullYear();
		var month = a.getMonth()+1;
		month = (month < 10) ? '0' + month : month;
		var date = a.getDate();
		date = (date < 10) ? '0' + date : date; 
		var hour = a.getHours();
		hour = (hour < 10) ? '0' + hour : hour;
		var min = a.getMinutes();
		min = (min < 10) ? '0' + min : min;
		var sec = a.getSeconds();
		sec = (sec < 10) ? '0' + sec : sec;
		var time = year.toString() +  month.toString() +  date.toString() + hour.toString() + min.toString() + sec.toString() ;
		return time;
	}

});

