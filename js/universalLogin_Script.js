/******** universal login/signup *******/
$(document).ready(function(){
var uniCheckoutBtnType = 0;
$('.uniCheckOutloginBtn1').hover(
	function(){
		if(uniCheckoutBtnType==0){
		$(this).stop().animate({
			'width':'202px',
			'left': '54px'
		},100);
		};
	},
	function(){
	if(uniCheckoutBtnType==0){
		$(this).stop().animate({
			'width':'210px',
			'left':'50px'
		},100);
		};
	}
); // end hover
$('.uniCheckOutloginBtn2').hover(
	function(){
		if(uniCheckoutBtnType==0){
		$(this).stop().animate({
			'width':'202px',
			'left':'306px'
		},100);
		};
	},
	function(){
		if(uniCheckoutBtnType==0){
		$(this).stop().animate({
			'width':'210px',
			'left':'302px'
		},100);
		};
	}
);
$('.uniCheckOutloginBtn3').hover(
	function(){
		if(uniCheckoutBtnType==0){
		$(this).stop().animate({
			'width':'262px',
			'left':'150px'
		},100);
		};
	},
	function(){
		if(uniCheckoutBtnType==0){
		$(this).stop().animate({
			'width':'270px',
			'left':'146px'
		},100);
		};
	}
);
$('#uniCheckOutLoginMember').click(function(){
	$('#uniInSaleLoginNewMember').css('display','none');
	$('#uniCheckOutLoginNewMember').fadeIn();
	if(uniCheckoutBtnType==0){
	$('#uniCheckOutLoginMember, #uniCheckOutOptionText').fadeOut();
	}
	$('#uniCheckOutLoginFacebook').animate({
		'width':'160px',
		'height':'27px',
		'left':'107px',
		'top':'58px'
	});
	$('#uniCheckOutLoginNewMember, #uniCheckOutLoginMember').animate({
		'width':'160px',
		'height':'27px',
		'left':'295px',
		'top':'58px'
	});
	if(uniCheckoutBtnType==0){
	$('#uniInSaleMemberLogin').delay(400).fadeIn(800);
	}else{
		$('#uniInSaleMemberLogin').fadeIn(800);
	};
	$('#uniCheckOutPoweredShellP').fadeOut();
	$('#uniCheckOutPoweredShellImg').delay(300).animate({
		'left':'10px',
		'top':'10px',
		'width':'90px',
		'height':'29px'
	},1200);
	$('#uniInSaleTypeOfLoginHead').text('Member Login').delay(600).fadeIn(800);
	uniCheckoutBtnType = 1;
});
$('#uniInSaleLoginEmail').focus(function(){
	if($(this).val()=='Email'){
		$(this).val('');
	};
	}).blur(function(){
	if($(this).val()==''){
		$(this).val('Email');
	};
}); // end focus
$('#uniInSaleLoginPass').focus(function(){
	if($('#uniInSaleLoginPassLab').text()=='Password'){
		$('#uniInSaleLoginPass').css('background-color','#FFF');
		$('#uniInSaleLoginPassLab').text('');
	};
}).blur(function(){
	if($('#uniInSaleLoginPass').val()==''){
		$('#uniInSaleLoginPass').css('background-color','transparent');
		$('#uniInSaleLoginPassLab').text('Password');
	};
});
$('#uniCheckOutLoginNewMember').click(function(){
$	('#uniCheckOutLoginMember').fadeIn();
	if(uniCheckoutBtnType==0){
	$('#uniInSaleLoginNewMember').delay(400).fadeIn(800);
	}else{
	$('#uniInSaleLoginNewMember').fadeIn(800);
	};
	$('#uniCheckOutLoginNewMember, #uniCheckOutOptionText').fadeOut();
	$('#uniCheckOutLoginFacebook').animate({
		'width':'160px',
		'height':'27px',
		'left':'107px',
		'top':'58px'
	});
	$('#uniCheckOutLoginMember, #uniCheckOutLoginNewMember').animate({
		'width':'160px',
		'height':'27px',
		'left':'295px',
		'top':'58px'
	});
	$('#uniInSaleMemberLogin').css('display','none');
	$('#uniCheckOutPoweredShellP').fadeOut();
	$('#uniCheckOutPoweredShellImg').delay(300).animate({
		'left':'10px',
		'top':'10px',
		'width':'90px',
		'height':'29px'
	},1200);
	$('#uniInSaleTypeOfLoginHead').text('New Member Signup').delay(600).fadeIn(800);
	uniCheckoutBtnType = 2;
});
$('#uniInSaleSignUpEmail').focus(function(){
	if($(this).val()=='Email'){
		$(this).val('');
	};
}).blur(function(){
	if($(this).val()==''){
		$(this).val('Email');
	};
});
$('#uniInSaleSignUpFirstName').focus(function(){
	if($(this).val()=='First Name'){
		$(this).val('');
	};
}).blur(function(){
	if($(this).val()==''){
		$(this).val('First Name');
	};
});
$('#uniInSaleSignUpLastName').focus(function(){
	if($(this).val()=='Last Name'){
		$(this).val('');
	};
}).blur(function(){
	if($(this).val()==''){
		$(this).val('Last Name');
	};
});
$('#uniInSaleSignUpPass1').focus(function(){
	if($('#uniInSaleSignUpPassLab1').text()=='Password'){
		$('#uniInSaleSignUpPass1').css('background-color','#FFF');
		$('#uniInSaleSignUpPassLab1').text('Password');
	};
}).blur(function(){
	if($('#uniInSaleSignUpPass1').val()==''){
		$('#uniInSaleSignUpPass1').css('background-color','transparent');
		$('#uniInSaleSignUpPassLab1').text('Password');
	};
});
$('#uniInSaleSignUpPass2').focus(function(){
	if($('#uniInSaleSignUpPassLab2').text()=='Confirm Password'){
		$('#uniInSaleSignUpPass2').css('background-color','#FFF');
		$('#uniInSaleSignUpPassLab2').text('Password');
	};
}).blur(function(){
	if($('#uniInSaleSignUpPass2').val()==''){
		$('#uniInSaleSignUpPass2').css('background-color','transparent');
		$('#uniInSaleSignUpPassLab2').text('Confirm Password');
	};
});
/** validation **/
var uniInSaleLoginEmailValid = undefined;
var uniInSaleLoginPasswordValid = undefined;
var uniInSaleLoginBadPassText = '';
var uniInSaleLoginBadEmailText = '';
var uniInSaleLoginBadPassHolder = 'Passwords must be at least 8 charecters!';
var uniInSaleLoginBadEmailHolder = 'No fake emails you fool! ';
var uniInSaleLoginErrorBubbleOpen = false;

var uniInSaleNewMemberEmailValid = undefined;
var uniInSaleNewMemberEmailTakenValid = undefined;
var uniInSaleNewMemberPassValid = undefined;
var uniInSaleNewMemberConfPassValid = undefined;
var uniInSaleNewMemberFirstNameValid = undefined;
var uniInSaleNewMemberLastNameValid = undefined;
var uniInSaleErrorBubbleOpen = false;
var uniInSaleErrorTextBadEmailHold = 'No fake emails! ';
var uniInSaleErrorTextBadPassHold = 'Password must be at least 8 charecters! ';
var uniInSaleErrorTextPassConfHold = 'Passwords must match! ';
var uniInSaleErrorTextFirstNameHold = 'Your first name is? ';
var uniInSaleErrorTextLastNameHold = 'And a last name?';
var uniInSaleErrorTextBadEmail = '';
var uniInSaleErrorTextBadPass = '';
var uniInSaleErrorTextPassConf = '';
var uniInSaleErrorTextFirstName = '';
var uniInSaleErrorTextLastName = '';
var uniInSaleErrorTextEmailTaken = '';

/**  login sale email validation **/
function uniInSaleLoginEmailValidation(){
	var uniInSaleEmailLoginTest=$('#uniInSaleLoginEmail').val();
	var atpos=uniInSaleEmailLoginTest.indexOf("@");
	var dotpos=uniInSaleEmailLoginTest.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=uniInSaleEmailLoginTest.length){
		$('#uniInSaleErrorArrowEmail').fadeIn(300);
		$('#uniInSaleLoginErrorFace, #uniInSaleLoginErrorFaceBubble, #uniInSaleLoginErrorFaceText').fadeIn(300);
		uniInSaleLoginBadEmailText = uniInSaleLoginBadEmailHolder;
		uniInSaleLoginEmailValid = false;
		uniInSaleLoginErrorBubbleOpen = true;
	}else{
		$('#uniInSaleErrorArrowEmail').fadeOut(300);
		if(uniInSaleLoginPasswordValid!=false){
			$('#uniInSaleLoginErrorFace, #uniInSaleLoginErrorFaceBubble, #uniInSaleLoginErrorFaceText').fadeOut(300);
		};
		uniInSaleLoginBadEmailText = '';
		uniInSaleLoginEmailValid = true;
		uniInSaleLoginErrorBubbleOpen = false;
	};
	$('#uniInSaleLoginErrorFaceText').text(uniInSaleLoginBadEmailText+uniInSaleLoginBadPassText);
};
/**  login password validation **/
function uniInSaleLoginPasswordValidation(){
	var uniInSalePasswordTest = $('#uniInSaleLoginPass').val();
	if(uniInSalePasswordTest.length<8){
		$('#uniInSaleErrorArrowPass').fadeIn(300);
		$('#uniInSaleLoginErrorFace, #uniInSaleLoginErrorFaceBubble, #uniInSaleLoginErrorFaceText').fadeIn(300);
		uniInSaleLoginBadPassText = uniInSaleLoginBadPassHolder;
		uniInSaleLoginPasswordValid = false;
		uniInSaleLoginErrorBubbleOpen = true;
	}else{
		$('#uniInSaleErrorArrowPass').fadeOut(300);
		if(uniInSaleLoginEmailValid!=false){
			$('#uniInSaleLoginErrorFace, #uniInSaleLoginErrorFaceBubble, #uniInSaleLoginErrorFaceText').fadeOut(300);
		};
		uniInSaleLoginBadPassText = '';
		uniInSaleLoginPasswordValid = true;
		uniInSaleLoginErrorBubbleOpen = false;
	};
	$('#uniInSaleLoginErrorFaceText').text(uniInSaleLoginBadEmailText+uniInSaleLoginBadPassText);
};
$('#uniInSaleLoginPass').change(function(){
	uniInSaleLoginPasswordValidation();
});
$('#uniInSaleLoginSubmit').click(function(){
	uniInSaleLoginEmailValidation();
	uniInSaleLoginPasswordValidation();
	if(uniInSaleLoginEmailValid==false || uniInSaleLoginPasswordValid==false){
	event.preventDefault();
	}
});
/**  login extra validation code **/
$('#uniInSaleLoginErrorFace').click(function(){
	if(uniInSaleLoginErrorBubbleOpen == true){
		$('#uniInSaleLoginErrorFaceBubble, #uniInSaleLoginErrorFaceText').fadeOut(300);
		uniInSaleLoginErrorBubbleOpen = false;
	}else{
		$('#uniInSaleLoginErrorFaceBubble, #uniInSaleLoginErrorFaceText').fadeIn(300);
		uniInSaleLoginErrorBubbleOpen = true;
	};
});
$('#uniInSaleLoginEmail').change(function(){
	uniInSaleLoginEmailValidation();
});
/**  new member in sale email validation **/
function uniInSaleNewMemberEmailValidTest(){
	var uniInSaleEmailLoginTest=$('#uniInSaleSignUpEmail').val();
	var atpos=uniInSaleEmailLoginTest.indexOf("@");
	var dotpos=uniInSaleEmailLoginTest.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=uniInSaleEmailLoginTest.length){
		$('#uniInSaleErrorArrowNewMemEmail').fadeIn(300);
		$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeIn(300);
		uniInSaleErrorTextBadEmail = uniInSaleErrorTextBadEmailHold;
		uniInSaleNewMemberEmailValid = false;
		uniInSaleErrorBubbleOpen=true;
	}else{
		if(uniInSaleNewMemberEmailTakenValid!=false){
			$('#uniInSaleErrorArrowNewMemEmail').fadeOut(300);
		};
		uniInSaleNewMemberEmailValid = true;
		if(uniInSaleNewMemberEmailValid!=false && uniInSaleNewMemberPassValid!=false && uniInSaleNewMemberConfPassValid!=false && uniInSaleNewMemberFirstNameValid!=false && uniInSaleNewMemberLastNameValid!=false && uniInSaleNewMemberEmailTakenValid!=false){
			$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		uniInSaleErrorTextBadEmail = '';
		uniInSaleErrorBubbleOpen=false;
	};
	$('#uniInSaleLoginErrorFaceNewMemberText').text(uniInSaleErrorTextEmailTaken+uniInSaleErrorTextBadEmail+uniInSaleErrorTextBadPass+uniInSaleErrorTextPassConf+uniInSaleErrorTextFirstName+uniInSaleErrorTextLastName);
};
$('#uniInSaleSignUpEmail').change(function(){
	uniInSaleNewMemberEmailValidTest();
	var form_data = {
		email: $('#uniInSaleSignUpEmail').val(),
		requestType: 'CheckEmail',
		is_ajax: 1
	}; // end form_data
	$.ajax({
		type: "POST",
		url: 'request.php',
                data: form_data,
                success: function(response) {
                    if(response == 'EmailExists') {
						$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeIn(300);
						$('#uniInSaleErrorArrowNewMemEmail').fadeIn(300);
						uniInSaleErrorTextEmailTaken = 'That account already exists! ';
						uniInSaleNewMemberEmailTakenValid = false;
						$('#uniInSaleLoginErrorFaceNewMemberText').text(uniInSaleErrorTextEmailTaken+uniInSaleErrorTextBadEmail+uniInSaleErrorTextBadPass+uniInSaleErrorTextPassConf+uniInSaleErrorTextFirstName+uniInSaleErrorTextLastName);
                    } else if(response == 'success') {
						uniInSaleErrorTextEmailTaken = '';
						if(uniInSaleNewMemberEmailValid!=false){
							$('#uniInSaleErrorArrowNewMemEmail').fadeOut(300);
						};
						if(uniInSaleNewMemberEmailValid!=false && uniInSaleNewMemberPassValid!=false && uniInSaleNewMemberConfPassValid!=false && uniInSaleNewMemberFirstNameValid!=false && uniInSaleNewMemberLastNameValid!=false){
							$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeOut(300);
							$('#uniInSaleLoginErrorFaceNewMemberText').text(uniInSaleErrorTextEmailTaken+uniInSaleErrorTextBadEmail+uniInSaleErrorTextBadPass+uniInSaleErrorTextPassConf+uniInSaleErrorTextFirstName+uniInSaleErrorTextLastName);
							uniInSaleNewMemberEmailTakenValid = true;
						}
                    };
                } // end success
	});
});
/**  new member in sale password validation **/
function uniInSaleNewMemberPassValidTest(){
	var uniInSalePassTest = $('#uniInSaleSignUpPass1').val();
	if(uniInSalePassTest.length<8){
		$('#uniInSaleErrorArrowNewMemPass').fadeIn(300);
		$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeIn(300);
		uniInSaleErrorTextBadPass = uniInSaleErrorTextBadPassHold;
		uniInSaleErrorBubbleOpen=true;
		uniInSaleNewMemberPassValid = false;
	}else{
		$('#uniInSaleErrorArrowNewMemPass').fadeOut(300);
		uniInSaleNewMemberPassValid = true;
		if(uniInSaleNewMemberEmailValid!=false && uniInSaleNewMemberPassValid!=false && uniInSaleNewMemberConfPassValid!=false && uniInSaleNewMemberFirstNameValid!=false && uniInSaleNewMemberLastNameValid!=false && uniInSaleNewMemberEmailTakenValid!=false){
			$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		uniInSaleErrorTextBadPass = '';
		uniInSaleErrorBubbleOpen=false;
	};
	$('#uniInSaleLoginErrorFaceNewMemberText').text(uniInSaleErrorTextEmailTaken+uniInSaleErrorTextBadEmail+uniInSaleErrorTextBadPass+uniInSaleErrorTextPassConf+uniInSaleErrorTextFirstName+uniInSaleErrorTextLastName);
};
$('#uniInSaleSignUpPass1').change(function(){
	uniInSaleNewMemberPassValidTest();
});
/** new member password conf validation **/
function uniInSaleNewMemberConfPassValidTest(){
	var uniInSalePassTest = $('#uniInSaleSignUpPass2').val();
	if(uniInSalePassTest!=$('#uniInSaleSignUpPass1').val()){
		$('#uniInSaleErrorArrowNewMemConfPass').fadeIn(300);
		$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeIn(300);
		uniInSaleErrorTextPassConf = uniInSaleErrorTextPassConfHold;
		uniInSaleErrorBubbleOpen=true;
		uniInSaleNewMemberConfPassValid = false;
	}else{
		$('#uniInSaleErrorArrowNewMemConfPass').fadeOut(300);
		uniInSaleNewMemberConfPassValid = true;
		if(uniInSaleNewMemberEmailValid!=false && uniInSaleNewMemberPassValid!=false && uniInSaleNewMemberConfPassValid!=false && uniInSaleNewMemberFirstNameValid!=false && uniInSaleNewMemberLastNameValid!=false && uniInSaleNewMemberEmailTakenValid!=false){
			$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		uniInSaleErrorTextPassConf = '';
		uniInSaleErrorBubbleOpen=false;
	};
	$('#uniInSaleLoginErrorFaceNewMemberText').text(uniInSaleErrorTextEmailTaken+uniInSaleErrorTextBadEmail+uniInSaleErrorTextBadPass+uniInSaleErrorTextPassConf+uniInSaleErrorTextFirstName+uniInSaleErrorTextLastName);
};
$('#uniInSaleSignUpPass2').change(function(){
	uniInSaleNewMemberConfPassValidTest();
});
/**  new member in sale first name validation **/
function uniInSaleNewMemberFirstNameValidTest(){
	var uniInSaleFirstNameTest = $('#uniInSaleSignUpFirstName').val();
	if(uniInSaleFirstNameTest.length<1 || uniInSaleFirstNameTest == 'First Name'){
		$('#uniInSaleErrorArrowNewMemFirstName').fadeIn(300);
		$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeIn(300);
		uniInSaleErrorTextFirstName = uniInSaleErrorTextFirstNameHold;
		uniInSaleErrorBubbleOpen=true;
		uniInSaleNewMemberFirstNameValid = false;
	}else{
		$('#uniInSaleErrorArrowNewMemFirstName').fadeOut(300);
		uniInSaleNewMemberFirstNameValid = true;
		if(uniInSaleNewMemberEmailValid!=false && uniInSaleNewMemberPassValid!=false && uniInSaleNewMemberConfPassValid!=false && uniInSaleNewMemberFirstNameValid!=false && uniInSaleNewMemberLastNameValid!=false && uniInSaleNewMemberEmailTakenValid!=false){
			$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		uniInSaleErrorTextFirstName = '';
		uniInSaleErrorBubbleOpen=false;
	};
	$('#uniInSaleLoginErrorFaceNewMemberText').text(uniInSaleErrorTextEmailTaken+uniInSaleErrorTextBadEmail+uniInSaleErrorTextBadPass+uniInSaleErrorTextPassConf+uniInSaleErrorTextFirstName+uniInSaleErrorTextLastName);
};
$('#uniInSaleSignUpFirstName').change(function(){
	uniInSaleNewMemberFirstNameValidTest();
});
/**  new member in sale last name validation **/
function uniInSaleNewMemberLastNameValidTest(){
	var uniInSaleLastNameTest = $('#uniInSaleSignUpLastName').val();
	if(uniInSaleLastNameTest.length<1 || uniInSaleLastNameTest == 'Last Name'){
		$('#uniInSaleErrorArrowNewMemLastName').fadeIn(300);
		$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeIn(300);
		uniInSaleErrorTextLastName = uniInSaleErrorTextLastNameHold;
		uniInSaleErrorBubbleOpen=true;
		uniInSaleNewMemberLastNameValid = false;
	}else{
		$('#uniInSaleErrorArrowNewMemLastName').fadeOut(300);
		uniInSaleNewMemberLastNameValid = true;
		if(uniInSaleNewMemberEmailValid!=false && uniInSaleNewMemberPassValid!=false && uniInSaleNewMemberConfPassValid!=false && uniInSaleNewMemberFirstNameValid!=false && uniInSaleNewMemberLastNameValid!=false && uniInSaleNewMemberEmailTakenValid!=false){
			$('#uniInSaleLoginErrorFaceNewMember, #uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		uniInSaleErrorTextLastName = '';
		uniInSaleErrorBubbleOpen=false;
	};
	$('#uniInSaleLoginErrorFaceNewMemberText').text(uniInSaleErrorTextEmailTaken+uniInSaleErrorTextBadEmail+uniInSaleErrorTextBadPass+uniInSaleErrorTextPassConf+uniInSaleErrorTextFirstName+uniInSaleErrorTextLastName);
};
$('#uniInSaleSignUpLastName').change(function(){
	uniInSaleNewMemberLastNameValidTest();
});
/** new member in sale extra validation code **/
$('#uniInSaleLoginErrorFaceNewMember').click(function(){
	if(uniInSaleErrorBubbleOpen==true){
		$('#uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeOut();
		uniInSaleErrorBubbleOpen=false;
	}else{
		$('#uniInSaleLoginErrorFaceBubbleNewMember, #uniInSaleLoginErrorFaceNewMemberText').fadeIn();
		uniInSaleErrorBubbleOpen=true;
	};
});
$('#uniInSaleSignUpSubmit').click(function(){
	uniInSaleNewMemberEmailValidTest();
	uniInSaleNewMemberPassValidTest();
	uniInSaleNewMemberConfPassValidTest();
	uniInSaleNewMemberFirstNameValidTest();
	uniInSaleNewMemberLastNameValidTest();
	if(uniInSaleNewMemberEmailValid==true && uniInSaleNewMemberPassValid==true && uniInSaleNewMemberConfPassValid==true && uniInSaleNewMemberFirstNameValid==true && uniInSaleNewMemberLastNameValid==true && uniInSaleNewMemberEmailTakenValid==true){
		//nothing. let it go
	}else{
		event.preventDefault();
	};
	//};
});
/*********          TEMP NO FACEBOOK!!!!!!             ***********/
$('#uniCheckOutLoginFacebook, #checkOutLoginFacebook').click(function(){
	event.preventDefault();
	alert('Sorry, Facebook login is unavailable during our beta period.');
});
}); // end ready