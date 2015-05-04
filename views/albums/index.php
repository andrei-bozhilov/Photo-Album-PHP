<div class="col-md-12">
	<h1>Here you can organize your photos</h1>
</div>
<div class="col-md-3">
<?php include_once("/views/albums/user-navigation.php") ?>
</div>

<div class="col-md-9">
<h3 class="album-title no-hover">Yours top 10 pictures</h3>
<div class="slider-wrapper">
	<div id="slider" class="slider-carousel">
		<ul id="carousel" class="carousel-list">
			<li class="slider-element">
				<div>
					<img src="http://files.parsetfss.com/bd42e52e-3ab7-41d8-99a9-eeb0d58a13cd/tfss-2876cc58-4804-4f77-a780-e3207d430e2a-Ddz.jpg">
				</div>
			</li>
		</ul>
	</div>
	<div class="slider-prev" onclick="Actions.sliderPrev()"></div>
	<div class="slider-next" onclick="Actions.sliderNext()"></div>
</div>
<div id="show-albums">
	
</div>
<script type="application/javascript" src="/content/bower_components/jquery/dist/jquery.js"></script>
<script>

	$(function() {
		var scrollDiv = 650;
		var i = 0;
			$.ajax({
					url : "/albums/getAlbumsForCurrentUser/" + i++,
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
					url : "/albums/getAlbumsForCurrentUser/" + i++,
					method : "GET"
				}).success(function(data) {
					$('#show-albums').append(data).hide().fadeIn(500);
				});
			}
		});

	});

</script>
</div>

<?php var_dump($this->getuserId()); ?> 
