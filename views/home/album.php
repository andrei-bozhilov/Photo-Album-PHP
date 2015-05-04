<?php if ($this->album == null) :
?>
<div class="jumbotron">
	<h3> Opps, no such album. Don't worry. <a href="/"><span class="label label-success">Here</span></a> is a good place to start. :) </h3>
</div>
<?php else : ?>
<div class="col-md-12">
	<section id="breadcrumbs">
		<div>
			<div class="hidden" id="albumId" data-album="<?php echo $this->album_id ?>"></div>
			<div id="back-button" onclick="window.location.href = '/home'" class="back-button-change"></div>
			<h1 class="pull-left"><?php echo htmlspecialchars($this->album[0]['album_name'])?></h1>

			<div id="rate-album" class="add-buttons" onclick="loadRateAlbum()" style="display: block;">
				Rate album
			</div>
			<div class="rating">
				<?php if($this->rating == null) :?>
				<div>
					<span class="glyphicon glyphicon-star"></span>No rating, yet
				</div>
				<?php else :?>
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
</div>

<?php foreach ($this->album as $album) :?>

<div class="col-md-4 fadein">
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
					Date: 9.12.2014
				</section>
				<section class="pic-download">
					<a href="http://files.parsetfss.com/bd42e52e-3ab7-41d8-99a9-eeb0d58a13cd/tfss-2ea78db2-0609-40b9-ac9a-4691d30fd4d3-Assembly.png">Download</a>
				</section>
				<section id="LZY2u9XSHy" class="pic-rating">
					Rate me
				</section>
			</footer>
		</li>
	</ul>
</div>
<?php endforeach ?>

<?php endif ?>