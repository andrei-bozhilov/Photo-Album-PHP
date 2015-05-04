<?php foreach ($this->albums as $index => $album) :
	?>
<div class="col-md-4">
	<ul class="album-list">
		<li class="album">
			<a class="no-styles" <?php echo "href='/home/album/" . $album[0]['album_id'] . "'" ;?> >
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
				<?php if ($album[0]['album_rating'] == null) :?>
					rate me
				<?php else :?>
					<?php echo round($album[0]['album_rating'], 0) . "/10"; ?>
				<?php endif ?>
			</section>
		</footer>
		</a>
		</li>
	</ul>
</div>
<?php endforeach ?>