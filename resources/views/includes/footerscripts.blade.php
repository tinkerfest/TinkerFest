
<script type="text/javascript">
	if( window.location.href.indexOf('#') > 0) {
		history.pushState("", document.title, window.location.pathname);
	}
</script>
<script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
	$.fn.extend({
	    animateCss: function (animationName) {
	        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
	        this.addClass('animated ' + animationName).one(animationEnd, function() {
	            $(this).removeClass('animated ' + animationName);
	        });
	    }
	});
	$(document).ready(function () {
		$('#gotoTop').click(function () {
			$('body').animate({scrollTop:0},200);
		})
	})
</script>
<script type="text/javascript" src="/js/clamp.min.js"></script>
<script type="text/javascript" src="/js/tether.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/mdb.min.js"></script>
<script type="text/javascript" src="/js/customizer.min.js"></script>
<script type="text/javascript" src="/js/ui-support.js"></script>