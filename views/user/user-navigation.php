<ul class="nav nav-pills user-nav nav-stacked">
	<li role="presentation" class="<?php if($this->sub_location == "index") echo "active"?>">
		<a href="/user/index">Home</a>
	</li>
	<li role="presentation" class="<?php if($this->sub_location == "user_albums") echo "active"?>">
		<a href="/user/albums">My albums</a>

	</li>
	<li role="presentation" class="<?php if($this->sub_location == "user_pictures") echo "active"?>">
		<a href="/user/pictures">My pictures</a>
	</li>
</ul>
