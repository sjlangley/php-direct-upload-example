<?php

use google\appengine\api\cloud_storage\CloudStorageTools;

$bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
$root_path = 'gs://' . $bucket . '/' . $_SERVER["REQUEST_ID_HASH"] . '/';

$public_urls = [];
foreach($_FILES['userfile']['name'] as $idx => $name) {
  if ($_FILES['userfile']['type'][$idx] === 'image/jpeg') {
    $im = imagecreatefromjpeg($_FILES['userfile']['tmp_name'][$idx]);
    imagefilter($im, IMG_FILTER_GRAYSCALE);
    $grayscale = $root_path .  'gray/' . $name;
    imagejpeg($im, $grayscale);

    $original = $root_path . 'original/' . $name;
    move_uploaded_file($_FILES['userfile']['tmp_name'][$idx], $original);

    $public_urls[] = [
        'name' => $name,
        'o_file' => $original,
        'g_file' => $grayscale,
        'original' => CloudStorageTools::getImageServingUrl($original),
        'original_thumb' => CloudStorageTools::getImageServingUrl($original, ['size' => 75]),
        'grayscale' => CloudStorageTools::getImageServingUrl($grayscale),
        'grayscale_thumb' => CloudStorageTools::getImageServingUrl($grayscale, ['size' => 75]),
    ];
  } else {
    echo 'File ' . $name . ' is not image/jpeg, ignoring.';
  }
}

?>
<html>
<body>
<?php
foreach($public_urls as $urls) {
  echo '<a href="' . $urls['original'] .'"><IMG src="' . $urls['original_thumb'] .'"></a> ';
  echo '<a href="' . $urls['grayscale'] .'"><IMG src="' . $urls['grayscale_thumb'] .'"></a>';
  echo '<p>';
}
?>
<p>
<a href="/">Upload More</a>
</body>
</html>
ß