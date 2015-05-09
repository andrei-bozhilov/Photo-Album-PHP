<div class="col-md-12">
	<h1>My albums</h1>
</div>
<div class="col-md-3">
	<?php include_once("/views/user/user-navigation.php")
	?>
</div>

<div class="col-md-9">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Category</th>
					<th>Pics</th>
					<th>Rating</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->albums as $album) :
				?>
				<tr>
					<td><?php echo $album['id']
					?></td>
					<td><?php echo htmlentities($album['name'])
					?></td>
					<td><?php echo htmlentities($album['category_name'])
					?></td>
					<td><?php echo $album['pic_count']; ?></td>
					<td style="width: 38%">
						<div>
							<div class="rating" style="margin:0 0; float: left">
								<?php if($album['rating'] == null) :
								?>
								<div>
									<span class="glyphicon glyphicon-star"></span>No rating, yet
								</div>
								<?php else : ?>
								Rating:
								<?php for($i = 0; $i < round($album['rating'],0); $i++ ) :
								?>
								<span class="glyphicon glyphicon-star" style="color:#168"></span>
								<?php endfor; ?>
								<?php for($i = 0; $i < 10 - round($album['rating'],0); $i++ ) :
								?>
								<span class="glyphicon glyphicon-star" style="color:red"></span>
								<?php endfor; ?>
								<?php endif ?>
							</div>
						</div>
					</td>
					<td>
					<a href="/home/album/<?php echo $album['id'] ?>" class="btn btn-default">
						See
					</a>
					<a href="/user/editAlbum/<?php echo $album['id'] ?>" class="btn btn-warning">
						Edit
					</a>
					<a href="/user/deleteAlbum/<?php echo $album['id'] ?>" class="btn btn-danger">
						Delete
					</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<a href="/user/addAlbum" class="btn btn-primary">
		Add Album
	</a>
</div>
<?php ?>