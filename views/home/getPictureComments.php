<?php foreach ($this->comments as $comment) :?>

<li>
	<header>
		<span><?php echo htmlspecialchars($comment['username']);?></span>
		<span>
			<?php $date = new DateTime($comment['date']);
				echo $date->format('d-M-Y');
			 ?>
			</span>
	</header>
	<article>
		<?php echo htmlspecialchars($comment['comment']);?>
	</article>
</li>

<?php endforeach; ?>
