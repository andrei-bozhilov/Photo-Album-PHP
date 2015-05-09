<div class="col-md-12">
	<section id="breadcrumbs">
		<div>
			<div id="back-button" onclick="history.go(-1);" class="back-button-change"></div>
			<h1 class="pull-left">Delete Album. Are you sure?</h1>
		</div>
	</section>
</div>
<?php if ($this->album == null) :?>
<div class="col-md-12">
		<div class="jumbotron">
			<h3>Oops there is no such album.</h3>
		</div>
</div>
<?php else : ?>
<div class="col-md-6 col-md-push-3">
	<?php if ($this->picture_count != 0) :?>
	<div class="jumbotron">
		<h3>There are <?php echo $this -> picture_count; ?> pictures in this album. First delete all pictures</h3>
	<form class="form-horizontal" method="POST" action="/user/deletePicturesByAlbum/<?php echo htmlspecialchars($this -> album['id']); ?>">
		<h3>Delete all pictures to this album</h3>
		<button type="submit" class="btn btn-danger">
			Delete
		</button>
	</form>
	</div>
	
	
	<?php endif; ?>
	<form class="form-horizontal" method="POST">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="name" name="name" placeholder="<?php echo htmlspecialchars($this -> album['name']); ?>" readonly="readonly">
			</div>
		</div>
		<div class="form-group">
			<label for="category" class="col-sm-2 control-label">Category</label>
			<div class="col-sm-10">
				<select name="category" id="category" class="form-control">
					<option><?php echo htmlspecialchars($this -> album['category']); ?></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-danger">
					Delete
				</button>
			</div>
		</div>
	</form>
	<div class="alert alert-warning" role="alert">Be sure to add some pics to your album, after created it, so other people can see it.</div>
</div>

<?php endif; ?>
