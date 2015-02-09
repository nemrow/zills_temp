$(document).ready(function(){
	var alphabetOnlyRegex = /^[a-z]+$/i;
	
	var regEmailValid = false;
	var regFNameValid = false;
	var regLNameValid = false;
	var regPassValid = false;
	var regEmailTakenValid = false;
	
	var regEmailError = '';
	var regFNameError = '';
	var regLNameError = '';
	var regPassError = '';
	var regEmailTakenError = '';
	
	
	var loginEmailValid = false;
	var loginPassValid = false;
	
	var loginEmailError = '';
	var loginPassError = '';
	
	function myBasicFocusBlur(className,defaultText){
		$('.'+className).focus(function(){
			if($(this).val()==defaultText){
				$(this).val('');
			};
		});
		$('.'+className).blur(function(){
			if($(this).val()==''){
				$(this).val(defaultText);
			};
		});
	};
	function myPassFocusBlur(inputClass,defaultText,backboardClass){
		$('.'+inputClass).focus(function(){
			$('.'+backboardClass).text('');
		});
		$('.'+inputClass).blur(function(){
			if($(this).val()==''){
				$('.'+backboardClass).text(defaultText);
			};
		});
	};
	function emailValidator(inputClass,regOrLogin){ // reg = 1, login = 2
		var emailTestical=$('.'+inputClass).val();
		var atpos=emailTestical.indexOf("@");
		var dotpos=emailTestical.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailTestical.length){
			if(regOrLogin==1){
				regEmailValid = false;
				regEmailError = '<li>need valid email</li>';
			}else{
				loginEmailValid = false;
				loginEmailError = '<li>need valid email</li>';
			};
		}else{
			if(regOrLogin==1){
				regEmailValid = true;
				regEmailError = '';
			}else{
				loginEmailValid = true;
				loginEmailError = '';
			};
		};
	};
	function passwordValidator(inputClass,regOrLogin){ // 1 = reg, 2 = login
		if($('.'+inputClass).val().length<8){
			if(regOrLogin==1){
				regPassValid = false;
				regPassError = '<li>Password must be at least 8 charecters</li>';
			}else{
				loginPassValid = false;
				loginPassError = '<li>Password must be at least 8 charecters</li>';
			};
		}else{
			if(regOrLogin==1){
				regPassValid = true;
				regPassError = '';
			}else{
				loginPassValid = true;
				loginPassError = '';
			};
		};
	};
	function nameValidator(inputClass,FirstOrLastName){ // 1 = first name, 2 = last name
		var nameToValidate = $('.'+inputClass).val();
		if(nameToValidate.length<1 || nameToValidate=='First Name' || nameToValidate=='Last Name'){
			if(FirstOrLastName==1){
				regFNameValid = false;
				regFNameError = '<li>Need valid first name</li>';
			}else{
				regLNameValid = false;
				regLNameError = '<li>Need valid last name</li>';
			};
		}else{
			if(alphabetOnlyRegex.test(nameToValidate)){ // regex set up top
				if(FirstOrLastName==1){
					regFNameValid = true;
					regFNameError = '';
				}else{
					regLNameValid = true;
					regLNameError = '';
				};
			}else{
				if(FirstOrLastName==1){
					regFNameValid = false;
					regFNameError = '<li>Need valid first name</li>';
				}else{
					regLNameValid = false;
					regLNameError = '<li>Need valid last name</li>';
				};
			};
		};
	};
	function writeLoginErrorCode(regOrLogin){ // reg = 1, login = 2
		if(regOrLogin==1){
			$('.loginRegErrorBox').html(regEmailTakenError + regEmailError + regFNameError + regLNameError + regPassError);
		}else{
			$('.loginLoginErrorBox').html(loginEmailError + loginPassError);
		};
	};
	function registerValidation(){
		emailValidator('registerEmail',1);
		passwordValidator('registerPassInput',1);
		nameValidator('registerFirstName',1);
		nameValidator('registerLastName',2);
		writeLoginErrorCode(1);
	};
	function loginValidation(){
		emailValidator('loginEmailInnie',2);
		passwordValidator('loginPassInput',2);
		writeLoginErrorCode(2);
	};
	$('.registerEmail').change(function(){
		var form_data = {
			email: $('.registerEmail').val(),
			requestType: 'CheckEmail',
			is_ajax: 1
		}; // end form_data
		$.ajax({
			type: "POST",
			url: 'request.php',
			data: form_data,
			success: function(response) {
				if(response == 'EmailExists') {
					regEmailTakenValid = false;
					regEmailTakenError = '<li>Account already exists</li>';
					return false;
				} else if(response == 'success') {
					regEmailTakenValid = true;
					regEmailTakenError = '';
				};
			} // end success
		});
	});
	$('.forgotPassSubmitBtn').click(function(){
		var emailTestical = $('#forgotPassInput').val();
		$('.resetPasswordComleteBox h1').html('New password sent to <br/>'+ emailTestical);
		$('.openResetPasswordComleteBox').trigger('click');
		var atpos=emailTestical.indexOf("@");
		var dotpos=emailTestical.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailTestical.length){
			alert('That is not a valid email!');
			return false;
		}else{
			var form_data = {
				email: $('#forgotPassInput').val(),
				requestType: 'ResetPassword',
				is_ajax: 1
			}; // end form_data
			$.ajax({
				type: "POST",
				url: 'request.php',
				data: form_data,
				success: function(response) {
					if(response == 'success') {
						// do nothing
					} else {
						$('.resetPasswordComleteBox h1').text('Whoops. Please try again.');
					};
				} // end success
			});
		};
	});
	$('.orLoginBtn').click(function(){
		$('.loggsSlidingFrame').animate({
			'left':'0px'
		},1000);
	});
	$('.orSignUpBtn').click(function(){
		$('.loggsSlidingFrame').animate({
			'left':'-545px'
		},1000);
	});
	$('.forgotPassBtn').click(function(){
		$('.loggsSlidingFrame').animate({
			'left':'-1090px'
		},1000);
	});
	
	myBasicFocusBlur('registerEmail','Email');
	myBasicFocusBlur('registerFirstName','First Name');
	myBasicFocusBlur('registerLastName','Last Name');
	myPassFocusBlur('registerPassInput','Password','registerPassBackboard');
	myBasicFocusBlur('loginEmailInnie','Email');
	myPassFocusBlur('loginPassInput','Password','loginPassBackboard');
	myBasicFocusBlur('forgotPassInput','Email');
	
	$('.registerSubmit').click(function(event){
		registerValidation();
		if(regEmailValid==true && regFNameValid==true && regLNameValid==true && regPassValid==true && regEmailTakenValid==true){
			// do nothing
		}else{
			event.preventDefault();
		};
	});
	
	$('.signinSubmit').click(function(event){
		loginValidation();
		if(loginEmailValid==true && loginPassValid==true){
			// do nothing
		}else{
			event.preventDefault();
		};
	});
	
});