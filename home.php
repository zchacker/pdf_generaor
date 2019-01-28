<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="">
  <link rel="stylesheet" href="bootstrap.min.css">
  <title>Card Generator Print</title>


<style>
  body{
    background-color: #F8DA96;
  }

  #template {
    background-repeat: round;
    background-size: cover;
    /* position:relative; */
    border-width: 1px;
    border-color: black;
    border-style: solid;
    background-color: #FFFFFF;
  }

  #dxy:hover , #dxy1:hover {
  cursor: move;
  }

  /* #dxy , #dxy1{
    position:absolute;
  } */

</style>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script><script type="text/javascript">

var card_w = 450; //250;
var card_h = 265;//113;

var scail_w = 750;
var scail_h = 339;
$( document ).ready(function() {

  addListeners();
  var div = $(document.getElementById('dxy'));
  var temp = $(document.getElementById("template"));

  div.css("position", 'absolute');
  //div.css("top", temp.position().top + 'px');
  //div.css("left", temp.position().left + 'px');

  $("#x1").val((div.position().top - temp.offset().top ) * ( card_h/scail_h ) ); //  card_w/scail_w
  $("#y1").val((div.position().left - temp.offset().left ) * ( card_w/scail_w ) ); // card_h/scail_h

  var div1 = $(document.getElementById('dxy1'));


  div1.css("position", 'absolute');
  div1.css("top", (div.position().top + 30) + 'px');
  //div1.css("left", temp.position().left + 'px');

  $("#x2").val( (div1.position().top - temp.offset().top) * ( card_h/scail_h ) ); // card_w/scail_w
  $("#y2").val( (div1.position().left - temp.offset().left) * ( card_w/scail_w) ); // card_h/scail_h

});

function addListeners(){
  document.getElementById('dxy').addEventListener('mousedown', mouseDown, false);
  document.getElementById('dxy1').addEventListener('mousedown', mouseDown1, false);
  window.addEventListener('mouseup', mouseUp, false);
  window.addEventListener('mouseup', mouseUp1, false);

}

function mouseUp()
{
      window.removeEventListener('mousemove', divMove, true);
}
function mouseUp1()
{
      window.removeEventListener('mousemove', divMove1, true);
}

function mouseDown(e){
  window.addEventListener('mousemove', divMove, true);
}
function mouseDown1(e){
  window.addEventListener('mousemove', divMove1, true);
}

function divMove(e){
  var div = document.getElementById('dxy');
  var temp = $("#template");
  div.style.position = 'absolute';
  div.style.top = e.clientY + 'px';
  div.style.left = e.clientX + 'px';

  $("#x1").val((e.clientX - temp.offset().left) * ( card_w/scail_w ) ); // card_w/scail_w
  $("#y1").val((e.clientY - temp.offset().top) * ( card_h/scail_h ) ); // card_h/scail_h

}
function divMove1(e){
  var div1 = document.getElementById('dxy1');
  var temp = $("#template");
  div1.style.position = 'absolute';
  div1.style.top = e.clientY + 'px';
  div1.style.left = e.clientX + 'px';


  $("#x2").val((e.clientX - temp.offset().left) *  ( card_w/scail_w ) );
  $("#y2").val((e.clientY - temp.offset().top) * ( card_h/scail_h ) );
}

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
           $('#template').css('background-image', 'url("' + e.target.result + '")');
        // $('#blah').attr('src', e.target.result);
        // $('#image').attr('value', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
  }
}

function changetext_size(){
  $("#template").css('font-size',$("#myRange").val() + 'px');
}

function select_card(){
 var bg = $('#card_name').val()
 $('#template').css('background-image', 'url("' + bg + '")');
}

</script>
</head>



<body>
<h1 align="center">Card Generator</h1>

<form action="get_data.php" name="fcsv" method="post" enctype="multipart/form-data">
<table align="center">
  <tbody>
  <tr>
    <td>Select file CSV</td>
    <td><input type="file" class="form-control" name="csv" href="javascript:popup('../system/index.php?page=dhcp','',500,500)" required /></td>
  </tr>
  <tr>
    <td>Select Card Image</td>
    <td><input type="file" class="form-control" name="fileToUpload" id="fileToUpload" onchange="readURL(this);"></td>
  </tr>

  <tr>
    <td>Select Font size</td>
    <td>
      <input type="range" class="form-control" onchange="changetext_size();" oninput="changetext_size();" min="32" max="90" name="textSize" value="32" class="slider" id="myRange">
    </td>
  </tr>

  <tr>
    <td>Select card</td>
    <td>
      <select name="card_name" id="card_name" onchange="select_card()" class="form-control">
        <option value="0">select card from list</option>
        <?php
        foreach (glob("cards/*.*") as $filename) {
            echo "<option value='./$filename'>$filename</option>";
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Select card color</td>
    <td>
      <input type="color" class="" name="favcolor" onchange="$('.txt').css('color', $(this).val());" value="#000000">
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <br>
      <div id="template" style="font-size: 32px; height: 339px; width: 750.1px; ">
        <div class="txt" id="dxy" style="position: absolute;">Username</div>
        <div class="txt" id="dxy1" style="position: absolute; top: 247.875px;">Password</div>
      </div>
    </td>
  </tr>
  <tr>
  <td colspan="2">
    <br>
    <input type="submit" name="submit" class="btn btn-success" value="Print">
   </td>
  </tr>
  </tbody>
</table>

<input id="x1" name="x1" type="hidden" value="0">
<input id="y1" name="y1" type="hidden" value="0">
<input id="x2" name="x2" type="hidden" value="0">
<input id="y2" name="y2" type="hidden" value="0">

</form>
</body>
</html>
