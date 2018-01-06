<?php error_reporting(1); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Instagram Downloader</title>
</head>
<body>
	<form method="post">
		<input type="text" name="username" placeholder="Page username">
		<input type="submit" name="submit" value="Submit">
		<?php

		require __DIR__ . '/vendor/autoload.php';
		require __DIR__ . '/configs.php';

		if(isset($_POST['submit'])){
			$ig = new \InstagramAPI\Instagram(false, false);
			$ig->login($configs['username'], $configs['password']);

			$userId = $ig->people->getUserIdForName($_POST['username']);
			$maxId = null;
			$counter = 1;
			do {
				$feeds = $ig->timeline->getUserFeed($userId, $maxId);
				foreach ($feeds->items as $feed) {
					if(isset($feed->image_versions2) && isset($feed->image_versions2->candidates)){
						if(isset($feed->image_versions2->candidates[0]->url)){
							file_put_contents(__DIR__ . '/posts/' . $counter . '.jpg', fopen($feed->image_versions2->candidates[0]->url, 'r'));
							$counter++;
						}
					}
				}				
				$maxId = $feeds->getNextMaxId();
			} while ($maxId !== null);

			echo "done";
		}

		?>
	</form>
</body>
</html>