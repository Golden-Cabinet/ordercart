$(document).ready(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: (target.offset().top)-71
        }, 1000);
        return false;
      }
    }

  });

	var view_height = $( window ).height();
  var browser_height_minus_header = (view_height-70);
  $('#home_title_container').height(browser_height_minus_header);

   $("#home_title_container").backstretch("/assets/images/home-title.jpg");	
 
});



function toggleFAQ(element) {
	$(element).next().slideToggle()
	if($(element).hasClass('faq_closed')) {
		$(element).removeClass('faq_closed')
		$(element).addClass('faq_open')
	} else {
		$(element).removeClass('faq_open')
		$(element).addClass('faq_closed')
	}

}

navigator.sayswho= (function(){
    var ua= navigator.userAgent, tem, 
    M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE '+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\bOPR\/(\d+)/)
        if(tem!= null) return 'Opera '+tem[1];
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join(' ');
})();

function showHomepageModal(target) {
	
	$('#homepage_'+target+'_modal').modal('show')
	
}

function confirmDeleteUser() {
	$('#delete_confirmation_modal').modal('show')
	
}