<ul class="nav nav-pills user-nav nav-stacked">
	<li role="presentation" class="<?php if($this->sub_location == "index") echo "active"?>">
		<a href="/albums/index">Home</a>
	</li>
	<li role="presentation" class="<?php if($this->sub_location == "user_albums") echo "active"?>">
		<a href="/albums/user_albums">My albums</a>

	</li>
	<li role="presentation" class="<?php if($this->sub_location == "user_pictures") echo "active"?>">
		<a href="/albums/user_pictures">My pictures</a>
	</li>
</ul>
