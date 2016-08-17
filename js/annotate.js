a = {};
if(!localStorage.getItem('annotate-banner-rotate')) {
	localStorage.setItem('annotate-banner-rotate', 0);
}
a.run = function() {
	var c = parseInt(localStorage.getItem('annotate-banner-rotate'));
		if(a.isEven(c)) {
			$('#main_banner').attr('src', 'images/annotate_banner_1.jpg');
			$('#banner-h1, #banner-h5').addClass('black-text');

		} else if(a.isThree(c)) {
			$('#main_banner').attr('src', 'images/annotate_home_banner.jpg');
			$('#banner-h1, #banner-h5').addClass('black-text');
			$('#banner-h1').text('Thanks for using Annotate').addClass('screen-reader-only');
			$('#banner-h5').remove();
		} else {
			$('#main_banner').attr('src', 'images/annotate_banner_2.jpg');
			$('#banner-h1 #banner-h5').addClass('white-text');
			$('#banner-h1').text('With you wherever you work').css('font-size', '2.5rem');
		}
	c++;
	localStorage.setItem('annotate-banner-rotate', c);
}


a.isEven = function (n) {
  return n == parseFloat(n)? !(n%2) : void 0;
}

// Use strict equality === for "is number" test
a.isEvenStrict = function (n) {
  return n === parseFloat(n)? !(n%2) : void 0;
}

a.isThree = function (n) {
  return n == parseFloat(n)? !(n%3) : void 0;
}

function validate() {
	//event.preventDefault();

	if(!validate_stuff()) {
		event.preventDefault();
	} else {
		return true;
	}
}

function validate_stuff() {
	var email = $('#email'),
		emailval = $(email).val(),
		pass1 = $('#signpassword'),
		pass1val = $(pass1).val(),
		pass2 = $('#repassword'),
		pass2val = $(pass2).val(),
		retVal = true;

	if($(email).val() === "") {
		$(email).addClass('invalid');
		retVal = false;
	} else {
		$(email).removeClass('invalid').addClass('valid');
	}

	if(pass1val.length < 8) {
		$(pass1).attr('data-error', 'Passwords must be at least 8 characters').addClass('invalid');
		retVal = false;
	}
	else if(pass1val === "" && pass2val === "") {
		$(pass1).attr('data-error', 'Passwords cannot be blank').addClass('invalid');
		$(pass2).attr('data-error', 'Passwords must match and cannot be blank').addClass('invalid');
		retVal = false;
	} else if (pass1val !== pass2val) {
		$(pass2).attr('data-error', 'Passwords must match').addClass('invalid');
		retVal = false;
	} else {
		$(pass1, pass2).removeClass('invalid').addClass('valid');
	}

	return retVal;	
}


  function setEvents() {
    $('#install-button').click(function(e) {
      e.preventDefault();
      chrome.webstore.install()      
    });
  }

  setEvents();
