<?php if ($this->album == null) :
?>
<div class="jumbotron">
	<h3> Opps, no such album. Don't worry. <a href="/"><span class="label label-success">Here</span></a> is a good place to start. :) </h3>
</div>
<?php else : ?>
<div class="col-md-12">
	<section id="breadcrumbs">
		<div>
			<div class="hidden" id="albumId" data-album="<?php echo $this->album['id'] ?>"></div>
			<div id="back-button" onclick="history.go(-1);" class="back-button-change"></div>
			<h1 class="pull-left"><?php echo htmlspecialchars($this->album['name'])?></h1>

			<div id="rate-album" class="add-buttons" onclick="loadRateAlbum()" style="display: block;">
				Rate album
			</div>
				<div class="rating">
					<?php if($this->rating == null) :?>
					<div>
						<span class="glyphicon glyphicon-star"></span>No rating, yet
					</div>
					<?php else : ?>
					Rating:
					<?php for($i = 0; $i < $this->rating; $i++ ) :?>
					<span class="glyphicon glyphicon-star" style="color:#168"></span>
					<?php endfor; ?>
					<?php for($i = 0; $i < 10 - $this->rating; $i++ ) :?>
					<span class="glyphicon glyphicon-star" style="color:red"></span>
					<?php endfor; ?>
					<?php endif ?>
				</div>
		</div>
	</section>
	<section id="popup-album-comment-container">
		<div class="col-md-6">
			<section id="album-all-comments">
				<ul>
					<?php foreach ($this->comments as $comment) :?>
					<li>
						<header>
							<span id="commentOf"> <?php echo htmlentities($comment['username']); ?></span>
							<br>
							<span id="commentDate"> <?php
							$date = new DateTime($comment['date']);
							echo $date -> format('d-M-Y');
								?> </span>
						</header>
						<article id="album-comment-article">
							<?php echo htmlentities($comment['comment']); ?>
						</article>
					</li>
					<?php endforeach; ?>
				</ul>
			</section>
		</div>
		<div class="col-md-6">
			<section id="add-album-comment">
				<span class="small-album-title">Add a comment</span>
				<form>
					<textarea id="textareaAlbumComment" placeholder="Enter a comment"></textarea>
					<div id="add-comment-button" class="add-buttons" onclick="addCommentToAlbum()">
						Add comment
					</div>
				</form>
			</section>
		</div>
	</section>
</div>

<div id="show-pics"></div>

<script>
	$(function() {
		var scrollDiv = 1000;
		var albumId = $('#albumId').attr('data-album');
		var i = 0;
		$.ajax({
			url : "/home/getPictures/" + albumId + "/" + i++,
			method : "GET"
		}).success(function(data) {
			var div = $('<div>').append(data).hide().fadeIn(500);
			$('#show-pics').append(div);
		});
		$(window).scroll(function() {

			var scrollTop = parseInt($('body').scrollTop());

			console.log(scrollTop);

			if (scrollTop > scrollDiv) {
				scrollDiv = scrollTop + 1000;

				$.ajax({
					url : "/home/getPictures/" + albumId + "/" + i++,
					method : "GET"
				}).success(function(data) {
					var div = $('<div>').append(data).hide().fadeIn(1000);
					$('#show-pics').append(div);
				});
			}
		});
	}); 
</script>
<?php endif ?>