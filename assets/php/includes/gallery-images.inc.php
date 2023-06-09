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
    try {

        $file = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/gallery/$id.webp";
        $small = $_SERVER["DOCUMENT_ROOT"] . "/assets/images/gallery/sm/$id.webp";
        if (file_exists($file)) {
            unlink($file);
        }
        if (file_exists($small)) {
            unlink($small);
        }
    } catch (Exception $error) {
        http_response_code(500);
        die(json_encode(["error" => $error]));
    }
}

function UploadImage($id): bool
{
    $id = basename($id, '.' . pathinfo($id, PATHINFO_EXTENSION));
    $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/gallery/$id.webp";
    $sml = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/gallery/sm/$id.webp";
    $image = "image";
    $tempFile = $_FILES[$image]['tmp_name'];

    $ffmpegCommand = "ffmpeg -y -i \"$tempFile\" \"$path\"";
    exec($ffmpegCommand, $output, $returnCode);
    $ffmpegCommand = "ffmpeg -y -i \"$tempFile\" -vf scale=20:-1 \"$sml\"";
    exec($ffmpegCommand, $output, $returnCode);

    if ($returnCode === 0) {
        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
        return true;
    } else {
        http_response_code(500);
        return false;
    }
}
