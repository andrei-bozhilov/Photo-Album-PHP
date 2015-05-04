<?php if (count($this->albums) == 0) :?>
		<div class="jumbotron">
			<h3>
				Opps, no albums yet. Don't worry.  <a href="/user/user_albums"><span class="label label-success">Here</span></a> is a good place to start. :)
			</h3>
				</div>
<?php endif ?>

<?php foreach ($this->albums_with_pics as $index => $album) :
	?>
<div class="col-md-6">
	<ul class="album-list">
		<li class="album">
			<h3 class="album-title"><?php echo htmlspecialchars($album[0]['album_name'])?></h3>
		<div class="album-pic-holder">
			<ul>
			<?php foreach ($album as $pic_name => $pic) :?>
			<?php echo '<li><img src="data:image/jpeg;base64,' . base64_encode($pic['pic']) . '"/></li>'; ?>
			<?php endforeach ?>
			</ul>
			<div class="white-overlay"></div>
			<div class="hover-black"></div>
			<div class="icon-album-hover"></div>
		</div>
		<footer>
			<section class="alb-comments-f">
				Rating
			</section>
			<section class="alb-rating-f">
				3 / 10
			</section>
		</footer>
		</li>
	</ul>
</div>
<?php endforeach ?>