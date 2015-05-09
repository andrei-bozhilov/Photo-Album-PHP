<div class="col-md-12">
	<section id="breadcrumbs">
		<div>
			<div id="back-button" onclick="history.go(-1);" class="back-button-change"></div>
			<h1 class="pull-left">Add Album</h1>
		</div>
	</section>
</div>
<div class="col-md-6 col-md-push-3">
	<form class="form-horizontal" method="POST">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="name" name="name" placeholder="Album's name" required="required">
			</div>
		</div>
		<div class="form-group">
			<label for="category" class="col-sm-2 control-label">Category</label>
			<div class="col-sm-10">
				<select name="category" id="category" class="form-control">
					<option value=0>Choose category</option>
					<?php  foreach ($this->categories as $category) : ?>
						<option value="<?php echo htmlspecialchars($category['id']) ?>"><?php echo htmlspecialchars($category['name']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">
					Add
				</button>
			</div>
		</div>
	</form>
	<div class="alert alert-warning" role="alert">Be sure to add some pics to your album, after created it, so other people can see it.</div>
</div>
