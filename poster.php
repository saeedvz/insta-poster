<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/configs.php';

$photos = scandir(__DIR__.'/posts');
unset($photos[0]);
unset($photos[1]);

if (count($photos)) {
    $selected = __DIR__.'/posts/'.$photos[array_rand($photos, 1)];

    $ig = new \InstagramAPI\Instagram(false, false);
    $ig->login($configs['username'], $configs['password']);

    $ig->timeline->uploadPhoto($selected, ['caption' => '']);

    unlink($selected);
}
