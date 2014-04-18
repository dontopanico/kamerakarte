<?php
include('securimage.php');

$img = new Securimage();

// Change some settings

//$img->image_width = 275;
//$img->image_height = 90;
//$img->perturbation = 0.9; // 1.0 = high distortion, higher numbers = more distortion
//$img->image_bg_color = new Securimage_Color("#0099CC");
//$img->text_color = new Securimage_Color("#EAEAEA");
//$img->text_transparency_percentage = 65; // 100 = completely transparent
//$img->num_lines = 8;
//$img->line_color = new Securimage_Color("#0000CC");
//$img->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));
//$img->image_type = SI_IMAGE_PNG;


$img->show(); // alternate use:  $img->show('/path/to/background_image.jpg');
