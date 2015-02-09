// JavaScript Document
$(document).ready(function(){
//**************************************************************************      begin code        ***********************************
//**************************************************************************      code        ***********************************
var typeOfSale = 'undefined';
$('.typeClickedDigMus').click(function(){
	$('.crSSStyleDropDigMus').slideDown(600);
	$('.crSSStyleDropPhysMus, .crSSStyleDropPhysMerch, .crSSStyleDropPhysMus2, .crSSStyleDropPhysMerch2').slideUp(600);
	typeOfSale = 'digital';
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
//**************************************************************************      Phys Merch Sizes        ***********************************
var sizeSelected = undefined;
var sizeXS = sizeS = sizeM = sizeL = sizeXL = size2XL = size3XL = sizeNA = 1;
$('.physUnlMerch').click(function(){
	if($('.physUnlMerch').attr('checked')){
		$('.physMerchQuantRow').addClass('physMerchQuantRowGone');
	} else {
		$('.physMerchQuantRow').removeClass('physMerchQuantRowGone');
	};
}); // end click
$('.SizeXS').click(function(){
	if(sizeNA != 2){
		if(sizeXS == 1){
			sizeSelected = 'XS';
			sizeXS = 2;
			$('.SizeXS').addClass('sAndQBoxSelected');
			$('.sizeOutXS').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		}else{
			sizeXS = 1;
			$('.SizeXS').removeClass('sAndQBoxSelected');
			$('.sizeOutXS').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		};
	}else{ // end if sizeNA != 2
		return false;
};
}); // end click
$('.SizeS').click(function(){
	if(sizeNA != 2){
		if(sizeS == 1){
			sizeSelected = 'S';
			sizeS = 2;
			$('.SizeS').addClass('sAndQBoxSelected');
			$('.sizeOutS').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		}else{
			sizeS = 1;
			$('.SizeS').removeClass('sAndQBoxSelected');
			$('.sizeOutS').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		};
	}else{
		return false;
	};
}); // end click
$('.SizeM').click(function(){
	if(sizeNA != 2){
		if(sizeM == 1){
			sizeSelected = 'M';
			sizeM = 2;
			$('.SizeM').addClass('sAndQBoxSelected');
			$('.sizeOutM').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		}else{
			sizeM = 1;
			$('.SizeM').removeClass('sAndQBoxSelected');
			$('.sizeOutM').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		};
	}else{
		return false;
	};
}); // end click
$('.SizeL').click(function(){
	if(sizeNA != 2){
		if(sizeL == 1){
			sizeSelected = 'L';
			sizeL = 2;
			$('.SizeL').addClass('sAndQBoxSelected');
			$('.sizeOutL').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		}else{
			sizeL = 1;
			$('.SizeL').removeClass('sAndQBoxSelected');
			$('.sizeOutL').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		};
	}else{
		return false;
	};
}); // end click
$('.SizeXL').click(function(){
	if(sizeNA != 2){
		if(sizeXL == 1){
			sizeSelected = 'XL';
			sizeXL = 2;
			$('.SizeXL').addClass('sAndQBoxSelected');
			$('.sizeOutXL').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		}else{
			sizeXL = 1;
			$('.SizeXL').removeClass('sAndQBoxSelected');
			$('.sizeOutXL').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		};
	}else{
		return false;
	};
}); // end click
$('.Size2XL').click(function(){
	if(sizeNA != 2){
		if(size2XL == 1){
			sizeSelected = '2XL';
			size2XL = 2;
			$('.Size2XL').addClass('sAndQBoxSelected');
			$('.sizeOut2XL').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		}else{
			size2XL = 1;
			$('.Size2XL').removeClass('sAndQBoxSelected');
			$('.sizeOut2XL').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		};
	}else{
		return false;
	};
}); // end click
$('.Size3XL').click(function(){
	if(sizeNA != 2){
		if(size3XL == 1){
			sizeSelected = '3XL';
			size3XL = 2;
			$('.Size3XL').addClass('sAndQBoxSelected');
			$('.sizeOut3XL').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		}else{
			size3XL = 1;
			$('.Size3XL').removeClass('sAndQBoxSelected');
			$('.sizeOut3XL').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		};
	}else{
		return false;
	};
}); // end click
$('.SizeNA').click(function(){
	if(sizeNA == 1){
		sizeSelected = 'NA';
		sizeNA = 2;
		$('.SizeNA').addClass('sAndQBoxSelected');
		$('.sizeOutNA').addClass('sAndQBoxSelectedWhite').removeAttr('disabled','disabled').focus();
		$('.SizeXS, .SizeS, .SizeM, .SizeL, .SizeXL, .Size2XL, .Size3XL').removeClass('sAndQBoxSelected');
		$('.sizeOutXS, .sizeOutS, .sizeOutM, .sizeOutL, .sizeOutXL, .sizeOut2XL, .sizeOut3XL').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
		sizeXS = sizeS = sizeM = sizeL = sizeXL = size2XL = size3XL = 1;
	}else{
		sizeNA = 1;
		$('.SizeNA').removeClass('sAndQBoxSelected');
		$('.sizeOutNA').removeClass('sAndQBoxSelectedWhite').attr('disabled','disabled').val('');
	};
}); // end click
//**************************************************************************   Validation  ***********************************
var validBandName = false;
var validEmail = false;
var validPassword = false;
var validFirstName = false;
var validLastName= false;
var validPayPalEmail = false;

var validatePage1 = function(){
//$('.step1Done').click(function(){
	if($('.grabBandName').val()==''){
		validBandName = false;
		if($('.grabBandName').next().text()!='This field is required.'){
		$('.grabBandName').addClass('error').after('<label class="error">This field is required.</label>');
		};
	}else{
		if($('.grabBandName').next().text()=='This field is required.'){
			$('.grabBandName').removeClass('error').next().remove();
		};
		validBandName = true;
	}; // end validatin grabBandName

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
	}else{
		if($('.crSSConfPass').next().text()=='Please provide a password at least 8 charecters long.'){
			$('.crSSConfPass').removeClass('error').next().remove();
		};
	}; // end validate initial password

	if($('.confirmPassword').val()==$('.crSSConfPass').val()){
		if($('.confirmPassword').next().text()=='Passwords do not match.'){
			$('.confirmPassword').removeClass('error').next().remove();
		};
		validPassword = true;
	}else{
		if($('.confirmPassword').next().text()!='Passwords do not match.'){
		$('.confirmPassword').addClass('error').after('<label class="error">Passwords do not match.</label>');
		validPassword = false;
		};
	}; // end validate confirm password

	if($('.grabFirstName').val()==''){
		if($('.grabFirstName').next().text()!='Please provide your first name.'){
		$('.grabFirstName').addClass('error').after('<label class="error">Please provide your first name.</label>');
		};
		validFirstName = false;
	}else{
		if($('.grabFirstName').next().text()=='Please provide your first name.'){
			$('.grabFirstName').removeClass('error').next().remove();
		};
		validFirstName = true;
	}; // end validate first name

	if($('.grabLastName').val()==''){
		if($('.grabLastName').next().text()!='Please provide your last name.'){
		$('.grabLastName').addClass('error').after('<label class="error">Please provide your last name.</label>');
		};
		validLastName = false;
	}else{
		if($('.grabLastName').next().text()=='Please provide your last name.'){
			$('.grabLastName').removeClass('error').next().remove();
		};
		validLastName = true;
	}; // end validate last name

	var payPalEmailTest=$('.paypalEmailIn').val();
	var atpos=payPalEmailTest.indexOf("@");
	var dotpos=payPalEmailTest.lastIndexOf(".");
	if(payPalEmailTest=='E-Check'){
		if($('.paypalEmailIn').next().text()=='Please provide a valid email address.'){
			$('.paypalEmailIn').removeClass('error').next().remove();
			validPayPalEmail = true;
		};
	}else{
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=payPalEmailTest.length){
  		if($('.paypalEmailIn').next().text()!='Please provide a valid email address.'){
			$('.paypalEmailIn').addClass('error').after('<label class="error">Please provide a valid email address.</label>');
		};
		validPayPalEmail = false;
	}else{
		if($('.paypalEmailIn').next().text()=='Please provide a valid email address.'){
		$('.paypalEmailIn').removeClass('error').next().remove();
		};
		validPayPalEmail = true;
	};
	}; // end validating grabEmail
}; // end validatePage1
var validProdName = false;
var validPhysFlatShipRate = false;
var validPhysPurchLimit = false;
var validMerchShipping = false;
var validMerchQuant = false;
var validCompleteTYpeSpecs = false;
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
	if(typeOfSale=='digital'){
		if(digitalTrackCount<1){
			if($('.crSSStyleDropPhysMus').next().text()!='You have not added any tracks.'){
			$('.crSSStyleDropPhysMus').after('<label class="error specialDigUploadError">You have not added any tracks.</label>');
			};
			validDigitalTrackCount = false;
		}else{
			if($('.crSSStyleDropPhysMus').next().text()=='You have not added any tracks.'){
				$('.crSSStyleDropPhysMus').next().remove();
			};
			validDigitalTrackCount = true;
		};
	} // end if digital sale

	if(typeOfSale=='physical'){
		if($('#physicalTrackCount').val()<1){
			if($('.crSSStyleDropPhysMus').next().text()!='You have not added any tracks.'){
			$('.crSSStyleDropPhysMus').after('<label class="error specialDigUploadError">You have not added any tracks.</label>');
			};
			validPhysicalTrackCount = false;
		}else{
			if($('.crSSStyleDropPhysMus').next().text()=='You have not added any tracks.'){
				$('.crSSStyleDropPhysMus').next().remove();
			};
			validPhysicalTrackCount = true;
		}; // end if no tracks in physical track list
		if($('.takeFlatShip').val()==''){
			$('.flatShipText').effect("shake", { times:3 }, 190).addClass('errorWithShaddow');
			validPhysFlatShipRate = false;
		}else{
			$('.flatShipText').removeClass('errorWithShaddow');
			validPhysFlatShipRate = true;
		};
		if($('#unlPhysPurch').attr('checked')){
			$('.purchLimitText').removeClass('errorWithShaddow');
			validPhysPurchLimit = true;
		}else{
			if($('.grabPhysPurchLim1').val()==''){
				$('.purchLimitText').effect("shake", { times:3 }, 190).addClass('errorWithShaddow');
				validPhysPurchLimit = false;
			}else{
				$('.purchLimitText').removeClass('errorWithShaddow');
				validPhysPurchLimit = true;
			}; // end if no value
		}; // end purchase limit validation
	}; // end if physical

	if(typeOfSale=='merch'){
		if($('.grabPhysMerchFlatShip').val()==''){
			$('.flatCostMerchText').effect("shake", { times:3 }, 190).addClass('errorWithShaddow');
			validMerchShipping = false;
		}else{
			$('.flatCostMerchText').removeClass('errorWithShaddow');
			validMerchShipping = true;
		}; // end if values
		if(sizeXS==2||sizeS==2||sizeM==2||sizeL==2||sizeXL==2||size2XL==2||size3XL==2||sizeNA==2){
			if($('.grabPhysMerchXS').val()!=''||$('.grabPhysMerchS').val()!=''||$('.grabPhysMerchM').val()!=''||$('.grabPhysMerchL').val()!=''||$('.grabPhysMerchXL').val()!=''||$('.grabPhysMerch2XL').val()!=''||$('.grabPhysMerch3XL').val()!=''||$('.grabPhysMerchNA').val()!=''||$('.physUnlMerch').attr('checked')){
				if($('.sizeQuantCatcherForValid').next().text()=='Check your sizes and quantities.'){
					$('.sizaQuantShell').next().remove();
				};
				validMerchQuant = true;
			}else{
				if($('.sizeQuantCatcherForValid').next().text()!='Check your sizes and quantities.'){
					$('.sizaQuantShell').after('<label class="error specialDigUploadError">Check your sizes and quantities.</label>');
				};
				validMerchQuant = false;
			};
		}else{
			if($('.sizeQuantCatcherForValid').next().text()!='Check your sizes and quantities.'){
				$('.sizaQuantShell').after('<label class="error specialDigUploadError">Check your sizes and quantities.</label>');
			};
			validMerchQuant = false;
		};// end if sizes are valid
	}; // end if merch

	if(typeOfSale=='undefined'){
		$('.proTypeEyeCatcher').effect("shake", { times:3 }, 190).css('color','red');
	};

	if(typeOfSale=='digital'){
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
		if(typeOfSale=='merch'){
			if(validMerchShipping==true && validMerchQuant==true){
				validCompleteTYpeSpecs = true;
			}else{
				validCompleteTYpeSpecs = false;
			};
		};
};
var validStartPrice = false;
var validFloorPrice = false;
var validDecPrice = false;
var validHitNum = false;
var validAllPricing = false;
var validSaleEnds = false;
var VhitNum = 'undefined'; // declared here, defined below with the calculate feature
var validatePage3 = function(){
	var VstartPrice = $('.salePriceStPriGrab').text().replace('$','');
	var VfloorPrice = $('.salePriceStLoPriGrab').text().replace('$','');
	var VdecPrice = $('.saleaPriceStDecGrab').text().replace('$','');
	//alert(VstartPrice+' '+VfloorPrice+' '+VdecPrice+' '+VhitNum);
	if(VstartPrice!='NaN' && VstartPrice>0){
		validStartPrice = true;
	}else{
		validStartPrice = false;
	};
	if(VfloorPrice!='NaN' && VstartPrice>0){
		validFloorPrice = true;
	}else{
		validFloorPrice = false;
	};
	if(VdecPrice!='NaN' && VdecPrice>0){
		validDecPrice = true;
	}else{
		validDecPrice = false;
	};
	if(VhitNum!='NaN' && VhitNum>0){
		validHitNum = true;
	}else{
		validHitNum = false;
	};
	if(validStartPrice==true && validFloorPrice==true && validDecPrice==true && validHitNum==true){
		if($('.indiSalePriceStateErrorCheck').next().text()=='Your pricing model does not work. Please fix it.'){
			$('.salePriceStatement, .crCustomSaleTable').next().remove();
		};
		validAllPricing = true;
	}else{
		if($('.indiSalePriceStateErrorCheck').next().text()!='Your pricing model does not work. Please fix it.'){
		$('.salePriceStatement, .crCustomSaleTable').after('<label class="error specialPriceError">Your pricing model does not work. Please fix it.</label>');
		validAllPricing = false;
		};
	};
	if($('#datepicker').val()!=''){
		$('.saleEndsEyeCatcher').css('color','white');
		validSaleEnds = true;
	}else{
		$('.saleEndsEyeCatcher').effect("shake", { times:3 }, 190).css('color','red');
		validSaleEnds = false;
	};
};
var validDigitalTrackCount = false;
var validPhysicalTrackCount = false;
var validPreviewedPage = false;
var validTermsOfService = false;
var validCantChangeAgree = false;
var validatePage4 = function(){
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

	if(typeOfSale=='digital'){
		if(digitalTrackCount<1){
			if($('.crSSStyleDropDigMus2').next().text()!='You have not uploaded any tracks.'){
			$('.crSSStyleDropDigMus2').after('<label class="error specialDigUploadError">You have not uploaded any tracks.</label>');
			};
			validDigitalTrackCount = false
		}else{
			if($('.crSSStyleDropDigMus2').next().text()=='You have not uploaded any tracks.'){
				$('.crSSStyleDropDigMus2').next().remove();
			};
			validDigitalTrackCount = true;
		}; // end if no tracks in digital list
	}; // end if digital

	if(typeOfSale=='physical'){
		if($('#physicalTrackCount').val()<1){
			if($('.crSSStyleDropPhysMus2').next().text()!='You have not added any tracks.'){
			$('.crSSStyleDropPhysMus2').after('<label class="error specialDigUploadError">You have not added any tracks.</label>');
			};
			validPhysicalTrackCount = false;
		}else{
			if($('.crSSStyleDropPhysMus2').next().text()=='You have not added any tracks.'){
				$('.crSSStyleDropPhysMus2').next().remove();
			};
			validPhysicalTrackCount = true;
		}; // end if no tracks in physical track list
		if($('.grabFlatShip').val()==''){
			$('.flatShipText').effect("shake", { times:3 }, 190).addClass('errorWithShaddow');
			validPhysFlatShipRate = false;
		}else{
			$('.flatShipText').removeClass('errorWithShaddow');
			validPhysFlatShipRate = true;
		};
		if($('#unlPhysPurchPage4').attr('checked')){
			$('.purchLimitText').removeClass('errorWithShaddow');
			validPhysPurchLimit = true;
		}else{
			if($('.takePhysPurchLim1').val()==''){
				$('.purchLimitText').effect("shake", { times:3 }, 190).addClass('errorWithShaddow');
				validPhysPurchLimit = false;
			}else{
				$('.purchLimitText').removeClass('errorWithShaddow');
				validPhysPurchLimit = true;
			}; // end if no value
		}; // end purchase limit validation
	}; // end if physical

	if(typeOfSale=='merch'){
		if($('.takePhysMerchFlatShip').val()==''){
			$('.flatCostMerchText').effect("shake", { times:3 }, 190).addClass('errorWithShaddow');
			validMerchShipping = false;
		}else{
			$('.flatCostMerchText').removeClass('errorWithShaddow');
			validMerchShipping = true;
		}; // end if values
		if(sizeXS==2||sizeS==2||sizeM==2||sizeL==2||sizeXL==2||size2XL==2||size3XL==2||sizeNA==2){
			if($('.takePhysMerchXS').val()!=''||$('.takePhysMerchS').val()!=''||$('.takePhysMerchM').val()!=''||$('.takePhysMerchL').val()!=''||$('.takePhysMerchXL').val()!=''||$('.takePhysMerch2XL').val()!=''||$('.takePhysMerch3XL').val()!=''||$('.takePhysMerchNA').val()!=''||$('.physUnlMerch').attr('checked')){
				if($('.sizeQuantCatcherForValid').next().text()=='Check your sizes and quantities.'){
					$('.sizaQuantShell').next().remove();
				};
				validMerchQuant = true;
			}else{
				if($('.sizeQuantCatcherForValid').next().text()!='Check your sizes and quantities.'){
					$('.sizaQuantShell').after('<label class="error specialDigUploadError">Check your sizes and quantities.</label>');
				};
				validMerchQuant = false;
			};
		}else{
			if($('.sizeQuantCatcherForValid').next().text()!='Check your sizes and quantities.'){
				$('.sizaQuantShell').after('<label class="error specialDigUploadError">Check your sizes and quantities.</label>');
			};
			validMerchQuant = false;
		};// end if sizes are valid
	}; // end if merch

	if($('#datepicker3').val()!=''){
		$('.saleEndsEyeCatcher').css('color','white');
		validSaleEnds = true;
	}else{
		$('.saleEndsEyeCatcher').effect("shake", { times:3 }, 190).css('color','red');
		validSaleEnds = false;
	}; // end validate end sale date

	if(validPreviewedPage==false){
		$('.redGreenLightP').effect("shake", { times:3 }, 190).css('color','red');
	};

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
//**************************************************************************     login        ***********************************
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
//**************************************************************************     send check        ***********************************
$('.sendCheckSelected').click(function(){
	if($(this).attr('checked')){
		$('.paypalEmailIn').addClass('sendCheckGrey').attr('disabled','disabled').val('E-Check');
		if($('.paypalEmailIn').next().text()=='Please provide a valid email address.'){
			$('.paypalEmailIn').removeClass('error').next().remove();
		}
		validPayPalEmail = true;
	}else{
		$('.paypalEmailIn').removeClass('sendCheckGrey').removeAttr('disabled','disabled').val('');
		$('.paypalEmailIn').addClass('error').after('<label class="error">Please provide a valid email address.</label>');
	}
}); // end click
//**************************************************************************     create pricing        ***********************************

var bottomHitNum = 0;
$('.crCustomCalc').click(function(){
	bottomHitNum = (parseFloat((($('.crCDStart').val()) - ($('.crCDEnd').val())) / ($('.crCDDec').val())).toFixed(0));
	$('.crCustomInsP').text(bottomHitNum);
	$('.salePriceStPri').text($('.crCDStart').val());
	$('.salePriceStPri').text('$'+(parseFloat($('.crCDStart').val()).toFixed(2)));
	$('.salePriceStLoPri').text('$'+(parseFloat($('.crCDEnd').val()).toFixed(2)));
	$('.saleaPriceStDec').text('$'+(parseFloat($('.crCDDec').val()).toFixed(3)));
	$('.salePriceStToReach').text(parseFloat(bottomHitNum).toFixed(0));
	VhitNum = parseFloat(bottomHitNum).toFixed(0); // variable declared in validation
	$('.salePriceStatement').slideDown(300);
}); // end click
$('.crCustomSave').click(function(){
	$('#fancybox-close').trigger('click');
}); // end click
$('.prefBSSCalcBtn').click(function(){
	var ceilingP = $('.prefBSSCieling').val();
	var floorP = (ceilingP * .20);
	var pastSale = $('.prefBSSPastSale').val();
	var decStruc = ((ceilingP - floorP)/(pastSale * 1.3));
	var toGetTo = ((ceilingP - floorP)/decStruc);
	$('.salePriceStPri').text('$'+(parseFloat(ceilingP).toFixed(2)));
	var startPriceGrab = parseFloat(ceilingP).toFixed(2);
	var lowPriceGrab = parseFloat(floorP).toFixed(2);
	var decPriceGrab = parseFloat(decStruc).toFixed(3);
	var getToGrab = parseFloat(toGetTo).toFixed(0);
	$('.salePriceStLoPri').text('$'+(parseFloat(floorP).toFixed(2)));
	$('.saleaPriceStDec').text('$'+(parseFloat(decStruc).toFixed(3)));
	$('.salePriceStToReach').text(parseFloat(toGetTo).toFixed(0));
	VhitNum = parseFloat(toGetTo).toFixed(0); // variable declared in validation
	$(this).text('Recalculate').css('background-color','#367436');
	$('.salePriceStatement, p.prefBSSSuggestBtn, p.prefBSSOr, p.prefBSSGoCustomBtn').slideDown(300);
	$('.crCDStart').val(startPriceGrab);
	$('.crCDEnd').val(lowPriceGrab);
	$('.crCDDec').val(decPriceGrab);
	$('.crCustomInsP').text(getToGrab);
}); // end click
$('.prefBSSSuggestBtn').click(function(){
	$('#fancybox-close').trigger('click');
}); // end click
$('.prefBSSGoCustomBtn').click(function(){
	$('#fancybox-close, .customPricingBtn').trigger('click')
}); // end click
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
	$('.digitalTrackTitleIn').focus(function(){
	if($(this).val()==("Enter track title here")){
		$(this).val("");
	};
}); // end focus
}; // end function
var digitalTrackTitleBlur = function(){
	$('.digitalTrackTitleIn').blur(function(){
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
$('#openTrackListPhysPop2').fancybox();
$('#openCrCustomSS').fancybox();
$('#openCrCustomSS2').fancybox();
$('#openCrPrefSS').fancybox();
$('#openCrPrefSS2').fancybox();
$('#openLoginBox').fancybox();
$('#openSendCheckBox').fancybox()
$('#openMockBrowser').fancybox({
		'height' : '100%',
		'width': '100%'
});
$("#datepicker").datepicker({ minDate: 0, defaultDate: +10 });
$("#datepicker3").datepicker({ minDate: 0 });

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
$('.PrevSaleBtn').click(function(){
	$('.redOrGreenLight').removeClass('redLight').addClass('greenLight');
	$('.redGreenLightP').text('You are ready to create your social sale!').css('color','white');
	validPreviewedPage = true;

}); // end click
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
$('#openLoginBox').fancybox();
//**************************************************************************      icon navigations        ***********************************
var stepAuth = 0;
$('.step1Done').click(function(){
	if(validBandName==true && validEmail==true && validPassword==true && validFirstName==true && validLastName==true && validPayPalEmail==true){
	$('.crSSStep1').slideUp(800);
	$('.crSSStep2').delay(800).slideDown(600);
	$('.crSSTopIcon1').addClass('crSSIconNotActive');
	$('.crSSTopIcon2').addClass('crSSIconClickable');
	$('.crSSTopIcon2').removeClass('crSSIconNotActive');
	$('.loginToSkipS1').fadeOut(300);
	stepAuth++;
	};
}); // end click
$('.step2Done').click(function(){
	if(validProdName==true && typeOfSale!='undefined' && validCompleteTYpeSpecs==true){
	$('.crSSStep2').slideUp(600);
	$('.crSSStep3').delay(600).slideDown(600);
	$('.crSSTopIcon2').addClass('crSSIconNotActive');
	$('.crSSTopIcon3').addClass('crSSIconClickable');
	$('.crSSTopIcon3').removeClass('crSSIconNotActive');
	stepAuth++;
	};
}); // end click
$('.step2Back').click(function(){
	$('.crSSStep2').slideUp(600);
	$('.crSSStep1').delay(600).slideDown(600);
	$('.crSSTopIcon2').addClass('crSSIconNotActive');
	$('.crSSTopIcon1').removeClass('crSSIconNotActive');
}); // end click
$('.step3Done').click(function(){
	if(validAllPricing==true && validSaleEnds==true){
	$('.crSSStep3').slideUp(600);
	$('.crSSStep4').delay(600).slideDown(900);
	$('.crSSTopIcon3').addClass('crSSIconNotActive');
	$('.crSSTopIcon4').addClass('crSSIconClickable');
	$('.crSSTopIcon4').removeClass('crSSIconNotActive');
	stepAuth++;
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
$('.crSSTopIcon1').click(function(){
	$('.crSSStep2, .crSSStep3, .crSSStep4').slideUp(600);
	$('.crSSStep1').delay(600).slideDown(600);
	$('.crSSTopIcon2, .crSSTopIcon3, .crSSTopIcon4').addClass('crSSIconNotActive');
	$('.crSSTopIcon1').removeClass('crSSIconNotActive');
}); // end click
$('.crSSTopIcon2').click(function(){
	if(stepAuth > 0){
	$('.crSSStep1, .crSSStep3, .crSSStep4').slideUp(600);
	$('.crSSStep2').delay(600).slideDown(600);
	$('.crSSTopIcon1, .crSSTopIcon3, .crSSTopIcon4').addClass('crSSIconNotActive');
	$('.crSSTopIcon2').removeClass('crSSIconNotActive');
	}; // end if
}); // end click
$('.crSSTopIcon3').click(function(){
	if(stepAuth > 1){
	$('.crSSStep1, .crSSStep2, .crSSStep4').slideUp(600);
	$('.crSSStep3').delay(600).slideDown(600);
	$('.crSSTopIcon1, .crSSTopIcon2, .crSSTopIcon4').addClass('crSSIconNotActive');
	$('.crSSTopIcon3').removeClass('crSSIconNotActive');
	}; // end if
}); // end click
$('.crSSTopIcon4').click(function(){
	if(stepAuth > 2){
	$('.crSSStep1, .crSSStep2, .crSSStep3').slideUp(600);
	$('.crSSStep4').delay(600).slideDown(900);
	$('.crSSTopIcon1, .crSSTopIcon2, .crSSTopIcon3').addClass('crSSIconNotActive');
	$('.crSSTopIcon4').removeClass('crSSIconNotActive');
	}; // end if
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
	$('.grabSaleTypeText').text($("input[@name=productType]:checked").val());
	if(typeOfSale=='digital'){
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
$('.step4Done').click(function(){
	if(validEmail==true && validProdName==true && validSaleEnds==true && validPreviewedPage==true && validTermsOfService==true && validCantChangeAgree==true && validAllPricing==true){
		if(typeOfSale=='digital'){
			if(validDigitalTrackCount==true){
				alert('type of sale is digital, and is ready to be sent to server');
			}else{
				alert('type of sale is digital, but is not ready to be sent to server');
			};
		};
		if(typeOfSale=='physical'){
			if(validPhysicalTrackCount==true && validPhysFlatShipRate==true && validPhysPurchLimit==true){
				alert('type of sale is physical, and is ready to be sent to the server');
			}else{
				alert('type of sale is physical, but is not ready to be sent to the server');
			};
		};
		if(typeOfSale=='merch'){
			if(validMerchShipping==true && validMerchQuant==true){
				alert('type of sale is merch, and is ready to be sent to server');
			}else{
				alert('type of sale is merch, but is not ready to be sent to server');
			};
		};
	}else{
		alert('not ready to be sent to server');
	};
});
//**************************************************************************      create social sale submit        ***********************************



function generateFormData() {
   var form_data = {
        artistName: $('.grabBandName').val(),
        password: $('.crSSConfPass').val(),
        password2: $('.confirmPassword').val(),
        firstName: $('.grabFirstName').val(),
        lastName: $('.grabLastName').val(),
        website: $('.grabBandURL').val(),
        paypal: $('.paypalEmailIn').val(),
        email: $(".takeEmail").val(),
        productName: $(".takeProdName").val(),
        productDescription: $(".takeDesc").val(),
        productImageId: productImageId,
        productType: $("input[@name=productType]:checked").val(),
        decrement: $('.saleaPriceStDecGrab').text(),
        lowPrice: $('.salePriceStLoPriGrab').text(),
        startPrice: $('.salePriceStPriGrab').text(),
        saleEnd: $("#datepicker3").val(),
        backgroundId: BackgroundImageId,
        logoId: LogoImageId
    }; // end form_data
    if(form_data.productType=='Physical Merch' || form_data.productType=='PhysicalMerch') {
        form_data.prodPhysMerchUnlPurch= $("input[@name=physUnlMerch]:checked").val(); // will return true or false
        form_data.prodPhysMerchShip= $('.takePhysMerchFlatShip').val();
        if(form_data.prodPhysMerchUnlPurch == true) {
            form_data.prodPhysMerchUnlSizeXS = sizeXS==2; // if variable is 1 is is not checked, if 2 if it checked (same for all sizes).
            form_data.prodPhysMerchUnlSizeS = sizeS==2;
            form_data.prodPhysMerchUnlSizeM = sizeM==2;
            form_data.prodPhysMerchUnlSizeL = sizeL==2;
            form_data.prodPhysMerchUnlSizeXL = sizeXL==2;
            form_data.prodPhysMerchUnlSize2XL = size2XL==2;
            form_data.prodPhysMerchUnlSize3XL = size3XL==2;
            form_data.prodPhysMerchUnlSizeNA = sizeNA==2;
        } else {
            form_data.prodPhysMerchSizeXS = $('.takePhysMerchXS').val();
            form_data.prodPhysMerchSizeS = $('.takePhysMerchS').val();
            form_data.prodPhysMerchSizeM = $('.takePhysMerchM').val();
            form_data.prodPhysMerchSizeL = $('.takePhysMerchL').val();
            form_data.prodPhysMerchSizeXL = $('.takePhysMerchXL').val();
            form_data.prodPhysMerchSize2XL = $('.takePhysMerch2XL').val();
            form_data.prodPhysMerchSize3XS = $('.takePhysMerch3XL').val();
            form_data.prodPhysMerchSizeNA= $('.takePhysMerchNA').val();
        }
    } else if (form_data.productType=='Physical Music' || form_data.productType=='PhysicalMusic') {
        form_data.prodPhysMusShip = $('.grabFlatShip').val();
        form_data.prodPhysMusPurchLim = $('.takePhysPurchLim1').val();
        form_data.prodPhysMusUnlPurch = $('.takePhysPurchUnl').is(':checked');
        form_data.physicalTrackCount = physicalTrackCounter;
        for(var i=0; i<physicalTrackCounter; i++) {
            form_data['physicalTracksTitle'+i] = 1;
        }
    } else if (form_data.productType=='Digital Music' || form_data.productType=='DigitalMusic') {
        form_data.digitalTrackCount = digitalTrackCount;
        for(var i=0; i<digitalTrackCount; i++) {
            form_data["digitalTrackTitleIds"+i] = digitalMusicTrackIds[i];
            form_data["digitalTrackTitle"+i] = $('#digitalTrackTitleIn'+i).val();
        }
    }
    return form_data;
}

$('.PrevSaleBtn').click(function() {
 var form_data = generateFormData();
    form_data.requestType= 'SocialSaleTest'

    $.ajax({
    type: "POST",
    url: 'request.php',
    data: form_data,
    success: function(response){
        if(response=='success') {
            $('#openMockBrowser').trigger('click');
        } else {
            $("#newError").html("<p>Could not create preview:"+response+"</p>");
        }
    }
    }); // end success
    return false;
    });


$('.createSSFinalBtn').click(function() {

    var form_data = generateFormData();
    form_data.requestType= 'CreateAccountArtistProductSale'

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
        }
    }
    }); // end success
    return false;
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
