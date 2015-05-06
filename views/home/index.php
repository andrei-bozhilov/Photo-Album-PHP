<div class="col-md-12">
	<h1>Welcome to Dothstagram</h1>
	<h2>The best app for sharing your favorite pictures</h2>
</div>

<h3 class="album-title no-hover">20 newest pictures</h3>
<div class="slider-wrapper">
	<div id="slider" class="slider-carousel">
		<ul id="carousel" class="carousel-list">
			<?php foreach ($this->pics as $pic) :?>			
			<li class="slider-element">
				<div>
					<a class="no-styles" href="/home/album/<?php echo $pic['album_id']?>">
					<?php echo '<img src="data:image/jpeg;base64,' . base64_encode($pic['pic']) . '"/>'; ?>
					</a>
				</div>
			</li>
			<?php endforeach?>		
		</ul>
	</div>
	<div class="slider-prev" onclick="Actions.sliderPrev();"></div>
	<div class="slider-next" onclick="Actions.sliderNext();"></div>
</div>
<div id="show-albums"></div>
<script>
$(function() {
	var scrollDiv = 650;
	var i = 0;
		$.ajax({
				url : "/home/getAlbums/" + i++,
				method : "GET"
			}).success(function(data) {
				var div = $('<div>').append(data).hide().fadeIn(500);
				$('#show-albums').append(div);
			});
	$(window).scroll(function() {

		var scrollTop = parseInt($('body').scrollTop());
			
		console.log(scrollTop);

		if (scrollTop > scrollDiv) {
			scrollDiv = scrollTop + 650;

			$.ajax({
				url : "/home/getAlbums/" + i++,
				method : "GET"
			}).success(function(data) {
				var div = $('<div>').append(data).hide().fadeIn(1000);
				$('#show-albums').append(div);
			});
		}
	});
});
</script>

