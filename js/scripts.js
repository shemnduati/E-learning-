$(document).ready(function(){
	$('#dateDue').datepicker({
		dateFormat : 'yy-mm-dd',
		minDate: 'today'
	});

	$('#print').on('click', function(){
		window.print();
	});
	
	$('.quiz').on('click', function(){
		var that = $(this);
		
		var time = 1000 * 30 * 1;
		
		//that.attr('disabled','disabled');
		//that.attr('href','#');
		
		var submitButton = that.parents('.panel-body').find('.submitQuiz');
		
		setTimeout(function(){
			submitButton.attr('disabled','disabled');
			submitButton.attr('href','#');
			clearTimeout(time);
			alert('Time is up');
		},time);
		
	});
	
	$("#file").on('change', function(){
		$("#profilePic").submit();
	});

	
});
