<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/gallery/";

if (isset($_GET['c'])) {
    if ($_GET['c'] == 'upload') {
        $id = $_POST['id'];
        UploadImage($id);
    } else if ($_GET['c'] == 'delete') {
        $id = $_POST['id'];
        DeleteImage($id);
    }
}

function GetGalleryImages(): array
{
    global $dir;
    $items = scandir($dir);
    if ($items) {
        $files = array();
        foreach ($items as $image) {
            if (!is_dir($dir . $image)) {
                array_push($files,  $image);
            }
        }
        return $files;
    }
    return array();
}

function DeleteImage($id)
{
    $file = "/assets/images/gallery/$id.webp";
    $small = "/assets/images/gallery/sm/$id.webp";
    if (file_exists($file)) {
        unlink($file);
    }
    if (file_exists($small)) {
        unlink($small);
    }
}

function UploadImage($id): bool
{
    $id = basename($id, '.' . pathinfo($id, PATHINFO_EXTENSION));
    $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/gallery/$id.webp";
    $sml = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/gallery/sm/$id.webp";
    $image = "image";
    $tempFile = $_FILES[$image]['tmp_name'];

    // Convert the uploaded image to WebP format using FFmpeg
    $ffmpegCommand = "ffmpeg -y -i '$tempFile' '$path'";
    exec($ffmpegCommand, $output, $returnCode);
    echo (json_encode($output));
    $ffmpegCommand = "ffmpeg -y -i '$tempFile' -vf scale=20:-1 '$sml'";
    exec($ffmpegCommand, $output, $returnCode);
    echo (json_encode($output));

    // Check if FFmpeg conversion was successful
    if ($returnCode === 0) {
        return true;

        // Delete the temporary file
        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
    } else {
        http_response_code(500);
        return false;
    }
}
