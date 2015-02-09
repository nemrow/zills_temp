$(document).ready(function(e) {
	$('.feedbackButtonShellOpen').live('click',function(){
		$('.feedbackFormShell').animate({
			'left':'0px'	
		},1000);
		$(this).html('<div class="feedbackDisapearArrow"></div>');
		$(this).removeClass('feedbackButtonShellOpen').addClass('feedbackButtonShellClose');	
	});
	$('.feedbackButtonShellClose').live('click',function(){
		$('.feedbackFormShell').animate({
			'left':'-450px'	
		},1000);
		$(this).html('<p>Feedback</p><div class="feedbackSpeakerIcon"></div>');
		$(this).removeClass('feedbackButtonShellClose').addClass('feedbackButtonShellOpen');	
	});
	$('.feedbackDropDownBtn, .feedbackDropDownShell').click(function(){
		$('.feedbackDropDownContainer').css({'height':'140px'});
		$('.feedbackDropDownSelectionShell').css({'display':'block'}).animate({
			'top' :	'0px'
		},800);
		$('.feedbackTextArea').animate({
			'height' :	'93px'
		},800);
	});
	$('.feedbackSelectProblem').click(function(){
		$('.feedbackSelectedArrow').css({'top':'18px'});
		$('.feedbackDropDownCurrentText').text('Problem With Site');
		$('.feedbackDropDownContainer').css({'height':'50px'});
		$('.feedbackDropDownSelectionShell').css({'display':'none','top':'-140px'});
		$('.feedbackTextArea').css({'height':'183px'});
	});
	$('.feedbackSelectImprove').click(function(){
		$('.feedbackSelectedArrow').css({'top':'63px'});
		$('.feedbackDropDownCurrentText').text('Site Improvement');
		$('.feedbackDropDownContainer').css({'height':'50px'});
		$('.feedbackDropDownSelectionShell').css({'display':'none','top':'-140px'});
		$('.feedbackTextArea').css({'height':'183px'});
	});
	$('.feedbackSelectOther').click(function(){
		$('.feedbackSelectedArrow').css({'top':'109px'});
		$('.feedbackDropDownCurrentText').text('Other');
		$('.feedbackDropDownContainer').css({'height':'50px'});
		$('.feedbackDropDownSelectionShell').css({'display':'none','top':'-140px'});
		$('.feedbackTextArea').css({'height':'183px'});
	});
	$('.feedbackInput1').focus(function(){
		if($(this).val()=='Your Email'){
			$(this).val('');
		};
	}).blur(function(){
		if($(this).val()==''){
			$(this).val('Your Email');
		}
	});
	$('.feedbackTextArea').focus(function(){
		if($(this).val()=='Please Explain...'){
			$(this).val('');
		};
	}).blur(function(){
		if($(this).val()==''){
			$(this).val('Please Explain...');
		}
	});

	$('.feedbackSubmitBtn').click(function(){
		$('.feedbackFormShell').animate({
			'left':'-450px'	
		},1000);
		$('.feedbackButtonShell').html('<p>Feedback</p><div class="feedbackSpeakerIcon"></div>');
		$('.feedbackButtonShell').removeClass('feedbackButtonShellClose').addClass('feedbackButtonShellOpen');
		
		var form_data = {
			email: $('.feedbackInput1').val(),
        	category: $('.feedbackDropDownCurrentText').text(),
        	content: $('.feedbackTextArea').val(),
			userAgent: BrowserDetect.browser + ' ' + BrowserDetect.version + ' on ' + BrowserDetect.OS,
			requestType: 'FeedBackHandler',
			is_ajax: 1
		};
		$.ajax({
		type: "POST",
		url: 'request.php',
                data: form_data,
                success: function(response) {
				if(response=='success') {
					//alert(response);
				} else {
					alert(response);
				}
    		}
    	}); // end success
		$('.feedbackInput1').val('Your Email');
		$('.feedbackTextArea').val('Please Explain...');
		return true;
	});
	var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]
	};
	BrowserDetect.init();
	
});