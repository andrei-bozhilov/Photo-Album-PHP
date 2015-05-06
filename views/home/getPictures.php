<?php foreach ($this->album as $album) :?>

<div class="col-md-4">
	<ul id="album-images-container">
		<li>
			<header>
				<h3><?php echo htmlspecialchars($album['pic_name']); ?></h3>
			</header>
			<section>
				<?php if ($album['pic'] == null) :?>
				<img src="/content/images/noimage.jpg"/>
				<div class="pic-hover" data-id= <?php echo  $album['pic_id'] ?> data-src="/content/images/noimage.jpg"></div>
				<?php else : ?>
				<?php echo '<img src="data:image/jpeg;base64,' . base64_encode($album['pic']) . '"/>'; ?> <div class="pic-hover" data-id= <?php echo  $album['pic_id'] ?> data-src=<?php echo '"data:image/jpeg;base64,' . base64_encode($album['pic']) . '"'; ?> ></div>
				<?php endif ?>
			</section>
			<footer>
				<section class="pic-date">
					<?php $date = new DateTime($album['pic_date']);
						echo $date->format('d-M-Y');?>					
				</section>
				<section class="pic-download">
					<a>Download</a>
				</section>
			</footer>
		</li>
	</ul>
</div>
<?php endforeach ?>