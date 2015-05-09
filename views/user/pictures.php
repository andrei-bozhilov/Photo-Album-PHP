<div class="col-md-12">
	<h1>My Pictures</h1>
</div>
<div class="col-md-3">
	<?php include_once("/views/user/user-navigation.php")
	?>
</div>
<div class="col-md-9">
		<form class="form-horizontal" method="GET">
		<div class="form-group">
			<label for="album" class="col-sm-2 control-label">Album</label>
			<div class="col-sm-10">
				<select name="album" id="category" class="form-control" onchange="this.form.submit()">
					<option value=0>Choose album</option>
					<?php  foreach ($this->albums as $album) : ?>
						<option <?php if ($this ->album != null && $this->album['id'] == $album['id']) echo 'selected'; ?>  value="<?php echo htmlspecialchars($album['id']) ?>"><?php echo htmlspecialchars($album['name']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</form>
</div>
<?php if ($this ->album == null) :?>
<div class="col-md-9">
	<div class="alert alert-info" role="alert">Select Album</div>
	<a href="/user/addPicture" class="btn btn-primary">
		Add Picture
	</a>
</div>

<?php else: ?>

<div class="col-md-9">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>Id</th>
					<th>Pic</th>
					<th>Name</th>
					<th>Album Name</th>
					<th>Album Category</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->pictures as $picture) :
				?>
				<tr>
					<td><?php echo $picture['id']; ?></td>
					<td>
						<?php if ($picture['pic'] == null) :?>
						<img src="/content/images/noimage.jpg" height="50" width="50"/>
						<?php else : ?>
						<img src="data:image/jpeg;base64, <?php echo base64_encode($picture['pic']); ?>" height="50" width="50"/>
						<?php endif ?>
					</td>
					<td>
						<?php echo htmlentities($picture['name']); ?>
					</td>	
					<td>
						<?php echo htmlentities($picture['album_name']); ?>
					</td>	
					<td>
						<?php echo htmlentities($picture['album_category']); ?>
					</td>						
					<td>
					<a href="/user/editPicture/<?php echo $picture['id'] ?>" class="btn btn-warning">
						Edit
					</a>
					<a href="/user/deletePicture/<?php echo $picture['id'] ?>" class="btn btn-danger">
						Delete
					</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<a href="/user/addPicture" class="btn btn-primary">
		Add Picture
	</a>
</div>
<?php endif; ?>

