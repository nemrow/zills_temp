// JavaScript Document
$(document).ready(function(){
//-------------------------------------------------------------------------- begin code -----------//
//-------------------------------------------------------------------------- size buttons -----------//
var sizeSelected = undefined;
$('.sizeS').click(function(){
	$(this).addClass('ssSizeSelected');
	$('.sizeM, .sizeL, .sizeXL').removeClass('ssSizeSelected');
	sizeSelected = 'small';
}); // end click
$('.sizeM').click(function(){
	$(this).addClass('ssSizeSelected');
	$('.sizeS, .sizeL, .sizeXL').removeClass('ssSizeSelected');
	sizeSelected = 'medium';
}); // end click
$('.sizeL').click(function(){
	$(this).addClass('ssSizeSelected');
	$('.sizeM, .sizeS, .sizeXL').removeClass('ssSizeSelected');
	sizeSelected = 'large';
}); // end click
$('.sizeXL').click(function(){
	$(this).addClass('ssSizeSelected');
	$('.sizeM, .sizeL, .sizeS').removeClass('ssSizeSelected');
	sizeSelected = 'xlarge';
}); // end click
//-------------------------------------------------------------------------- help -----------//
var tipNum = 1;
var helpOpen = 0;
$('.openHelp').click(function(){
	if(helpOpen == 0){
	$('.helpShell').slideDown(600);
	$('.helpNextBtn').fadeIn(300);
	$('.hStep1').delay(600).fadeIn(300);
	helpOpen = 1;
	$('#inSaleLoginX').trigger('click');
}; // end if
}); // end click
$('.helpNextBtn').click(function(){
	if(tipNum == 1){
		$('.hStep1').fadeOut(300);
		$('.hStep2').delay(300).fadeIn(300);
		tipNum = 2;
		return false;
	};
	if(tipNum == 2){
		$('.hStep2').fadeOut(300);
		$('.hStep3').delay(300).fadeIn(300);
		tipNum = 3;
		return false;
	};
	if(tipNum == 3){
		$('.hStep3').fadeOut(300);
		$('.hStep4').delay(300).fadeIn(300);
		tipNum = 4;
		return false;
	};
	if(tipNum == 4){
		$('.hStep4').fadeOut(300);
		$('.hStep5').delay(300).fadeIn(300);
		tipNum = 5;
		return false;
	};
	if(tipNum == 5){
		$('.hStep5').fadeOut(300);
		$('.hStep6').delay(300).fadeIn(300);
		tipNum = 6;
		return false;
	};
	if(tipNum == 6){
		$('.hStep6').fadeOut(300);
		$('.hStep7').delay(300).fadeIn(300);
		$('.hStep7').delay(1200).fadeOut(300);
		$('.helpShell').delay(1500).slideUp(600);
		$('.helpNextBtn').fadeOut(300);
		tipNum = 1;
		helpOpen = 0;
		return false;
	};
}); // end click
$('.helpX').click(function(){
	$('.hStep1, .hStep2, .hStep3, .hStep4, .hStep5, .hStep6, .hStep7').fadeOut(300);
	$('.helpShell').delay(300).slideUp(600);
	tipNum = 1;
	helpOpen = 0;
}); // end click
//--------------------------------------------------------------------------- checkout ------------//
$('.ssIWantIn').click(function(){
	$('.helpX').trigger('click');
});
var checkoutBtnType = 0;
$('.checkOutloginBtn1').hover(
	function(){
		if(checkoutBtnType==0){
		$(this).stop().animate({
			'width':'202px',
			'left': '54px'
		},100);
		};
	},
	function(){
	if(checkoutBtnType==0){
		$(this).stop().animate({
			'width':'210px',
			'left':'50px'
		},100);
		};
	}
); // end hover
$('.checkOutloginBtn2').hover(
	function(){
		if(checkoutBtnType==0){
		$(this).stop().animate({
			'width':'202px',
			'left':'306px'
		},100);
		};
	},
	function(){
		if(checkoutBtnType==0){
		$(this).stop().animate({
			'width':'210px',
			'left':'302px'
		},100);
		};
	}
);
$('.checkOutloginBtn3').hover(
	function(){
		if(checkoutBtnType==0){
		$(this).stop().animate({
			'width':'262px',
			'left':'150px'
		},100);
		};
	},
	function(){
		if(checkoutBtnType==0){
		$(this).stop().animate({
			'width':'270px',
			'left':'146px'
		},100);
		};
	}
);
$('.inSaleFAQOpen').click(function(){
	$('.preAmznCheckoutFAQ1').animate({
	'left':'5px'
	},1000);
	$('.preAmznCheckoutFAQ2').delay(900).fadeIn(600);
});
/******** insale login/signup dropdown *******/
$('#checkOutLoginMember').click(function(){
	$('#inSaleLoginNewMember').css('display','none');
	$('#checkOutLoginNewMember').fadeIn();
	if(checkoutBtnType==0){
	$('#checkOutLoginMember, #checkOutOptionText').fadeOut();
	}
	$('#checkOutLoginFacebook').animate({
		'width':'160px',
		'height':'27px',
		'left':'107px',
		'top':'58px'
	});
	$('#checkOutLoginNewMember, #checkOutLoginMember').animate({
		'width':'160px',
		'height':'27px',
		'left':'295px',
		'top':'58px'
	});
	if(checkoutBtnType==0){
	$('#inSaleMemberLogin').delay(400).fadeIn(800);
	}else{
		$('#inSaleMemberLogin').fadeIn(800);
	};
	$('#checkOutPoweredShellP').fadeOut();
	$('#checkOutPoweredShellImg').delay(300).animate({
		'left':'10px',
		'top':'10px',
		'width':'90px',
		'height':'29px'
	},1200);
	$('#inSaleTypeOfLoginHead').text('Member Login').delay(600).fadeIn(800);
	checkoutBtnType = 1;
});
$('#inSaleLoginEmail').focus(function(){
	if($(this).val()=='Email'){
		$(this).val('').css('background-color','#FFF');
	};
	}).blur(function(){
	if($(this).val()==''){
		$(this).val('Email');
	};
}); // end focus
$('#inSaleLoginPass').focus(function(){
	if($('#inSaleLoginPassLab').text()=='Password'){
		$('#inSaleLoginPass').css('background-color','#FFF');
		$('#inSaleLoginPassLab').text('');
	};
}).blur(function(){
	if($('#inSaleLoginPass').val()==''){
		$('#inSaleLoginPass').css('background-color','transparent');
		$('#inSaleLoginPassLab').text('Password');
	};
});
$('#checkOutLoginNewMember').click(function(){
$	('#checkOutLoginMember').fadeIn();
	if(checkoutBtnType==0){
	$('#inSaleLoginNewMember').delay(400).fadeIn(800);
	}else{
	$('#inSaleLoginNewMember').fadeIn(800);
	};
	$('#checkOutLoginNewMember, #checkOutOptionText').fadeOut();
	$('#checkOutLoginFacebook').animate({
		'width':'160px',
		'height':'27px',
		'left':'107px',
		'top':'58px'
	});
	$('#checkOutLoginMember, #checkOutLoginNewMember').animate({
		'width':'160px',
		'height':'27px',
		'left':'295px',
		'top':'58px'
	});
	$('#inSaleMemberLogin').css('display','none');
	$('#checkOutPoweredShellP').fadeOut();
	$('#checkOutPoweredShellImg').delay(300).animate({
		'left':'10px',
		'top':'10px',
		'width':'90px',
		'height':'29px'
	},1200);
	$('#inSaleTypeOfLoginHead').text('New Member Signup').delay(600).fadeIn(800);
	checkoutBtnType = 2;
});
$('#inSaleSignUpEmail').focus(function(){
	if($(this).val()=='Email'){
		$(this).val('');
	};
}).blur(function(){
	if($(this).val()==''){
		$(this).val('Email');
	};
});
$('#inSaleSignUpFirstName').focus(function(){
	if($(this).val()=='First Name'){
		$(this).val('');
	};
}).blur(function(){
	if($(this).val()==''){
		$(this).val('First Name');
	};
});
$('#inSaleSignUpLastName').focus(function(){
	if($(this).val()=='Last Name'){
		$(this).val('');
	};
}).blur(function(){
	if($(this).val()==''){
		$(this).val('Last Name');
	};
});
$('#inSaleSignUpPass1').focus(function(){
	if($('#inSaleSignUpPassLab1').text()=='Password'){
		$('#inSaleSignUpPass1').css('background-color','#FFF');
		$('#inSaleSignUpPassLab1').text('Password');
	};
}).blur(function(){
	if($('#inSaleSignUpPass1').val()==''){
		$('#inSaleSignUpPass1').css('background-color','transparent');
		$('#inSaleSignUpPassLab1').text('Password');
	};
});
$('#inSaleSignUpPass2').focus(function(){
	if($('#inSaleSignUpPassLab2').text()=='Confirm Password'){
		$('#inSaleSignUpPass2').css('background-color','#FFF');
		$('#inSaleSignUpPassLab2').text('Password');
	};
}).blur(function(){
	if($('#inSaleSignUpPass2').val()==''){
		$('#inSaleSignUpPass2').css('background-color','transparent');
		$('#inSaleSignUpPassLab2').text('Confirm Password');
	};
});
$('#inSaleLoginX').click(function(){
	$('#socialSaleCheckoutShell').slideUp(800);
});
$('.preAmznCheckoutGoToAmznBtn').click(function(){
if(!($('.preAmznCheckoutTermsAndCondCheck').is(':checked'))){
	alert('Please check that you have read and understood the Zillionears Terms and Conditions');
	$('.preAmznCheckoutTermsAndCond, .preAmznCheckoutTermsAndCond span').css('color','red');
	event.preventDefault();
};
});
/******** valitation *************/
var inSaleLoginEmailValid = undefined;
var inSaleLoginPasswordValid = undefined;
var inSaleLoginBadPassText = '';
var inSaleLoginBadEmailText = '';
var inSaleLoginBadPassHolder = 'Passwords must be at least 8 charecters!';
var inSaleLoginBadEmailHolder = 'No fake emails you fool! ';
var inSaleLoginErrorBubbleOpen = false;

var inSaleNewMemberEmailValid = undefined;
var inSaleNewMemberEmailTakenValid = undefined;
var inSaleNewMemberPassValid = undefined;
var inSaleNewMemberConfPassValid = undefined;
var inSaleNewMemberFirstNameValid = undefined;
var inSaleNewMemberLastNameValid = undefined;
var inSaleErrorBubbleOpen = false;
var inSaleErrorTextBadEmailHold = 'No fake emails! ';
var inSaleErrorTextBadPassHold = 'Password must be at least 8 charecters! ';
var inSaleErrorTextPassConfHold = 'Passwords must match! ';
var inSaleErrorTextFirstNameHold = 'Your first name is? ';
var inSaleErrorTextLastNameHold = 'And a last name?';
var inSaleErrorTextBadEmail = '';
var inSaleErrorTextBadPass = '';
var inSaleErrorTextPassConf = '';
var inSaleErrorTextFirstName = '';
var inSaleErrorTextLastName = '';
var inSaleErrorTextEmailTaken = '';

/**  login sale email validation **/
function inSaleLoginEmailValidation(){
	var inSaleEmailLoginTest=$('#inSaleLoginEmail').val();
	var atpos=inSaleEmailLoginTest.indexOf("@");
	var dotpos=inSaleEmailLoginTest.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=inSaleEmailLoginTest.length){
		$('#insSaleErrorArrowEmail').fadeIn(300);
		$('#inSaleLoginErrorFace, #inSaleLoginErrorFaceBubble, #inSaleLoginErrorFaceText').fadeIn(300);
		inSaleLoginBadEmailText = inSaleLoginBadEmailHolder;
		inSaleLoginEmailValid = false;
		inSaleLoginErrorBubbleOpen = true;
	}else{
		$('#insSaleErrorArrowEmail').fadeOut(300);
		if(inSaleLoginPasswordValid!=false){
			$('#inSaleLoginErrorFace, #inSaleLoginErrorFaceBubble, #inSaleLoginErrorFaceText').fadeOut(300);
		};
		inSaleLoginBadEmailText = '';
		inSaleLoginEmailValid = true;
		inSaleLoginErrorBubbleOpen = false;
	};
	$('#inSaleLoginErrorFaceText').text(inSaleLoginBadEmailText+inSaleLoginBadPassText);
};
/**  login password validation **/
function inSaleLoginPasswordValidation(){
	var inSalePasswordTest = $('#inSaleLoginPass').val();
	if(inSalePasswordTest.length<8){
		$('#insSaleErrorArrowPass').fadeIn(300);
		$('#inSaleLoginErrorFace, #inSaleLoginErrorFaceBubble, #inSaleLoginErrorFaceText').fadeIn(300);
		inSaleLoginBadPassText = inSaleLoginBadPassHolder;
		inSaleLoginPasswordValid = false;
		inSaleLoginErrorBubbleOpen = true;
	}else{
		$('#insSaleErrorArrowPass').fadeOut(300);
		if(inSaleLoginEmailValid!=false){
			$('#inSaleLoginErrorFace, #inSaleLoginErrorFaceBubble, #inSaleLoginErrorFaceText').fadeOut(300);
		};
		inSaleLoginBadPassText = '';
		inSaleLoginPasswordValid = true;
		inSaleLoginErrorBubbleOpen = false;
	};
	$('#inSaleLoginErrorFaceText').text(inSaleLoginBadEmailText+inSaleLoginBadPassText);
};
$('#inSaleLoginPass').change(function(){
	inSaleLoginPasswordValidation();
});
$('#inSaleLoginSubmit').click(function(){
	inSaleLoginEmailValidation();
	inSaleLoginPasswordValidation();
	if(inSaleLoginEmailValid==false || inSaleLoginPasswordValid==false){
	event.preventDefault();
	}
});
/**  login extra validation code **/
$('#inSaleLoginErrorFace').click(function(){
	if(inSaleLoginErrorBubbleOpen == true){
		$('#inSaleLoginErrorFaceBubble, #inSaleLoginErrorFaceText').fadeOut(300);
		inSaleLoginErrorBubbleOpen = false;
	}else{
		$('#inSaleLoginErrorFaceBubble, #inSaleLoginErrorFaceText').fadeIn(300);
		inSaleLoginErrorBubbleOpen = true;
	};
});
$('#inSaleLoginEmail').change(function(){
	inSaleLoginEmailValidation();
});
/**  new member in sale email validation **/
function inSaleNewMemberEmailValidTest(){
	var inSaleEmailLoginTest=$('#inSaleSignUpEmail').val();
	var atpos=inSaleEmailLoginTest.indexOf("@");
	var dotpos=inSaleEmailLoginTest.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=inSaleEmailLoginTest.length){
		$('#insSaleErrorArrowNewMemEmail').fadeIn(300);
		$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeIn(300);
		inSaleErrorTextBadEmail = inSaleErrorTextBadEmailHold;
		inSaleNewMemberEmailValid = false;
		inSaleErrorBubbleOpen=true;
	}else{
		if(inSaleNewMemberEmailTakenValid!=false){
			$('#insSaleErrorArrowNewMemEmail').fadeOut(300);
		};
		inSaleNewMemberEmailValid = true;
		if(inSaleNewMemberEmailValid!=false && inSaleNewMemberPassValid!=false && inSaleNewMemberConfPassValid!=false && inSaleNewMemberFirstNameValid!=false && inSaleNewMemberLastNameValid!=false && inSaleNewMemberEmailTakenValid!=false){
			$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		inSaleErrorTextBadEmail = '';
		inSaleErrorBubbleOpen=false;
	};
	$('#inSaleLoginErrorFaceNewMemberText').text(inSaleErrorTextEmailTaken+inSaleErrorTextBadEmail+inSaleErrorTextBadPass+inSaleErrorTextPassConf+inSaleErrorTextFirstName+inSaleErrorTextLastName);
};
$('#inSaleSignUpEmail').change(function(){
	inSaleNewMemberEmailValidTest();
	var form_data = {
		email: $('#inSaleSignUpEmail').val(),
		requestType: 'CheckEmail',
		is_ajax: 1
	}; // end form_data
	$.ajax({
		type: "POST",
		url: 'request.php',
                data: form_data,
                success: function(response) {
                    if(response == 'EmailExists') {
						$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeIn(300);
						$('#insSaleErrorArrowNewMemEmail').fadeIn(300);
						inSaleErrorTextEmailTaken = 'That account already exists! ';
						inSaleNewMemberEmailTakenValid = false;
						$('#inSaleLoginErrorFaceNewMemberText').text(inSaleErrorTextEmailTaken+inSaleErrorTextBadEmail+inSaleErrorTextBadPass+inSaleErrorTextPassConf+inSaleErrorTextFirstName+inSaleErrorTextLastName);
                    } else if(response == 'success') {
						inSaleErrorTextEmailTaken = '';
						if(inSaleNewMemberEmailValid!=false){
							$('#insSaleErrorArrowNewMemEmail').fadeOut(300);
						};
						if(inSaleNewMemberEmailValid!=false && inSaleNewMemberPassValid!=false && inSaleNewMemberConfPassValid!=false && inSaleNewMemberFirstNameValid!=false && inSaleNewMemberLastNameValid!=false){
							$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeOut(300);
							$('#inSaleLoginErrorFaceNewMemberText').text(inSaleErrorTextEmailTaken+inSaleErrorTextBadEmail+inSaleErrorTextBadPass+inSaleErrorTextPassConf+inSaleErrorTextFirstName+inSaleErrorTextLastName);
							inSaleNewMemberEmailTakenValid = true;
						}
                    };
                } // end success
	});
});
/**  new member in sale password validation **/
function inSaleNewMemberPassValidTest(){
	var inSalePassTest = $('#inSaleSignUpPass1').val();
	if(inSalePassTest.length<8){
		$('#insSaleErrorArrowNewMemPass').fadeIn(300);
		$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeIn(300);
		inSaleErrorTextBadPass = inSaleErrorTextBadPassHold;
		inSaleErrorBubbleOpen=true;
		inSaleNewMemberPassValid = false;
	}else{
		$('#insSaleErrorArrowNewMemPass').fadeOut(300);
		inSaleNewMemberPassValid = true;
		if(inSaleNewMemberEmailValid!=false && inSaleNewMemberPassValid!=false && inSaleNewMemberConfPassValid!=false && inSaleNewMemberFirstNameValid!=false && inSaleNewMemberLastNameValid!=false && inSaleNewMemberEmailTakenValid!=false){
			$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		inSaleErrorTextBadPass = '';
		inSaleErrorBubbleOpen=false;
	};
	$('#inSaleLoginErrorFaceNewMemberText').text(inSaleErrorTextEmailTaken+inSaleErrorTextBadEmail+inSaleErrorTextBadPass+inSaleErrorTextPassConf+inSaleErrorTextFirstName+inSaleErrorTextLastName);
};
$('#inSaleSignUpPass1').change(function(){
	inSaleNewMemberPassValidTest();
});
/** new member password conf validation **/
function inSaleNewMemberConfPassValidTest(){
	var inSalePassTest = $('#inSaleSignUpPass2').val();
	if(inSalePassTest!=$('#inSaleSignUpPass1').val()){
		$('#insSaleErrorArrowNewMemConfPass').fadeIn(300);
		$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeIn(300);
		inSaleErrorTextPassConf = inSaleErrorTextPassConfHold;
		inSaleErrorBubbleOpen=true;
		inSaleNewMemberConfPassValid = false;
	}else{
		$('#insSaleErrorArrowNewMemConfPass').fadeOut(300);
		inSaleNewMemberConfPassValid = true;
		if(inSaleNewMemberEmailValid!=false && inSaleNewMemberPassValid!=false && inSaleNewMemberConfPassValid!=false && inSaleNewMemberFirstNameValid!=false && inSaleNewMemberLastNameValid!=false && inSaleNewMemberEmailTakenValid!=false){
			$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		inSaleErrorTextPassConf = '';
		inSaleErrorBubbleOpen=false;
	};
	$('#inSaleLoginErrorFaceNewMemberText').text(inSaleErrorTextEmailTaken+inSaleErrorTextBadEmail+inSaleErrorTextBadPass+inSaleErrorTextPassConf+inSaleErrorTextFirstName+inSaleErrorTextLastName);
};
$('#inSaleSignUpPass2').change(function(){
	inSaleNewMemberConfPassValidTest();
});
/**  new member in sale first name validation **/
function inSaleNewMemberFirstNameValidTest(){
	var inSaleFirstNameTest = $('#inSaleSignUpFirstName').val();
	if(inSaleFirstNameTest.length<1 || inSaleFirstNameTest == 'First Name'){
		$('#insSaleErrorArrowNewMemFirstName').fadeIn(300);
		$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeIn(300);
		inSaleErrorTextFirstName = inSaleErrorTextFirstNameHold;
		inSaleErrorBubbleOpen=true;
		inSaleNewMemberFirstNameValid = false;
	}else{
		$('#insSaleErrorArrowNewMemFirstName').fadeOut(300);
		inSaleNewMemberFirstNameValid = true;
		if(inSaleNewMemberEmailValid!=false && inSaleNewMemberPassValid!=false && inSaleNewMemberConfPassValid!=false && inSaleNewMemberFirstNameValid!=false && inSaleNewMemberLastNameValid!=false && inSaleNewMemberEmailTakenValid!=false){
			$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		inSaleErrorTextFirstName = '';
		inSaleErrorBubbleOpen=false;
	};
	$('#inSaleLoginErrorFaceNewMemberText').text(inSaleErrorTextEmailTaken+inSaleErrorTextBadEmail+inSaleErrorTextBadPass+inSaleErrorTextPassConf+inSaleErrorTextFirstName+inSaleErrorTextLastName);
};
$('#inSaleSignUpFirstName').change(function(){
	inSaleNewMemberFirstNameValidTest();
});
/**  new member in sale last name validation **/
function inSaleNewMemberLastNameValidTest(){
	var inSaleLastNameTest = $('#inSaleSignUpLastName').val();
	if(inSaleLastNameTest.length<1 || inSaleLastNameTest == 'Last Name'){
		$('#insSaleErrorArrowNewMemLastName').fadeIn(300);
		$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeIn(300);
		inSaleErrorTextLastName = inSaleErrorTextLastNameHold;
		inSaleErrorBubbleOpen=true;
		inSaleNewMemberLastNameValid = false;
	}else{
		$('#insSaleErrorArrowNewMemLastName').fadeOut(300);
		inSaleNewMemberLastNameValid = true;
		if(inSaleNewMemberEmailValid!=false && inSaleNewMemberPassValid!=false && inSaleNewMemberConfPassValid!=false && inSaleNewMemberFirstNameValid!=false && inSaleNewMemberLastNameValid!=false && inSaleNewMemberEmailTakenValid!=false){
			$('#inSaleLoginErrorFaceNewMember, #inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeOut(300);
		}
		inSaleErrorTextLastName = '';
		inSaleErrorBubbleOpen=false;
	};
	$('#inSaleLoginErrorFaceNewMemberText').text(inSaleErrorTextEmailTaken+inSaleErrorTextBadEmail+inSaleErrorTextBadPass+inSaleErrorTextPassConf+inSaleErrorTextFirstName+inSaleErrorTextLastName);
};
$('#inSaleSignUpLastName').change(function(){
	inSaleNewMemberLastNameValidTest();
});
/** new member in sale extra validation code **/
$('#inSaleLoginErrorFaceNewMember').click(function(){
	if(inSaleErrorBubbleOpen==true){
		$('#inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeOut();
		inSaleErrorBubbleOpen=false;
	}else{
		$('#inSaleLoginErrorFaceBubbleNewMember, #inSaleLoginErrorFaceNewMemberText').fadeIn();
		inSaleErrorBubbleOpen=true;
	};
});
$('#inSaleSignUpSubmit').click(function(){
	inSaleNewMemberEmailValidTest();
	inSaleNewMemberPassValidTest();
	inSaleNewMemberConfPassValidTest();
	inSaleNewMemberFirstNameValidTest();
	inSaleNewMemberLastNameValidTest();
	if(inSaleNewMemberEmailValid==true && inSaleNewMemberPassValid==true && inSaleNewMemberConfPassValid==true && inSaleNewMemberFirstNameValid==true && inSaleNewMemberLastNameValid==true && inSaleNewMemberEmailTakenValid==true){
		//nothing. let it go
	}else{
		event.preventDefault();
	};
	//};
});
//-------------------------------------------------------------------------- footer -------------//
$('.sSLoggedInName').hover(function(){
	$('.sSLoggedInHoverBtnsShell').css('display','block');
	$('.sSLoggedInHoverBtnsShell3').stop().animate({
		'top':'0px'
	},100); // end animate
	$('.newSocialSaleArrowBubble').stop().fadeOut(300);
	},
	function(){
	$('.sSLoggedInHoverBtnsShell').css('display','none');
	$('.sSLoggedInHoverBtnsShell3').css('top','40px');
	}
);
//-------------------------------------------------------------------------- random -------------//
$('.zukaFullBack, .zukaClose').live('click',function(){
	$('.zukaFullBack, .zukaShell').fadeOut(300);
});
//-------------------------------------------------------------------------- fancybox -----------//
$('#popOutSocialSale').fancybox();
$('#shatBoard').tinyscrollbar({ sizethumb: 40 });
$('#openLoginBox').fancybox();
//-------------------------------------------------------------------------- end code -----------//
}); // end ready