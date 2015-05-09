<div class="col-md-12">
	<section id="breadcrumbs">
		<div>
			<div id="back-button" onclick="history.go(-1);" class="back-button-change"></div>
			<h1 class="pull-left">Edit Album</h1>
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
	<form class="form-horizontal" method="POST">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($this -> album['name']); ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="category" class="col-sm-2 control-label">Category</label>
			<div class="col-sm-10">
				<select name="category" id="category" class="form-control">
					<?php  foreach ($this->categories as $category) : ?>
						<option <?php if ($this ->album['category_id']== $category['id'] ) echo 'selected'; ?>  value="<?php echo htmlspecialchars($category['id']) ?>"><?php echo htmlspecialchars($category['name']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-warning">
					Edit
				</button>
			</div>
		</div>
	</form>
	<div class="alert alert-warning" role="alert">Be sure to add some pics to your album, after created it, so other people can see it.</div>
</div>
<?php endif; ?>