</div>
</div>
<a href="#" class="scrollup"></a>
<div id="popup-picture" class="popup">
	<div class="bodysize-close-popup" onclick="closePopup()"></div>
	<div id="popup-picture-container">
		<section id="popup-picture-image-container">
			<span class="helper"></span>
			<img id="pic-shown">
		</section>
		<section id="popup-picture-comment-container">
			<section id="pic-all-comments">
				<ul id="pic-comments-list"></ul>
			</section>
			<section id="add-comment">
				<span class="small-title">Add a comment</span>
				<form>
					<textarea id="comment-value"></textarea>
					<div id="add-picture-comment-button" class="add-buttons">
						Add comment
					</div>
				</form>
			</section>
		</section>
	</div>
</div>
<div id="popup-add-album" class="popup">
	<div class="bodysize-close-popup" onclick="closePopup()"></div>
	<div class="standard-popup">
		<h2 class="standard-title">Add album</h2>
		<form>
			<label for="album-name">NAME: </label>
			<input type="text" id="album-name">
			<br>
			<label for="album-category">CATEGORY: </label>
			<select id="album-category" class="categories-in-dropdown"></select>
			<br>
		</form>
		<div id="add-album-submit" class="add-buttons">
			Add album
		</div>
	</div>
</div>
<div id="popup-add-category" class="popup">
	<div class="bodysize-close-popup" onclick="closePopup()"></div>
	<div class="standard-popup">
		<h2 class="standard-title">Add category</h2>
		<form>
			<label for="album-name">NAME: </label>
			<input type="text" id="category-name">
			<br>
		</form>
		<div id="add-category-submit" class="add-buttons">
			Add category
		</div>
	</div>
</div>
<div id="popup-add-picture" class="popup">
	<div class="bodysize-close-popup" onclick="closePopup()"></div>
	<div class="standard-popup">
		<h2 class="standard-title">Add picture</h2>
		<form>
			<label for="picture-name">NAME: </label>
			<input type="text" id="picture-name">
			<br>
			<label for="image-file">CHOOSE A FILE: </label>
			<input type="file" id="image-file" data-max-size="2048" >
			<br>
			<div id="max-file-size">
				<small>Max file size: <strong>2MB</strong></small>
			</div>
			<div id="allowed-file-types">
				<small>Allowed file types: <strong>jpg, jpeg, bmp, gif, png</strong></small>
			</div>
			<div id="add-picture-submit" class="add-buttons">
				Add picture
			</div>
		</form>
	</div>
</div>
<div id="popup-rate-album" class="popup">
	<div class="bodysize-close-popup" onclick="closePopup()"></div>
	<div class="standard-popup">
		<h2 class="standard-title">Rate Album</h2>
		<form>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<label for="rate-album-value" id="rate-album-value">Rate: 1</label>
			<input type="range" id="rate-album-range" value="1" min="1" max="10" step="1" oninput="showVal(this.value, this.id)">
			<br>
			<div id="rate-album-submit" class="add-buttons">
				Rate Album
			</div>
		</form>
	</div>
</div>
<div id="popup-rate-picture" class="popup">
	<div class="bodysize-close-popup" onclick="closePopup()"></div>
	<div class="standard-popup">
		<h2 class="standard-title">Rate Picture</h2>
		<form>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<div class="rate-scale"></div>
			<label for="rate-picture-value" id="rate-picture-value">Rate: 1</label>
			<input type="range" id="rate-picture-range" value="1" min="1" max="10" step="1" oninput="showVal(this.value, this.id)">
			<div id="rate-picture-submit" class="add-buttons">
				Rate Picture
			</div>
		</form>
	</div>
</div>
<footer>
	All rights reserved! Team Dothraki on project Dothstagram!
</footer>
</div>



</body>
</html>