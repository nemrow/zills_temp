$(document).ready(function(){
	$('.loginEmailIn').focus(function(){
		if($(this).val() == ('Email')){
		$(this).val('');
		} else {
		return false;
		};
	}); // end focus
	$('.loginEmailIn').blur(function(){
		if($(this).val() == ('')){
		$(this).val('Email');
		} else {
		return false;
		};
	}); // end blur
	$('.loginBPassLab').click(function(){
		$(this).addClass('hiddenElement');
		$('.loginPassIn').focus();
	}); // end click
	$('.loginPassIn').focus(function(){
		$('.loginBPassLab').addClass('hiddenElement');
	}); // end focus
	$('.loginPassIn').blur(function(){
		if($(this).val() == ''){
		$('.loginBPassLab').removeClass('hiddenElement');
		} else {
		return false;
		};
	}); // end blur
});