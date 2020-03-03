<?php if (!empty($errors)) : ?>
	<?php foreach ($errors as $error) : ?>
		<div>&#8211;<?= esc($error) ?></div>
	<?php endforeach ?>
<?php endif ?>