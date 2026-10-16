<?php
// Validates and saves one uploaded product image.
// Returns ['success' => true, 'filename' => '...'] or ['success' => false, 'error' => '...'].
function upload_product_image($file) {

    $maxSize = 2 * 1024 * 1024; 

    // Allowed REAL types, each mapped to the extension we will save with.
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp'
    ];

    // UPLOAD_ERR_OK = PHP received the file without trouble.
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Image upload failed. Please try again.'];
    }

    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'Image must be 2MB or smaller.'];
    }

    // Read the file's REAL type from its contents, not the browser's claim.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!isset($allowed[$mime])) {
        return ['success' => false, 'error' => 'Only JPG, PNG, GIF or WEBP images are allowed.'];
    }

   
    $baseName = pathinfo($file['name'], PATHINFO_FILENAME);
    $baseName = substr(preg_replace('/[^A-Za-z0-9_-]/', '', $baseName), 0, 50);

    // uniqid() makes the name unique so two uploads never overwrite each other.
    
    $filename = uniqid() . '_' . $baseName . '.' . $allowed[$mime];

    // __DIR__ = this file's folder (core/), so this path works from anywhere.
    $folder = __DIR__ . '/../images/products/';
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    // move_uploaded_file() only works on genuine uploads, and moves the
    // file from PHP's temporary spot into our folder.
    if (!move_uploaded_file($file['tmp_name'], $folder . $filename)) {
        return ['success' => false, 'error' => 'Could not save the image on the server.'];
    }

    return ['success' => true, 'filename' => $filename];
}
?>