<div class="col-md-12">
	<section id="breadcrumbs">
		<div>
			<div id="back-button" onclick="history.go(-1);" class="back-button-change"></div>
			<h1 class="pull-left">Add Picture</h1>
		</div>
	</section>
</div>
<div class="col-md-12">
	<form class="form-horizontal" method="POST" enctype="multipart/form-data">
		<div class="col-md-6">
			 <div class="form-group">
				<div class="col-sm-9">
                    <img id="image" src="/content/images/noimage.jpg" width="200" height="200">
                </div>
				<div class="col-sm-3">
					<div class="btn btn-primary form-control fileUpload">
						<span>Upload</span>
						<input id="uploadBtn" type="file" name="picture" class="upload" onchange="uploadImage($(this))"/>
					</div>
				</div>
             </div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" placeholder="Picture's name" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="album" class="col-sm-2 control-label">Album</label>
				<div class="col-sm-10">
					<select name="album" id="album" class="form-control">
						<option value=0>Choose Album</option>
						<?php  foreach ($this->albums as $album) : ?>
							<option value="<?php echo htmlspecialchars($album['id']) ?>"><?php echo htmlspecialchars($album['name']) ?></option>
						<?php endforeach; ?>
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
						Add
					</button>
				</div>
			</div>
		</div>
	</form>
</div>