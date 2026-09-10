<?php
$dir = __DIR__ . '/upload/subservice/';
$files = glob($dir . '*.webp');

foreach ($files as $file) {
    if (filesize($file) > 100000) { // greater than 100KB
        $image = imagecreatefromwebp($file);
        if ($image) {
            $width = imagesx($image);
            $height = imagesy($image);

            // max width 400
            if ($width > 400) {
                $newWidth = 400;
                $newHeight = floor($height * ($newWidth / $width));
                $newImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagewebp($newImage, $file, 80);
                imagedestroy($newImage);
            } else {
                imagewebp($image, $file, 80);
            }
            imagedestroy($image);
            echo "Optimized: " . basename($file) . "\n";
        }
    }
}
echo "Done.";
