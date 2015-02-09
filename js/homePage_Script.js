// JavaScript Document
$(document).ready(function(){
$('#openContactUs').fancybox();
$('#openHaircutPop').fancybox();
$('#openContactUsIntro').fancybox();
$('#openLogin').fancybox();
$('#openIndexIntroPricingShell').fancybox();
$('input.contactUsEmail').focus(function(){
	if($(this).val() == ('Your Email')){
		$(this).val('');
	}else{
	return false;
	};
}); // end focus
$('input.contactUsSubject').focus(function(){
	if($(this).val() == ('Subject')){
		$(this).val('');
	}else{
	return false;
	};
}); // end focus
$('textarea.contactUsMessage').live('focus',function(){
	if($(this).text() == ('Message')){
		$(this).text('');
	}else{
	return false;
	};
}); // end focus
$('input.contactUsEmail').blur(function(){
	if($(this).val() == ('')){
		$(this).val('Your Email');
	}else{
	return false;
	};
}); // end focus
$('input.contactUsSubject').blur(function(){
	if($(this).val() == ('')){
		$(this).val('Subject');
	}else{
	return false;
	};
}); // end focus
$('textarea.contactUsMessage').live('blur',function(){
	if($(this).text() == ('')){
		$(this).text('Message');
	}else{
	return false;
	};
}); // end focus
$('#openContactUsSentBox').fancybox();
$('p.contactUsSend').click(function(){
	$('#fancybox-close, #openContactUsSentBox').trigger('click');
}); // end click
$('#openContactUsIntro').click(function(){
	$('.contactUsSent, #contactUsNewError').html('');
	$('.contactUsSend').css('display','block');
	$('.contactUsEmail').val('Your Email');
	$('.contactUsSubject').val('Subject');
	$('.contactUsMessage').remove();
	$('.contactUsSubject').after('<textarea class="contactUsMessage">Message</textarea>');
});
/*************************************************************************************** login ************************/
$('#boringLoginPass1, #boringLoginPass2').focus(function(){
	if($(this).val()==''){
		$(this).css('background-color','#FFF');
	};
}).blur(function(){
	if($(this).val()==''){
		$(this).css('background-color','transparent');
	};
}); // end focus/blur
function basicFocus(id,name){
	if($(id).val()==name){
		$(id).val('');
	}
};
function basicBlur(id,name){
	if($(id).val()==''){
		$(id).val(name);
	}
};
// paypal email & check payments
$('#howWePayYouPaypalInput').focus(function(){
	basicFocus('#howWePayYouPaypalInput','Paypal Email');
}).blur(function(){
	basicBlur('#howWePayYouPaypalInput','Paypal Email');
});
$('#howWePayYouCheckInputAddress1').focus(function(){
	basicFocus('#howWePayYouCheckInputAddress1','Address');
}).blur(function(){
	basicBlur('#howWePayYouCheckInputAddress1','Address');
});
$('#howWePayYouCheckInputAddress2').focus(function(){
	basicFocus('#howWePayYouCheckInputAddress2','City');
}).blur(function(){
	basicBlur('#howWePayYouCheckInputAddress2','City');
});
$('#howWePayYouCheckInputAddress3').focus(function(){
	basicFocus('#howWePayYouCheckInputAddress3','State');
}).blur(function(){
	basicBlur('#howWePayYouCheckInputAddress3','State');
});
$('#howWePayYouCheckInputAddress4').focus(function(){
	basicFocus('#howWePayYouCheckInputAddress4','Zip Code');
}).blur(function(){
	basicBlur('#howWePayYouCheckInputAddress4','Zip Code');
});
$('#boringLoginEmail').focus(function(){
	basicFocus('#boringLoginEmail','Email');
}).blur(function(){
	basicBlur('#boringLoginEmail','Email');
});
$('#boringLoginFName').focus(function(){
	basicFocus('#boringLoginFName','First Name');
}).blur(function(){
	basicBlur('#boringLoginFName','First Name');
});
$('#boringLoginLName').focus(function(){
	basicFocus('#boringLoginLName','Last Name');
}).blur(function(){
	basicBlur('#boringLoginLName','Last Name');
});
/*********************************************************************************** validate boring reg *******************/
var boringValidEmail = false;
var boringValidPass = false;
var boringValidConfPass = false;
var boringValidFName = false;
var boringValidLName = false;
function boringEmailValidation(){
	var emailTest=$('#boringLoginEmail').val();
	var atpos=emailTest.indexOf("@");
	var dotpos=emailTest.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailTest.length){
		$('.boringErrorMessageEmail').text('You need an email!');
		boringValidEmail = false;
		$('#boringLoginErrorArrowEmail').fadeIn();
	}else{
		boringValidEmail = true;
		$('.boringErrorMessageEmail').text('');
		$('#boringLoginErrorArrowEmail').fadeOut();
	};
};
$('#boringLoginEmail').change(function(){
	var form_data = {
		email: $('#boringLoginEmail').val(),
		requestType: 'CheckEmail',
		is_ajax: 1
	}; // end form_data
	$.ajax({
		type: "POST",
		url: 'request.php',
                data: form_data,
                success: function(response) {
                    if(response == 'EmailExists') {
						$('.boringErrorMessageEmail').text('An account with that email exists!');
                    } else if(response == 'success') {
						$('.boringErrorMessageEmail').text('No account with that email yet!!');
                    };
                } // end success
	});
	boringEmailValidation();
});
function boringPassValidation(){
	if($('#boringLoginPass1').val()=='' || ($('#boringLoginPass1').val()).length<8){
		$('.boringErrorMessagePass').text('Password must be at least 8 charecters!');
		boringValidPass = false;
		$('#boringLoginErrorArrowPass').fadeIn();
	}else{
		$('.boringErrorMessagePass').text('');
		boringValidPass = true;
		$('#boringLoginErrorArrowPass').fadeOut();
	};
};
$('#boringLoginPass1').change(function(){
	boringPassValidation();
})
function boringConfPassValidation(){
	if($('#boringLoginPass2').val()!=$('#boringLoginPass1').val() || $('#boringLoginPass2').val()==''){
		$('.boringErrorMessagePass2').text('Password must match the one above!');
		boringValidConfPass = false;
		$('#boringLoginErrorArrowPass2').fadeIn();
	}else{
		$('.boringErrorMessagePass2').text('');
		boringValidConfPass = true;
		$('#boringLoginErrorArrowPass2').fadeOut();
	};
};
$('#boringLoginPass2').change(function(){
	boringConfPassValidation();
});
function boringFNameValidation(){
	if($('#boringLoginFName').val()=='' || $('#boringLoginFName').val()=='First Name'){
		$('.boringErrorMessageFName').text('Include your name!');
		boringValidFName = false;
		$('#boringLoginErrorArrowFName').fadeIn();
	}else{
		$('.boringErrorMessageFName').text('');
		boringValidFName = true;
		$('#boringLoginErrorArrowFName').fadeOut();
	};
};
$('#boringLoginFName').change(function(){
	boringFNameValidation();
});
function boringLNameValidation(){
	if($('#boringLoginLName').val()=='' || $('#boringLoginLName').val()=='Last Name'){
		$('.boringErrorMessageLName').text('Whats your last name?');
		boringValidLName = false;
		$('#boringLoginErrorArrowLName').fadeIn();
	}else{
		$('.boringErrorMessageLName').text('');
		boringValidLName = true;
		$('#boringLoginErrorArrowLName').fadeOut();
	};
};
$('#boringLoginLName').change(function(){
	boringLNameValidation();
});
$('#boringLoginSubmit').click(function(){
	boringEmailValidation();
	boringPassValidation();
	boringConfPassValidation();
	boringFNameValidation();
	boringLNameValidation();
	if(boringValidEmail==false || boringValidPass==false || boringValidConfPass==false || boringValidFName==false || boringValidLName==false){
	event.preventDefault();
	};
});
/************************************************************************************************** demo ******************************/
var slideShowNext = 2;
function slideBotClick1(){
	$('.homeDemoReplayCover').css('display','block');
		$('.homeSlideBounceShell').stop().animate({
			'top':'0px',
			'left':'0px'
		},600);
		$('.homeSlideNavCircle').css('background-position','0px 0px');
		$('.homeSlideNavCircle1').css('background-position','0px 11px');
		slideShowNext = 2;
};
function slideBotClick2(){
		$('.homeSlideBounceShell').stop().animate({
			'top':'0px',
			'left':'-310px'
		},600);
		$('.homeSlideNavCircle').css('background-position','0px 0px');
		$('.homeSlideNavCircle2').css('background-position','0px 11px');
		slideShowNext = 3;
}; // end click slide 2
function slideBotClick3(){
	$('.homeSlideBounceShell').stop().animate({
			'top':'-255px',
			'left':'0px'
		},600);
		$('.homeSlideNavCircle').css('background-position','0px 0px');
		$('.homeSlideNavCircle3').css('background-position','0px 11px');
		slideShowNext = 4;
}; // end click slide 3
function slideBotClick4(){
	$('.homeSlideBounceShell').stop().animate({
			'top':'-255px',
			'left':'-310px'
		},600);
		$('.homeSlideNavCircle').css('background-position','0px 0px');
		$('.homeSlideNavCircle4').css('background-position','0px 11px');
		slideShowNext = 1;
}; // end click slide 4
$('.homeSlideNavCircle1').click(function(){slideBotClick1();});
$('.homeSlideNavCircle2').click(function(){slideBotClick2();});
$('.homeSlideNavCircle3').click(function(){slideBotClick3();});
$('.homeSlideNavCircle4').click(function(){slideBotClick4();});
var homeSlideRotate = setInterval(function(){
	if(slideShowNext==1){
	slideBotClick1();
	}else if(slideShowNext==2){
	slideBotClick2();
	}else if(slideShowNext==3){
	slideBotClick3();
	}else if(slideShowNext==4){
	slideBotClick4();
	};
},10000);
$('.homeSlideNavCircle').click(function(){
	clearInterval(homeSlideRotate);
});
$('.homeFunCash').hover(
	function(){
		$('.homeFunDollaBill').css({'display':'block'}).stop().animate({
			'top' : '174px',
			'left' : '366px',
			'width' : '370px',
			'height' : '157px'
		},1000);
		
	},
	function(){
		$('.homeFunDollaBill').stop().animate({
			'top' : '279px',
			'left' : '240px',
			'width' : '0px',
			'height' : '0px'
		},1000);
	}
);
$('.homeFunSizes').hover(
	function(){
		$('.homeFunBigSmall').stop().animate({
			'width':'211px',
			'height':'308px',
			'top':'135px',
			'left':'459px'
		},1000);
	},
	function(){
		$('.homeFunBigSmall').stop().animate({
			'width':'0px',
			'height':'0px',
			'top':'429px',
			'left':'556px'
		},1000);
	}
);
$('.introBarEmailIn').blur(function(){
	if($(this).val()==''){
		$(this).val('Email');
	};
}); // end blur
$('.introBarEmailIn').focus(function(){
	if($(this).val()=='Email'){
		$(this).val('');
	};
}); // end focus
$('.introTryFreeBtn').click(function(){
	var emailX=$('.introBarEmailIn').val();
	var atpos=emailX.indexOf("@");
	var dotpos=emailX.lastIndexOf(".");
	var emailXValid = false;
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailX.length)
		{
		emailXValid = false;
	}else{
		emailXValid = true;
	};

	if($('.introBarEmailIn').val()=='' || $('.introBarEmailIn').val()=='Email' || emailXValid==false){
		alert('please enter  a valid email');
	}else{
		$('#openHaircutPop').trigger('click');
	};
}); // end click

$('.createSsNotReadyEmailSubmit').click(function() {
	$('.openNoCreateSsYetThanksSubmittedBox').trigger('click');
	var form_data = {
		email: $('.createSsNotReadyEmailInput').val(),
		requestType: 'AddEmail',
		is_ajax: 1
	}; // end form_data
	$.ajax({
		type: "POST",
		url: 'request.php',
                data: form_data,
                success: function(response) {
                    if(response == 'success') {
						$('.noCreateSsYetThanksSubmittedBox').html('<h1>Email Submitted</h1><img src="images/checkMarkGreen.png" />');
                    } else if(response == 'EmailExists') {
						$('.noCreateSsYetThanksSubmittedBox').html('<h1>Email Exists</h1><img src="images/checkMarkGreen.png" />');
                    } else {
						$('.noCreateSsYetThanksSubmittedBox').html('<h1>'+response+'Email Submitted</h1><img src="images/checkMarkGreen.png" />');
                    }
					$('.createSsNotReadyEmailInput').val('Email');
                } // end success
	});
}); // end click submit email

$('.contactUsSend').click(function() {
	var form_data = {
		email: $('.contactUsEmail').val(),
		subject: $('.contactUsSubject').val(),
		message: $('.contactUsMessage').val(),
		requestType: 'ContactUs',
		is_ajax: 1
	}; // end form_data
	$.ajax({
		type: "POST",
		url: 'request.php',
                data: form_data,
                success: function(response) {
                    if(response == 'success') {
                        $('.contactUsSent').html("<p>Message Sent!<br/><br/><span>Thanks for contacting us, we'll get back to you soon!</span><br><br/>-Zillionears Team</p>");
                    } else {
                        $("#contactUsNewError").html("<p>"+response+"</p>");
                    }
                } // end success
	});
}); // end click submit email
$('.homeLogo').hover(
	function(){
		$('.justEarInLogo').stop().animate({
			'height':'89',
			'top':'25px'
		},500);
		$('.homeBetaSymbol').stop().animate({
			'top':'35',
			'left':'245'
		},500);
	},
	function(){
		$('.justEarInLogo').stop().animate({
			'height':'79',
			'top':'30px'
		},500);
		$('.homeBetaSymbol').stop().animate({
			'top':'40',
			'left':'240'
		},500);
	}
);
	$('.indexIntroRollingThirdShells').hover(function(){
		$(this).stop().animate({
			'top':'-66px'
		},600);
	},
	function(){
		$(this).stop().animate({
			'top':'0px'
		},600);
	}
	);

$('.indexIntroCoolSalesSaleShell').hover(
	function(){
		$(this).children('.indexIntroCoolSaleHoverShell').show();
	},
	function(){
		$(this).children('.indexIntroCoolSaleHoverShell').hide();
	}
);
}); // end ready