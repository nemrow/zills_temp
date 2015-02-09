// JavaScript Document
$(document).ready(function(){
//**************************************************************************      begin code        ***********************************
/** type of account holer **/
var creatingSaleAccountHolderType = $('#createSsAccountHolderTypeFondler').attr('accountType');
	if(creatingSaleAccountHolderType=='band'){
		$('.crSSStep1').css('display','none');
		$('.crSSStep2').css('display','block');
		$('.createSsBandRowRemove').remove();
		$('.crSSTopFirstIconToRemoveForBandAcct, .step2Back').remove();
		$('.crSSTopIcon2').removeClass('crSSIconNotActive');
	}else if(creatingSaleAccountHolderType=='fan'){
		$('.createSsFanUpgradeRowRemove').remove();
		$('#createSsStepOneHead').text('Upgrade To "Band" Account');
	};

//**************************************************************************      type of sale       ***********************************
var typeOfSale = 'digitalMusic';
$('.typeClickedDigMus').click(function(){
	$('.crSSStyleDropDigMus').slideDown(600);
	$('.crSSStyleDropPhysMus, .crSSStyleDropPhysMerch, .crSSStyleDropPhysMus2, .crSSStyleDropPhysMerch2').slideUp(600);
	typeOfSale = 'digitalMusic';
}); // end click
$('.typeClickedPhysMus').click(function(){
	$('.crSSStyleDropPhysMus').slideDown(600);
	$('.crSSStyleDropDigMus, .crSSStyleDropPhysMerch, .crSSStyleDropDigMus2, .crSSStyleDropPhysMerch2').slideUp(600);
	typeOfSale = 'physical';
}); // end click
$('.typeClickedMerch').click(function(){
	$('.crSSStyleDropPhysMerch, .crSSStyleDropPhysMerch2').slideDown(600);
	$('.crSSStyleDropDigMus, .crSSStyleDropPhysMus, .crSSStyleDropDigMus2, .crSSStyleDropPhysMus2').slideUp(600);
	typeOfSale = 'merch';
}); // end click
$('.unlPurch1').click(function(){
	if($(this).attr('checked')){
		$('.takeDigPurchUnl').attr('checked', 'checked');
		$('.unlPurchSelector1').attr('disabled','disabled');
		$('.unlPurchSelector1').val('');
	}else{
		$('.unlPurchSelector1').removeAttr('disabled');
	}// end if
}); // end click
$('.unlPurch2').click(function(){
	if($(this).attr('checked')){
		$('.takePhysPurchUnl').attr('checked', 'checked');
		$('.unlPurchSelector2').attr('disabled','disabled');
		$('.unlPurchSelector2').val('');
	}else{
		$('.unlPurchSelector2').removeAttr('disabled');
		$('.takePhysPurchUnl').removeAttr('checked', 'checked');
	}// end if
}); // end click
$('.chooseStockBGDrop').click(function(){
	if($(this).attr('checked')){
	$('.chooseStockBGShell').slideDown(600);
	}else{
		$('.chooseStockBGShell').slideUp(600);
	};
}); // end click
$('.chooseStockBGImg').click(function(){
	$('.chooseStockBGImg').removeClass('chooseStockBGSelected');
	$(this).addClass('chooseStockBGSelected');
});
var createSsMediaType = 'DigitalMusic';
var createSsMediaTypeForDisplay = 'undefined';
$('#typeDigMus').click(function(){
	createSsMediaType = 'DigitalMusic';
	createSsMediaTypeForDisplay = 'Digital Music';
});
$('#typePhysMus').click(function(){
	createSsMediaType = 'PhysicalMusic';
	createSsMediaTypeForDisplay = 'Physical Music';
});
//**************************************************************************   Validation  ***********************************
/**************************************************************************     send check        ***********************************/
var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
var intRegex = /^\d+$/;
var moneyRegex = /^\s*(\+|-)?((\d+(\.\d\d)?)|(\.\d\d))\s*$|(^\d+$)/;
var alphabetOnlyRegex = /[a-zA-Z]+/;

var validBandName = false;
var validEmail = false;
var validEmailNotTaken = true;
var validPasswordLength = false
var validPassword = false;
var validFirstName = false;
var validLastName= false;
var validPayPalEmail = true;
var validBandWebsite = false;
var bandAdminAddress1Valid = true;
var bandAdminAddress2Valid = true;
var bandAdminAddress3Valid = true;
var bandAdminAddress4Valid = true;
var bandAdminFullPaymentValid = true;

var validatePage1 = function(){
	var tempBandNameForRegex = $('.grabBandName').val(); 
	if(tempBandNameForRegex.length>0){	
		validBandName = true;
		$('.grabBandName').removeClass('error');
		$('.bandErrorLab').hide();
	}else{
		validBandName = false;
		$('.grabBandName').addClass('error');
		$('.bandErrorLab').show();
	}; // end validatin grabBandName
	function bandAdminWebsiteValidator(){
		function checkURL(value) {
    		var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
    		if (urlregex.test(value)) {
    	    	validBandWebsite = true;
				$('#bandAdminErrorLabelWebsite').slideUp();
    		}else{
    			validBandWebsite = false;
				$('#bandAdminErrorLabelWebsite').slideDown();
			}
		}
		URLtoCheck = $('#bandAdminWebsiteIn').val();
		checkURL(URLtoCheck);
	};
	bandAdminWebsiteValidator();
	if(creatingSaleAccountHolderType!='fan'){
		var emailTest=$('.grabEmail').val();
		var atpos=emailTest.indexOf("@");
		var dotpos=emailTest.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailTest.length){
			if($('.grabEmail').next().text()!='Please provide a valid email address.'){
				$('.grabEmail').addClass('error').after('<label class="error">Please provide a valid email address.</label>');
			};
			validEmail = false;
		}else{
			if($('.grabEmail').next().text()=='Please provide a valid email address.'){
			$('.grabEmail').removeClass('error').next().remove();
			};
			validEmail = true;
		}; // end validating grabEmail

		if($('.crSSConfPass').val()=='' || $('.crSSConfPass').val().length<8){
			if($('.crSSConfPass').next().text()!='Please provide a password at least 8 charecters long.'){
				$('.crSSConfPass').addClass('error').after('<label class="error">Please provide a password at least 8 charecters long.</label>');
			};
			validPasswordLength = false;
		}else{
			if($('.crSSConfPass').next().text()=='Please provide a password at least 8 charecters long.'){
				$('.crSSConfPass').removeClass('error').next().remove();
			};
			validPasswordLength = true;
		}; // end validate initial password

		if($('.confirmPassword').val()==$('.crSSConfPass').val()){
			if($('.confirmPassword').next().text()=='Passwords do not match.'){
				$('.confirmPassword').removeClass('error').next().remove();
			};
			validPassword = true;
		}else{
			if($('.confirmPassword').next().text()!='Passwords do not match.'){
			$('.confirmPassword').addClass('error').after('<label class="error">Passwords do not match.</label>');
			};
			validPassword = false;
		}; // end validate confirm password
		var tempFirstNameForRegex = $('.grabFirstName').val();
		if(alphabetOnlyRegex.test(tempFirstNameForRegex)){
			$('.firstNameErrorLab').hide();
			$('.grabFirstName').removeClass('error');
			validFirstName = true;
		}else{
			$('.firstNameErrorLab').show();
			$('.grabFirstName').addClass('error');
			validFirstName = false;
		}; // end validate first name
		var tempLastNameForRegex = $('.grabLastName').val();
		if(alphabetOnlyRegex.test(tempLastNameForRegex)){
			$('.grabLastName').removeClass('error');
			$('.lastNameErrorLab').hide();
			validLastName = true;
		}else{
			$('.grabLastName').addClass('error');
			$('.lastNameErrorLab').show();
			validLastName = false;
		}; // end validate last name
	}; // end if not fan

			validPayPalEmail=true;

}; // end validatePage1
/** validate email if already used **/
$('.grabEmail').change(function(){
	var form_data = {
		email: $('.grabEmail').val(),
		requestType: 'CheckEmail',
		is_ajax: 1
	}; // end form_data
	$.ajax({
		type: "POST",
		url: 'request.php',
                data: form_data,
                success: function(response) {
                    if(response == 'EmailExists') {
						validEmailNotTaken=false;
						$('#createSsEmailTakenError').html('Email already exists.');
                    } else if(response == 'success') {
						validEmailNotTaken=true;
						$('#createSsEmailTakenError').html('');
                    };
                } // end success
	});
});

var validProdName = false;
var validPhysFlatShipRate = false;

var validPhysPurchLimit = false;
var validMerchShipping = false;
var validMerchQuant = false;
var validCompleteTYpeSpecs = false;
var validImage1Submited = false;
var validImage1Completed = false;
var validatePage2 = function(){
	if($('.grabProdName').val()==''){
		if($('.grabProdName').next().text()!='Please provide a product name.'){
		$('.grabProdName').addClass('error').after('<label class="error">Please provide a product name.</label>');
		};
		validProdName = false;
	}else{
		if($('.grabProdName').next().text()=='Please provide a product name.'){
			$('.grabProdName').removeClass('error').next().remove();
		};
		validProdName = true;
	};
	if(typeOfSale=='digitalMusic'){
		checkForNoTracksUploaded(); // function in on fileuploader page
	} // end if digital sale

	if(typeOfSale=='undefined'){
		$('.proTypeEyeCatcher').effect("shake", { times:3 }, 190).css('color','red');
	};

	if(typeOfSale=='digitalMusic'){
		if(validDigitalTrackCount==true){
			validCompleteTYpeSpecs = true;
		}else{
			validCompleteTYpeSpecs = false;
		};
	};
	if(typeOfSale=='physical'){
		if(validPhysicalTrackCount==true && validPhysFlatShipRate==true && validPhysPurchLimit==true){
			validCompleteTYpeSpecs = true;
		}else{
			validCompleteTYpeSpecs = false;
		};
	};
	if($('.imageInput1Submitted').val()=='true'){
		$('.image1NotUploaded').hide();
		validImage1Submited = true;
	}else{
		$('.image1NotUploaded').show();
		validImage1Submited = false;
	};
};
var validStartPrice = false;
var validFloorPrice = false;
var validDecPrice = false;
var validHitNum = false;
var validAllPricing = false;
var validSaleEnds = false;
var validImage2Submited = false
var validImage3Submited = false;
var validImage2Completed = false;
var validImage3Completed = false;
var VhitNum = 'undefined'; // declared here, defined below with the calculate feature
var validatePage3 = function(){
	if(pricingHasClimax==true){
		$('.specialPriceError').hide();
		validAllPricing = true;
	}else{
		$('.specialPriceError').show();
		validAllPricing = false;
	};
	if($('#datepicker').val()!=''){
		$('.saleEndsEyeCatcher').css('color','white');
		validSaleEnds = true;
	}else{
		$('.saleEndsEyeCatcher').effect("shake", { times:3 }, 190).css('color','red');
		validSaleEnds = false;
	};
	if($('.imageInput3Completed').val()=='true'){
		$('.image3NotUploaded').hide();
		validImage3Submited = true;
	}else{
		$('.image3NotUploaded').show();
		validImage3Submited = false;
	};
};
var validPhysicalTrackCount = false;
var validTermsOfService = false;
var validCantChangeAgree = false;
var allImagesUploaded = false;
var validatePage4 = function(){
	if(creatingSaleAccountHolderType=='new'){
		var emailTest=$('.takeEmail').val();
		var atpos=emailTest.indexOf("@");
		var dotpos=emailTest.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=emailTest.length){
			if($('.takeEmail').next().text()!='Please provide a valid email address.'){
				$('.takeEmail').addClass('error').after('<label class="error">Please provide a valid email address.</label>');
			};
			validEmail = false;
		}else{
			if($('.takeEmail').next().text()=='Please provide a valid email address.'){
			$('.takeEmail').removeClass('error').next().remove();
			validEmail = true;
			alert('email should now be true '+ validEmail);
			};
		}; // end validating email in page 4
	};
	if($('.takeProdName').val()==''){
		if($('.takeProdName').next().text()!='Please provide a product name.'){
		$('.takeProdName').addClass('error').after('<label class="error">Please provide a product name.</label>');
		};
		validProdName = false;
	}else{
		if($('.takeProdName').next().text()=='Please provide a product name.'){
			$('.takeProdName').removeClass('error').next().remove();
		};
		validProdName = true;
	}; // end validating product name for page 4

	if(typeOfSale=='digitalMusic'){
		checkForNoTracksUploaded(); // function on fileuploader page
	}; // end if digital
	
	if($('.imageInput1Completed').val()=='true' && $('.imageInput3Completed').val()=='true'){
		allImagesUploaded = true;
	}else{
		alert('Please wait for your images to upload. Booyah');	
	};

	if($('#datepicker3').val()!=''){
		$('.saleEndsEyeCatcher').css('color','white');
		validSaleEnds = true;
	}else{
		$('.saleEndsEyeCatcher').effect("shake", { times:3 }, 190).css('color','red');
		validSaleEnds = false;
	}; // end validate end sale date

	if($('.termsOfServiceValid').attr('checked')){
		validTermsOfService=true;
		$('.termsOfServiceValText').css('color','white');
	}else{
		$('.termsOfServiceValText').effect("shake", { times:3 }, 190).css('color','red');
		validTermsOfService=false;
	};
	if($('.understandCantChangeValid').attr('checked')){
		validCantChangeAgree = true;
		$('.unsterstandCantChangeText').css('color','white');
	}else{
		$('.unsterstandCantChangeText').effect("shake", { times:3 }, 190).css('color','red');
		validCantChangeAgree = false;
	};
}; // end validating page 4
//manuel keyup binds
$('#datepicker').bind('change',function(){
	if($('#datepicker').val()!=''){
		$('.saleEndsEyeCatcher').css('color','white');
		validSaleEnds = true;
	};
})
$('.crSSTypeRadio').live('click',function(){
	$('.proTypeEyeCatcher').css('color','white');
});
var initPage1Valdiate = false;
$('.step1Done').click(function(){
	initPage1Valdiate = true;
	validatePage1();
});
$('.pageOneValiBlurs').bind('change',function(){
	if(initPage1Valdiate==true){
	validatePage1();
	};
});
var initPage2Valdiate = false;
$('.step2Done').click(function(){
	initPage2Valdiate = true;
	validatePage2();
});
$('.pageTwoValiBlurs').bind('change',function(){
	if(initPage2Valdiate==true){
	validatePage2();
	};
});
var initPage3Valdiate = false;
$('.step3Done').click(function(){
	initPage3Valdiate = true;
	validatePage3();
});
$('.crCustomSave, .prefBSSSuggestBtn').click(function(){
	if(initPage3Valdiate==true){
	validatePage3();
	};
});
var initPage4Validate = false;
$('.step4Done').click(function(){
	validatePage4();
	initPage4Validate = true;
});
$('.pageFourValiBlurs').bind('change',function(){
	if(initPage4Validate==true){
		validatePage4();
	};
});
//**************************************************************************     create pricing        ***********************************
var bottomHitNum = 0;
var pricingHasClimax = false;
$('.crCustomCalc').click(function(){
	$('.crCDStart').val($('.crCDStart').val().replace('-',''));
	$('.crCDDec').val($('.crCDDec').val().replace('-',''));
	$('.crCDEnd').val($('.crCDEnd').val().replace('-',''));
	var tempStartPriceForRegex = $('.crCDStart').val();
	var tempDecNumberForRegex = $('.crCDDec').val();
	var tempFloorPriceForRegex = $('.crCDEnd').val();
	var afterJustOneSale = tempStartPriceForRegex - tempDecNumberForRegex;
	if(afterJustOneSale<tempFloorPriceForRegex){
			alert('This pricing structure is stupid! Change it! Booyah.');
		}else{
		if(moneyRegex.test(tempStartPriceForRegex) && floatRegex.test(tempDecNumberForRegex) && moneyRegex.test(tempFloorPriceForRegex)){
			bottomHitNum = (parseFloat((($('.crCDStart').val()) - ($('.crCDEnd').val())) / ($('.crCDDec').val())).toFixed(0));
			$('.crCustomInsP').text(bottomHitNum);
			$('.salePriceStPri').text($('.crCDStart').val());
			$('.salePriceStPri').text('$'+(parseFloat($('.crCDStart').val()).toFixed(2)));
			$('.salePriceStLoPri').text('$'+(parseFloat($('.crCDEnd').val()).toFixed(2)));
			$('.saleaPriceStDec').text('$'+(parseFloat($('.crCDDec').val()).toFixed(3)));
			$('.salePriceStToReach').text(parseFloat(bottomHitNum).toFixed(0));
			VhitNum = parseFloat(bottomHitNum).toFixed(0); // variable declared in validation
			$('.salePriceStatement').slideDown(300);
			pricingHasClimax = true;
			$('.specialPriceError').hide();
		}else{
			alert('Real numbers please.');
		};
	};
}); // end click
$('.crCDEnd').change(function(){
	if($(this).val()<0.10){
	alert('Lowest price must be at least 10 cents.');
	$(this).val('0.10');
	}
});
$('.prefBSSCieling').change(function(){
	if($(this).val()<0.40){
		alert('Retail value must be at least 40 cents while using recommended sale structure.');
		$(this).val('0.40');
		$('.prefBSSCalcBtn').trigger('click');
	}
});
$('.crCustomSave').click(function(){
	$('#fancybox-close').trigger('click');
}); // end click
$('.crCDDec').change(function(){
	if($(this).val()!=''){
	$(this).val(parseFloat($(this).val()).toFixed(4));
	}
});
$('.prefBSSPastSale, .crCDStart').change(function(){
	if($(this).val()>9999){
		alert('You are too legit to quit!! Thats a $h!tload of units! Lets set this Social Sale up our special VIP way. Email Jordan at JNemrow@Zillionears.com. Booyah!');
		$(this).val(9999);
	};
});
$('.prefBSSCalcBtn').click(function(){
	$('.prefBSSPastSale').val($('.prefBSSPastSale').val().replace('-',''));
	$('.prefBSSCieling').val($('.prefBSSCieling').val().replace('-',''));
	var tempSaleStructureSale = $('.prefBSSPastSale').val();
	var tempSaleStructureNumbs = $('.prefBSSCieling').val();
	if(floatRegex.test(tempSaleStructureSale) && moneyRegex.test(tempSaleStructureNumbs)){
		var ceilingP = $('.prefBSSCieling').val();
		var floorP = (ceilingP * .25); ///******************************** Percetage of Starting Price (Floor Price)
		var pastSale = $('.prefBSSPastSale').val();
		var decStruc = parseFloat((ceilingP - floorP)/(pastSale * 1.5)).toFixed(4); ///******** Fan Increase Percentage
		var toGetTo = ((ceilingP - floorP)/decStruc);
		$('.salePriceStPri').text('$'+(parseFloat(ceilingP).toFixed(2)));
		var startPriceGrab = parseFloat(ceilingP).toFixed(2);
		var lowPriceGrab = parseFloat(floorP).toFixed(2);
		var decPriceGrab = parseFloat(decStruc).toFixed(4);
		var getToGrab = parseFloat(toGetTo).toFixed(0);
		$('.salePriceStLoPri').text('$'+(parseFloat(floorP).toFixed(2)));
		$('.saleaPriceStDec').text('$'+(parseFloat(decStruc).toFixed(4)));
		$('.salePriceStToReach').text(parseFloat(toGetTo).toFixed(0));
		VhitNum = parseFloat(toGetTo).toFixed(0); // variable declared in validation
		$(this).text('Recalculate');
		$('.salePriceStatement, p.prefBSSSuggestBtn, p.prefBSSOr, p.prefBSSGoCustomBtn').slideDown(300);
		$('.crCDStart').val(startPriceGrab);
		$('.crCDEnd').val(lowPriceGrab);
		$('.crCDDec').val(decPriceGrab);
		$('.crCustomInsP').text(getToGrab);
		pricingHasClimax = true;
		$('.specialPriceError').hide();
	}else{
		alert('Real numbers please!');
	};
}); // end click
$('.prefBSSSuggestBtn').click(function(){
	$('#fancybox-close').trigger('click');
}); // end click
$('.prefBSSGoCustomBtn').click(function(){
	$('#fancybox-close, .customPricingBtn').trigger('click')
}); // end click
$('#wtfBushRecomendedHelp').click(function(){
	$(this).fadeOut(300);
	$('#crPreSSDescriptionShell').fadeIn(300);
});
$('#crePreSSDescrCloseHelp').click(function(){
	$('#crPreSSDescriptionShell').fadeOut(300);
	$('#wtfBushRecomendedHelp').fadeIn(300);
});
//**************************************************************************      track list        ***********************************
$('.digTrackTitleIn, .physTrackTitleIn').focus(function(){
	if($(this).val() == ('Track Title')){
		$(this).val	('');
	} else {
		return false;
	};
}); // end focus
$('.digTrackTitleIn, .physTrackTitleIn').blur(function(){
	if($(this).val() == ('')){
		$(this).val	('Track Title');
	} else {
		return false;
	};
}); // end focus
$('.physTrackLengthIn').focus(function(){
	if($(this).val() == ('Length')){
		$(this).val	('');
	} else {
		return false;
	};
}); // end focus
$('.physTrackLengthIn').blur(function(){
	if($(this).val() == ('')){
		$(this).val	('Length');
	} else {
		return false;
	};
}); // end focus
/*********** Adding Physial Tracks ***********/
var physicalTrackCounter = 0;
var physicalTrackTitle = {};
$('#enterTracksPhysicalAddTrackBtn').click(function(){
	if($('#newPhysicalTrackTitle').val()=="Track Title" || $('#newPhysicalTrackTitle').val()=="") {
		alert("No Title");
		return;
	}
	if($('#newPhysicalTrackLength').val()=="Length" || $('#newPhysicalTrackLength').val()=="") {
		alert("No length");
		return;
	}
	var newRow = '<tr id="enterTrack'+physicalTrackCounter+'" trackcount="'+physicalTrackCounter+'" class="enterTrackRow';
	if(physicalTrackCounter%2==0) {
		newRow += 'E';
	} else {
		newRow += 'O'
	}
	newRow += '"><td class="enterTrackPhysNum physEnterTrackContent1 physicalNumberContain physicalNumberContain'+physicalTrackCounter+'">';
	newRow += physicalTrackCounter+1;
	newRow += '.</td><td class="physEnterTrackContent2">'
	newRow += $('#newPhysicalTrackTitle').val();
        physicalTrackTitle[physicalTrackCounter] = $('#newPhysicalTrackTitle').val();
	newRow += '<td class="physEnterTrackContent3 physTrackUp"><img src="images/arrowUp.png"></td><td class="physEnterTrackContent3 physTrackDown"><img src="images/arrowDown.png"></td><td class="physEnterTrackContent3"><img class="physTrackX physTrackX'+physicalTrackCounter+'" src="images/trash.png"></tr>';
	$('#enterPhysicalTrackTable').append(newRow);
	physicalTrackCounter++;
	$('.physTrackTitleIn').val('');
	$('#physicalTrackCount').val(physicalTrackCounter);
	if($('.crSSStyleDropPhysMus').next().text()=='You have not added any tracks.'){
		$('.crSSStyleDropPhysMus').next().remove();
	};
}); // end click
$('.physTrackX').live('click',function(){
	var thisPhysTrack = $(this).closest('tr').attr('trackcount');
	for(i=thisPhysTrack;i<=physicalTrackCounter;i++){
		var lastTrack = parseInt($('#enterTrack'+i).attr('trackcount'))-1;
		var thisTrack = lastTrack + 1;
		$('#enterTrack'+i).attr('trackcount',lastTrack).attr('id','enterTrack'+lastTrack);

		if(lastTrack%2==0){
			$('#enterTrack'+lastTrack).removeClass('enterTrackRowO').addClass('enterTrackRowE');
		}else{
			$('#enterTrack'+lastTrack).removeClass('enterTrackRowE').addClass('enterTrackRowO');
		};
		$('.physicalNumberContain'+i).addClass('physicalNumberContain'+lastTrack).removeClass('physicalNumberContain'+i).text(thisTrack);
		$('physTrackX'+i).addClass('physTrackX'+lastTrack).removeClass('physTrackX'+i);
	};
	$(this).parent().parent().remove();
	physicalTrackCounter--;
	$('#physicalTrackCount').val(physicalTrackCounter);
});
$('.physTrackUp').live('click',function(){
	if($(this).closest('tr').attr('trackcount')>0){
	var thisTrackCount = parseInt($(this).closest('tr').attr('trackcount'));
	var lastTrackCount = thisTrackCount-1;
	var thisScreenNum = thisTrackCount+1;
	var lastScreenNum = lastTrackCount+1;
	$(this).closest('tr').attr('trackcount',lastTrackCount).attr('id','enterTrack'+lastTrackCount).find('.physicalNumberContain').text(lastScreenNum+'.');
	$(this).closest('tr').find('.physTrackX').addClass('physTrackX'+lastTrackCount).removeClass('physTrackX'+thisTrackCount);
	$(this).closest('tr').find('.physicalNumberContain').addClass('physicalNumberContain'+lastTrackCount).removeClass('physicalNumberContain'+thisTrackCount)
	if(thisTrackCount%2==0){
		$(this).closest('tr').addClass('enterTrackRowO').removeClass('enterTrackRowE');
		$(this).closest('tr').prev().addClass('enterTrackRowE').removeClass('enterTrackRowO');
	}else{
		$(this).closest('tr').addClass('enterTrackRowE').removeClass('enterTrackRowO');
		$(this).closest('tr').prev().addClass('enterTrackRowO').removeClass('enterTrackRowE');
	};
	$(this).closest('tr').prev().attr('trackcount',thisTrackCount).attr('id','enterTrack'+thisTrackCount).find('.physicalNumberContain').text(thisScreenNum+'.');
	$(this).closest('tr').prev().find('.physTrackX').addClass('physTrackX'+thisTrackCount).removeClass('physTrackX'+lastTrackCount);
	$(this).closest('tr').prev().find('.physicalNumberContain').addClass('physicalNumberContain'+thisTrackCount).removeClass('physicalNumberContain'+lastTrackCount);
	$(this).closest('tr').prev().before($(this).closest('tr'));
	};
});
$('.physTrackDown').live('click',function(){
	if($(this).closest('tr').attr('trackcount')<physicalTrackCounter-1){
	var thisTrackCount = parseInt($(this).closest('tr').attr('trackcount'));
	var nextTrackCount = thisTrackCount+1;
	var thisScreenNum = thisTrackCount+1;
	var nextScreenNum = nextTrackCount+1;
	$(this).closest('tr').attr('trackcount',nextTrackCount).attr('id','enterTrack'+nextTrackCount).find('.physicalNumberContain').text(nextScreenNum+'.');
	$(this).closest('tr').find('.physTrackX').addClass('physTrackX'+nextTrackCount).removeClass('physTrackX'+thisTrackCount);
	$(this).closest('tr').find('.physicalNumberContain').addClass('physicalNumberContain'+nextTrackCount).removeClass('physicalNumberContain'+thisTrackCount)
	if(thisTrackCount%2==0){
		$(this).closest('tr').addClass('enterTrackRowO').removeClass('enterTrackRowE');
		$(this).closest('tr').next().addClass('enterTrackRowE').removeClass('enterTrackRowO');
	}else{
		$(this).closest('tr').addClass('enterTrackRowE').removeClass('enterTrackRowO');
		$(this).closest('tr').next().addClass('enterTrackRowO').removeClass('enterTrackRowE');
	};
	$(this).closest('tr').next().attr('trackcount',thisTrackCount).attr('id','enterTrack'+thisTrackCount).find('.physicalNumberContain').text(thisScreenNum+'.');
	$(this).closest('tr').next().find('.physTrackX').addClass('physTrackX'+thisTrackCount).removeClass('physTrackX'+nextTrackCount);
	$(this).closest('tr').next().find('.physicalNumberContain').addClass('physicalNumberContain'+thisTrackCount).removeClass('physicalNumberContain'+nextTrackCount);
	$(this).closest('tr').next().after($(this).closest('tr'));
	};
});
/*************** Adding Digital Tracks ***********/
var digitalTrackTitleFocus = function(){
	$('.digitalTrackTitleIn').live('focus',function(){
	if($(this).val()==("Enter track title here")){
		$(this).val("");
	};
}); // end focus
}; // end function
var digitalTrackTitleBlur = function(){
	$('.digitalTrackTitleIn').live('blur',function(){
	if($(this).val()==("")){
		$(this).val("Enter track title here");
	};
}); // end focus
}; // end function
digitalTrackTitleFocus();
digitalTrackTitleBlur();
$('#file-uploader-demo1').click(function(){
	var trackCount = parseInt($('#digitalTrackCount').val());
	$('#digitalTrackCount').val(trackCount+1);
	var newRow = '<tr id="enterTrack"'+trackCount+'" class="enterTrackRow';
	if(trackCount%2==0) {
		newRow += 'E';
	} else {
		newRow += 'O'
	}
	newRow += '"><td>1.</td><td><input type="text" class="digitalTrackTitleIn" value="Enter track title here"/><br /><p class="digitalTrackFileName">the_file_on_comp.mp3 <img class="uploadingGif" src="images/ajax-loader.gif" /><span>(uploading)</span></p></td><td>.mp3</td><td class="dashboardProductsProductEditUpDown"><div class="upDownArrowShell"><img class="dashboardProductMoveUp" src="images/productEditArrowUp.png" /><img class="dashboardProductMoveDown" src="images/productEditArrowDown.png" /></div></td><td class="enterTrackX">X</td></tr>';
	$('#enterDigitalTrackTable').append(newRow);
	digitalTrackTitleFocus();
	digitalTrackTitleBlur();
	upOrDownArrows();
}); // end click
//**************************************************************************      random        ***********************************
$('#openTrackListCreatePop').fancybox();
$('#openTrackListPhysPop').fancybox();
$('#openTrackListCreatePop2').fancybox();
$('#openTrackListCreatePop3').fancybox();
$('#openTrackListPhysPop2').fancybox();
$('#openCrCustomSS').fancybox();
$('#openCrCustomSS2').fancybox();
$('#openCrPrefSS').fancybox();
$('#openCrPrefSS2').fancybox();
$('#openLoginBox').fancybox();
$('#openSendCheckBox').fancybox()
$('#openLoginBox').fancybox();
$('#openMockBrowser').fancybox({
		'height' : '100%',
		'width': '100%'
});
/*$("#datepicker").datepicker({ 
	minDate: 0, 
	defaultDate: +10,
    onSelect: function(dateStr, inst) {
        var depart = $(this).datepicker.parseDate('d/m/y', dateStr);
        depart.setDate(depart.getDate('d/m/y') + 5);
        var newDate = depart.toLocaleDateString();
		alert(newDate);
    }
});*/
$("#datepicker").datepicker({
    dateFormat: 'mm/dd/yy',
	minDate: 0, 
	defaultDate: +10,
    onSelect: function(dateStr, inst) { // this adds 1 day to end the sale at midight of this night
        var nights = 1;
        var depart = $.datepicker.parseDate('mm/dd/yy', dateStr);
        depart.setDate(depart.getDate('mm/dd/yy') + nights);
        $('#datePickerFinal').val(depart.toLocaleDateString());
    }
});
$("#datepicker3").datepicker({
    dateFormat: 'mm/dd/yy',
	minDate: 0, 
	defaultDate: +10,
    onSelect: function(dateStr, inst) { // this adds 1 day to end the sale at midight of this night
        var nights = 1;
        var depart = $.datepicker.parseDate('mm/dd/yy', dateStr);
        depart.setDate(depart.getDate('mm/dd/yy') + nights);
        $('#datePickerFinal').val(depart.toLocaleDateString());
    }
});

var upOrDownArrows = function(){
	$(".dashboardProductMoveUp,.dashboardProductMoveDown").click(function(){
	updownarrowclick(this);
}); // end click
}; // end function
upOrDownArrows();
function updownarrowclick(myArrow) {
        var row = $(myArrow).parents("tr:first");
        if ($(myArrow).is(".dashboardProductMoveUp")) {
            row.insertBefore(row.prev());
        } else {
            row.insertAfter(row.next());
        }
};
$('.qq-upload-button').click(function(){
alert("this works");
});
$('#inHeaderLoggedInShell').hover(
	function(){
		$('#loggedInHeaderSlider').slideDown(300);
	},
	function(){
		$('#loggedInHeaderSlider').css('display','none');
	}
);
$('.audioUploadsNumberComplete, .audioUploadsNumberPending').change(function(){
	if($('.audioUploadsNumberComplete').text()==$('.audioUploadsNumberPending').text()){
		$('.buttonProtectorsWudup').hide();
	}else{
		$('.buttonProtectorsWudup').show();
	};
});
function charNumLeft(className,max,classToReturn){
	numOfCharsNows = $('.'+className).val().length;
	numAllowedLeft = max - numOfCharsNows;
	$('.'+classToReturn).text(numAllowedLeft);
	if(numAllowedLeft<1){
		
	};
};
$('.crSSInputTextArea').keyup(function(){
	charNumLeft('crSSInputTextArea', 500, 'charCountInDescription');
});
//**************************************************************************      icon navigations        ***********************************
$('.step1Done').click(function(){
	if(creatingSaleAccountHolderType=='fan'){
		if(validBandName==true && validPayPalEmail==true && validBandWebsite==true){
			$('.crSSStep1').slideUp(800);
			$('.crSSStep2').delay(800).slideDown(600);
			$('.crSSTopIcon1').addClass('crSSIconNotActive');
			$('.crSSTopIcon2').addClass('crSSIconClickable');
			$('.crSSTopIcon2').removeClass('crSSIconNotActive');
			$('.loginToSkipS1').fadeOut(300);
		};
	} else if(creatingSaleAccountHolderType=='new') {
		if(validBandName==true && validEmail==true && validPassword==true && validPasswordLength==true && validFirstName==true && validLastName==true && validEmailNotTaken==true && validBandWebsite==true) {
			$('.crSSStep1').slideUp(800);
			$('.crSSStep2').delay(800).slideDown(600);
			$('.crSSTopIcon1').addClass('crSSIconNotActive');
			$('.crSSTopIcon2').addClass('crSSIconClickable');
			$('.crSSTopIcon2').removeClass('crSSIconNotActive');
			$('.loginToSkipS1').fadeOut(300);
		};
	};
}); // end click
$('.step2Done').click(function(){
	if(validProdName==true && typeOfSale!='undefined' && validCompleteTYpeSpecs==true && validImage1Submited==true){
	$('.crSSStep2').slideUp(600);
	$('.crSSStep3').delay(600).slideDown(600);
	$('.crSSTopIcon2').addClass('crSSIconNotActive');
	$('.crSSTopIcon3').addClass('crSSIconClickable');
	$('.crSSTopIcon3').removeClass('crSSIconNotActive');
	};
}); // end click
$('.step2Back').click(function(){
	$('.crSSStep2').slideUp(600);
	$('.crSSStep1').delay(600).slideDown(600);
	$('.crSSTopIcon2').addClass('crSSIconNotActive');
	$('.crSSTopIcon1').removeClass('crSSIconNotActive');
}); // end click
$('.step3Done').click(function(){
	if(validAllPricing==true && validSaleEnds==true && validImage3Submited==true){
	$('.crSSStep3').slideUp(600);
	$('.crSSStep4').delay(600).slideDown(900);
	$('.crSSTopIcon3').addClass('crSSIconNotActive');
	$('.crSSTopIcon4').addClass('crSSIconClickable');
	$('.crSSTopIcon4').removeClass('crSSIconNotActive');
	};
}); // end click
$('.step3Back').click(function(){
	$('.crSSStep3').slideUp(600);
	$('.crSSStep2').delay(600).slideDown(600);
	$('.crSSTopIcon3').addClass('crSSIconNotActive');
	$('.crSSTopIcon2').removeClass('crSSIconNotActive');
}); // end click
$('.step4Back').click(function(){
	$('.crSSStep4').slideUp(900);
	$('.crSSStep3').delay(900).slideDown(600);
	$('.crSSTopIcon4').addClass('crSSIconNotActive');
	$('.crSSTopIcon3').removeClass('crSSIconNotActive');
}); // end click
$('.enterTrackListSaveBtn').click(function(){
	$('#fancybox-close').trigger('click');
}); // end click
$('.step1Done').click(function(){
	$('.takeBandName').val($('.grabBandName').val());
	$('.takeEmail').val($('.grabEmail').val());
}); // end click
$('.step2Done').click(function(){
	$('.takeProdName').val($('.grabProdName').val());
	$('.takeDesc').val($('.grabDesc').val());
	$('.grabSaleTypeText').text(createSsMediaTypeForDisplay);
	if(typeOfSale=='digitalMusic'){
		$('.crSSStyleDropDigMus2').css('display','block');
		$('.crSSStyleDropPhysMus2, .crSSStyleDropPhysMerch2').css('display','none');
		$('.takeDigPurchLim').val($('.grabDigPurchLim').val());
	};
	if(typeOfSale=='physical'){
		$('.crSSStyleDropPhysMus2').css('display','block')
		$('.crSSStyleDropDigMus2, .crSSStyleDropPhysMerch2').css('display','none')
		$('.takePhysPurchLim1').val($('.grabPhysPurchLim1').val());
		$('.grabFlatShip').val($('.takeFlatShip').val());
	};
	if(typeOfSale=='merch'){
		$('.crSSStyleDropPhysMerch2').css('display','block');
		$('.crSSStyleDropDigMus2, .crSSStyleDropPhysMus2').css('display','none');
		$('.takePhysMerchXS').val($('.grabPhysMerchXS').val());
		$('.takePhysMerchS').val($('.grabPhysMerchS').val());
		$('.takePhysMerchM').val($('.grabPhysMerchM').val());
		$('.takePhysMerchL').val($('.grabPhysMerchL').val());
		$('.takePhysMerchXL').val($('.grabPhysMerchXL').val());
		$('.takePhysMerch2XL').val($('.grabPhysMerch2XL').val());
		$('.takePhysMerch3XL').val($('.grabPhysMerch3XL').val());
		$('.takePhysMerchNA').val($('.grabPhysMerchNA').val());
		$('.takePhysMerchFlatShip').val($('.grabPhysMerchFlatShip').val())
	};
	if($('.physUnlMerch').attr('checked')){
		$('.physMerchUnlPerchCheck').removeClass('hiddenElement');
	};
}); // end click
$('.step3Done').click(function(){
	$('#datepicker3').val($('#datepicker').val());
	$('#datepicker4').val($('#datepicker2').val());
}); // end click
var everythingButTrackValidate = false;
$('.step4Done').click(function(){
	if(creatingSaleAccountHolderType=='fan' || creatingSaleAccountHolderType=='band'){
		validEmail=true;
	};
	if(validEmail==true && validProdName==true && validSaleEnds==true && validTermsOfService==true && validCantChangeAgree==true && validAllPricing==true && allImagesUploaded==true){
		everythingButTrackValidate = true;
	}else{
		// do nothing
	};
});
//************************************************************************** relationship status *****************************************//
var image1clicked = false;
var image2clicked = false;
var image3clicked = false;
var payTypecliced = false;
var musicclicked = false;
var salestrucureclicked = false;
if($('#createSsAccountHolderTypeFondler').attr('accountType')=='new'){
	$('.rockstarShell').css('display','block');
	$('.relationshipBase').change(function(){
		if($(this).attr('sexytime')=='sex'){
			// do nothing
		}else{
			$(this).attr('sexytime','sex');
			$('.rockstarSil').animate({
				'height' : '-=8%'
			},600);
		};
	});
	$('#productImageUploaders').click(function(){
		if(image1clicked==false){
			$('.rockstarSil').animate({
				'height' : '-=8%'
			},600);
			image1clicked=true;
		};
	});
	$('#openTrackListCreatePop').click(function(){
		if(musicclicked==false){
			$('.rockstarSil').animate({
				'height' : '-=8%'
			},600);
			musicclicked=true;
		};
	});
	$('.prefBSSCalcBtn, crCustomSave, .crCustomCalc').click(function(){
		if(salestrucureclicked==false){
			$('.rockstarSil').animate({
				'height' : '-=8%'
			},600);
			salestrucureclicked=true;
		};
	});
	$('#backgroundImageUploaders').click(function(){
		if(image3clicked==false){
			$('.rockstarSil').animate({
				'height' : '-=10%'
			},600);
			image3clicked=true;
		};
	});
};

//**************************************************************************      create social sale submit        ***********************************

function generateFormData() {
   var form_data = {
        artistName: $('.grabBandName').val(),
        password: $('.crSSConfPass').val(),
        password2: $('.confirmPassword').val(),
        firstName: $('.grabFirstName').val(),
        lastName: $('.grabLastName').val(),
        website: $('.grabBandURL').val(),
        email: $(".takeEmail").val(),
        productName: $(".takeProdName").val(),
        productImageId: productImageId,
        productType: "DigitalMusic",
        decrement: $('#saleaPriceStDecGrab').text(),
        lowPrice: $('#salePriceStLoPri').text(),
        startPrice: $('#salePriceStPriGrab').text(),
        saleEnd: $("#datePickerFinal").val(),
		accountTypePreCreateSs: creatingSaleAccountHolderType,
        backgroundId: BackgroundImageId,
		accentColor: $('#accentColor').val()
    }; // end form_data
    if (form_data.productType=='Physical Music' || form_data.productType=='PhysicalMusic') {
        form_data.prodPhysMusShip = $('.grabFlatShip').val();
        form_data.prodPhysMusPurchLim = $('.takePhysPurchLim1').val();
        form_data.prodPhysMusUnlPurch = $('.takePhysPurchUnl').is(':checked');
        form_data.physicalTrackCount = physicalTrackCounter;
        for(var i=0; i<physicalTrackCounter; i++) {
            form_data['physicalTracksTitle'+i] = 1;
        }
    } else if (form_data.productType=='Digital Music' || form_data.productType=='DigitalMusic') {
        form_data.digitalTrackCount = digitalTrackCount;
        for(var i=0; i<=digitalTrackCount; i++) {
            form_data["digitalTrackTitleIds"+i] = $('#rumpsIndividualTrackID'+i).val();
            form_data["digitalTrackTitle"+i] = $('#digitalTrackTitleIn'+i).val();
        }
    }
    return form_data;
}

$('#openMockBrowser').click(function() {
 	var form_data = generateFormData();
    form_data.requestType= 'SocialSaleTest'

    $.ajax({
    	type: "POST",
    	url: 'request.php',
    	data: form_data,
    	success: function(response){
        	if(response=='success') {
            	$('.openThePreviewSale').trigger('click');
        	} else {
            	$("#newError").html("<p>Could not create preview:"+response+"</p>");
        	}
    	}
    }); // end success
    return true;
});

$('.createSSFinalBtn').click(function() {
	if(everythingButTrackValidate==true){
		if($('.audioUploadsNumberPending').text()==$('.audioUploadsNumberComplete').text()){
			$('.step4Done').css('display','none');
			$('.createSsBtnLoadingShell').css('visibility','visible');
			var form_data = generateFormData();
			form_data.requestType= 'CreateAccountArtistProductSale' // or test
			$.ajax({
				type: "POST",
				url: 'request.php',
				data: form_data,
				success: function(response){
					if(parseInt(response)>0) {
						$(window).bind('beforeunload', function(){});
						window.location='socialsale&id='+response;
					} else {
						$("#newError").html("<p>"+response+"</p>");
						$('.step4Done').show();
						$('.createSsBtnLoadingShell').css('visibility','invisible');
					}
				}
			}); // end success
			return false;
		}else{
			alert('Please wait for the rest of your tracks to upload.');
		};
	};
});
//**************************************************************************      end code        ***********************************
});

function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
          oldonload();
          func();
        }
    }
}
