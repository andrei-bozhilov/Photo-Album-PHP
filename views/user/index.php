<div class="col-md-12">
	<h1>Here you can organize your photos</h1>
</div>
<div class="col-md-3">
<?php include_once("/views/user/user-navigation.php") ?>
</div>

<div class="col-md-9">
<div id="show-albums">
	
</div>
<script type="application/javascript" src="/content/bower_components/jquery/dist/jquery.js"></script>
<script>

	$(function() {
		var scrollDiv = 650;
		var i = 0;
			$.ajax({
					url : "/user/getAlbumsForCurrentUser/" + i++,
					method : "GET"
				}).success(function(data) {
					$('#show-albums').append(data).hide().fadeIn(500);
				});
		$(window).scroll(function() {

			var scrollTop = parseInt($('body').scrollTop());
				
			console.log(scrollTop);

			if (scrollTop > scrollDiv) {
				scrollDiv = scrollTop + 650;

				$.ajax({
					url : "/user/getAlbumsForCurrentUser/" + i++,
					method : "GET"
				}).success(function(data) {
					$('#show-albums').append(data).hide().fadeIn(500);
				});
			}
		});

	});

</script>
</div>
