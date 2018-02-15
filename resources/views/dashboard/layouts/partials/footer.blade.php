<!-- Bootstrap core JavaScript -->
<div class="w-100" style="clear:both; padding: 0 0 75px 0"></div>
<footer class="footer">
	<img src="/images/golden-cabinet-logo.svg" class='logo-small'>
	<div id="footer_info_container">
		(503) 233-4102<br />
		<a href="https://www.google.com/maps/preview?q=4203+SE+Hawthorne+Suite+A,+Portland+OR+97215&hnear=4203+SE+Hawthorne+Blvd,+Portland,+Multnomah,+Oregon+97215&gl=us&t=m&z=16">4203 SE Hawthorne Blvd Ste A, Portland OR 97215</a><br />
		Open Monday-Friday 9-6, Saturday 9-12, closed on Sunday
	</div>
</footer>

<script>
// Google Analytics
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

if (location.hostname.substr(-6) != ".local") {
  ga('create', 'UA-92800110-1', 'auto');
  ga('send', 'pageview');  
}
</script>

<script src="/js/app.js"></script>
<script src="/js/site.js"></script>
<script>
	$(document).ready(function(){
		$('input[type=search]').addClass('form-control');
	});
	
</script>	


@stack('js') 

@stack('dataSet')
</body>

</html>