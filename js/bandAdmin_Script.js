// JavaScript Document
$(document).ready(function(){
/********************************************************************* fan admin new code 12/6/2012 *********************/
function makeFontFit(className,maxHeight,startingFont){
	$('.'+className).each(function(){
	var fontSize = startingFont;
		while($(this).height()>maxHeight){
			$(this).css('font-size',fontSize+'px');
			fontSize--;
		};
	});
};
makeFontFit('fadminSaleLeftShell h2',17,12);
makeFontFit('fadminSaleLeftShell h1',21,16);
/********************************************************************************** Fans In Sale **********************************/ 
$('.adminOrderIncompCheck').click(function(){
	$(this).addClass('adminOrderCheckboxChecked').parent().parent().find('.adminOrderCompCheck').removeClass('adminOrderCheckboxChecked');
	
});
$('.adminOrderCompCheck').click(function(){
	$(this).addClass('adminOrderCheckboxChecked').parent().parent().find('.adminOrderIncompCheck').removeClass('adminOrderCheckboxChecked');
	
});
/**************************************************************************     truth game        ***********************************/
for(i=1;i<=5;i++){
$('[name="game'+i+'"]').click(function(){
	$(this).parent().parent().parent().parent().attr("gamevalid",1);
});
};
for(i=1;i<=5;i++){
	$('.gameSubmitBrn'+i).live("click", function(){
		var gameCounter = $(this).attr("gamecounter");
		var gameValid = ($(this).parent().parent().parent().parent().attr("gamevalid"));
		if(gameValid>0){
			$('.gameWinText'+gameCounter).css({'color': '#018f46', 'font-weight' : 'bold'})
				if($(".gameWin"+gameCounter).is(":checked")){
					$('.winOrLose'+gameCounter).text("Winner").css({'color':'#018f46'});
				}else{
					$('.winOrLose'+gameCounter).text("Loser").css({'color':'red'});
				};
			$(this).remove();
		}else{
			alert("Please choose one");
		};
	}); // end click
}; // end for
/*************************************************************************** Other ***********************************************/
///********************* band admin validation ****///
var bandAdminBandNameValid = false;
function bandAdminBandNameValidator(){
	if($('#bandAdminBandNameIn').val()==''){
		bandAdminBandNameValid = false;
		$('#bandAdminErrorLabelBandName').slideDown();
	}else{
		bandAdminBandNameValid = true;
		$('#bandAdminErrorLabelBandName').slideUp();
	};
};
$('#bandAdminBandNameIn').change(function(){
	bandAdminBandNameValidator();
});
var bandAdminWebsiteValid = false;
function bandAdminWebsiteValidator(){
		function checkURL(value) {
    		var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
    		if (urlregex.test(value)) {
    	    	bandAdminWebsiteValid = true;
				$('#bandAdminErrorLabelWebsite').slideUp();
    		}else{
    			bandAdminWebsiteValid = false;
				$('#bandAdminErrorLabelWebsite').slideDown();
			}
		}
		URLtoCheck = $('#bandAdminWebsiteIn').val();	
		checkURL(URLtoCheck);
};
$('#bandAdminWebsiteIn').change(function(){
	bandAdminWebsiteValidator();
});

$('#bandAdminChangeSettingsBtn').click(function(){
		bandAdminWebsiteValidator();
		bandAdminBandNameValidator();
		if(bandAdminWebsiteValid==true && bandAdminBandNameValid==true){
			// do nothing
		}else{
			// event.preventDefault();
		};
});

$('.profileChangePasswordText').click(function(){
	$('.confirmPasswordHidden').slideDown(600);
	$(this).slideUp(600);
});
/********************************************************************************** shop sales *****************************/
$('.shopSalesSquareBottomText1').each(function(){
	var fontSize = 16;
		while($(this).height()>20){
			$(this).css('font-size',fontSize+'px');
			fontSize--;
		};
});
$('.shopSalesSquareBottomText2').each(function(){
	var fontSize = 14;
		while($(this).height()>16){
			$(this).css('font-size',fontSize+'px');
			fontSize--;
		};
});
/********************************************************************************** Randoms **********************************/
$('#openfInSDigShell').fancybox();
$('#openFInSPhysShell').fancybox();
$('#openOrderShell').fancybox();
$('#openRefShell').fancybox();
$('#openSendCheckBox').fancybox();
}); // end ready 