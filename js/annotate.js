a = {};
if(!localStorage.getItem('annotate-banner-rotate')) {
	localStorage.setItem('annotate-banner-rotate', 0);
}
a.run = function() {
	var c = parseInt(localStorage.getItem('annotate-banner-rotate'));
		if(a.isEven(c) && window.location.href === 'http://annotate.tech/index.php') {
			$('#main_banner').attr('src', 'images/annotate_banner_1.jpg');
			$('#banner-h1, #banner-h5').addClass('black-text');

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
