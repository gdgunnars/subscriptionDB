<?php

// Uncomment if you want to allow posts from other domains
// header('Access-Control-Allow-Origin: *');

require_once('slim.php');

// Get posted data, if something is wrong, exit
try {
    $images = Slim::getImages();
}
catch (Exception $e) {

    // Possible solutions
    // ----------
    // Make sure you're running PHP version 5.6 or higher

    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'Unknown'
    ));

    return;
}

// No image found under the supplied input name
if ($images === false) {

    // Possible solutions
    // ----------
    // Make sure the name of the file input is "slim[]" or you have passed your custom
    // name to the getImages method above like this -> Slim::getImages("myFieldName")

    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No data posted'
    ));

    return;
}

// Should always be one image (when posting async), so we'll use the first on in the array (if available)
$image = array_shift($images);

// Something was posted but no images were found
if (!isset($image)) {

    // Possible solutions
    // ----------
    // Make sure you're running PHP version 5.6 or higher

    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No images found'
    ));

    return;
}

// If image found but no output image data present
if (!isset($image['output']['data'])) {

    // Possible solutions
    // ----------
    // If you've set the data-post attribute make sure it contains the "output" value -> data-post="actions,output"
    // If you want to use the input data and have set the data-post attribute to include "input", replace the 'output' String above with 'input'

    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No image data'
    ));

    return;
}

// Save the file
// We'll use the original input name
$name = $image['input']['name'];

// We'll use the output crop data
// note: If you want to save the input data, replace the 'output' string below with 'input'
$data = $image['output']['data'];

// If you want to prevent Slim from adding a unique id to the file name add false as the fourth parameter.
// $file = Slim::saveFile($data, $name, 'tmp/', false);
$file = Slim::saveFile($data, $name);

// Return results as JSON
Slim::outputJSON(array(
    'status' => SlimStatus::SUCCESS,
    'file' => $file['name'],
    'path' => $file['path']
));