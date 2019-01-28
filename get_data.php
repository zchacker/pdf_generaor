<?php

$base_dir = '/var/www/html/aqar/public_html/pdf';

// pdf part
require($base_dir.'/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$count = 0;
$pages = 0;

// header('Content-type: image/jpeg');

// user data


$rotation = 0;
$font = $base_dir."/arial.ttf";

$font_size =  $_POST['textSize'];

$font_size = intval( ($font_size - 10) * (450 / 750));

$x1 = $_POST['x1'];
$y1 = $_POST['y1'];

$x2 = $_POST['x2'];
$y2 = $_POST['y2'];

$username = "username";
$password = "password";

$hex = $_POST['favcolor'];
list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

$input = "";

  if(strlen($_FILES["fileToUpload"]["tmp_name"]) == 0)
    $input = $_POST['card_name'];
  else
    $input = $_FILES["fileToUpload"]["tmp_name"];// "imgs/card.jpg";


$output1 = $base_dir."/imgs/card1.jpg";
$output2 = $base_dir."/imgs/card2.jpg";

$w = 450;
$h = 265;

// csv file
// Set path to CSV file
$csvFile = $_FILES["csv"]["tmp_name"];;

$csv = readCSV($csvFile);
$arrsize  = sizeof($csv);

// echo '<pre>';
// print_r($csv);
// echo '</pre>';

// here image process

//$arrsize = intval($arrsize/2);

$image_count = 0;



for($i = 1; $i < $arrsize ; $i+=2){

  //echo "<br/>$i : len = ".sizeof($csv[$i]);
  $image_count++;

  if(sizeof($csv[$i]) == 1)
    continue;

  // image 1
  $image = resize_image( $input , $w , $h );// imagecreatefromjpeg($input);// imagecreate($w , $h); // resize_image( $input , $w , $h );//
  // colors
  $color =  imagecolorallocate($image , $r, $g, $b);

  $username = $csv[$i][1];
  $password = $csv[$i][2];

  $text1 = imagettftext($image , $font_size , $rotation , $x1 , $y1 , $color , $font , $username);
  $text2 = imagettftext($image , $font_size , $rotation , $x2 , $y2 , $color , $font , $password);

  $output1 = $base_dir."/tmp/card_1_$i.jpg";
  imagejpeg($image , $output1);

  //die('image');
  $pdf->Image( $output1 , 5 , $count+2 , 95 , 60 );

  //die('image');

  ###################################################
  # image image image image image image image image #
  ###################################################


  // image 2
  $image = resize_image( $input , $w , $h );// imagecreatefromjpeg($input); // imagecreate($w , $h); // resize_image( $input , $w , $h );//
  // colors
  $color =  imagecolorallocate($image , $r, $g, $b);

  $username = $csv[$i+1][1];
  $password = $csv[$i+1][2];

  $text1 = imagettftext($image , $font_size , $rotation , $x1 , $y1 , $color , $font , $username);
  $text2 = imagettftext($image , $font_size , $rotation , $x2 , $y2 , $color , $font , $password);

  $output2 = $base_dir."/tmp/card_2_$i.jpg";
  imagejpeg($image , $output2);

  $pdf->Image( $output2 , 110 , $count+2 , 95 , 60 );

  $count += 70;
  if($image_count >= 4){
    $image_count = 0;
    $count = 0;
    $pdf->AddPage();
  }

}

$pdf->Output();

// delete all temp images

$files = glob($base_dir.'/tmp/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

//echo $output;
//var_dump($_POST);
//var_dump($_FILES);

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;

    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }

    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    // $dst = imagecreatetruecolor($w, $h);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024 , ';' , '"'  );
    }
    fclose($file_handle);
    return $line_of_text;
}

 ?>
