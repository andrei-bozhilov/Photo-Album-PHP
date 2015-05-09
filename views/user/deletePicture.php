<div class="col-md-12">
	<section id="breadcrumbs">
		<div>
			<div id="back-button" onclick="history.go(-1);" class="back-button-change"></div>
			<h1 class="pull-left">Delete Picture. Are you sure?</h1>
		</div>
	</section>
</div>
<?php if ($this->picture == null) :?>
<div class="col-md-12">
		<div class="jumbotron">
			<h3>Oops there is no such picture.</h3>
		</div>
</div>
<?php else : ?>
<div class="col-md-12">
	<form class="form-horizontal" method="POST" enctype="multipart/form-data">
		<div class="col-md-6">
			 <div class="form-group">
				<div class="col-sm-9">
					<?php if ($this->picture['pic'] == null) :?>					
                    <img id="image" src="/content/images/noimage.jpg" width="200" height="200">
                    <?php else: ?>
                    <img src="data:image/jpeg;base64, <?php echo base64_encode($this->picture['pic']) ?>" width="200" height="200"/>
                    <?php endif; ?>
                </div>
             </div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" placeholder="<?php echo htmlspecialchars($this->picture['name']);?>" readonly="readonly">
				</div>
			</div>
			<div class="form-group">
				<label for="album" class="col-sm-2 control-label">Album</label>
				<div class="col-sm-10">
					<select name="album" id="album" class="form-control">
					   <option><?php echo htmlspecialchars($this->picture['album_name']) ?></option>
					</select>
				</div>
			</div>
			<!--<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <div class="checkbox">
			        <label>
			          <input type="checkbox" name="is_public" checked="checked"> Is public?
			        </label>
			      </div>
			    </div>
		 </div> -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">
						Delete
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
<?php endif; ?>