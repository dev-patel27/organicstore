<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html> -->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>404 Page no found</title>
	<meta name="viewport" content="width=device-width">
  
	<style type="text/css">
		*, *:after, *:before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  -ms-box-sizing: border-box;
  box-sizing: border-box; }

html {
  background: #ccc;
  font: bold 14px/20px "Trajan Pro", "Times New Roman", Times, serif;
  color: #430400;
  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.15); }

.error-page-wrap {
  width: 310px;
  height: 310px;
  margin: 155px auto; }
  .error-page-wrap:before {
    box-shadow: 0 0 200px 150px #fff;
    width: 310px;
    height: 310px;
    border-radius: 50%;
    position: relative;
    z-index: -1;
    content: '';
    display: block; }

.error-page {
  width: 310px;
  height: 310px;
  border-radius: 50%;
  top: -310px;
  position: relative;
  text-align: center;
  background: #d36242;
  background: -moz-linear-gradient(top, #d36242 0%, darkred 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #d36242), color-stop(100%, darkred));
  background: -webkit-linear-gradient(top, #d36242 0%, darkred 100%);
  background: -o-linear-gradient(top, #d36242 0%, darkred 100%);
  background: -ms-linear-gradient(top, #d36242 0%, darkred 100%);
  background: linear-gradient(to bottom, #d36242 0%, darkred 100%);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$firstColor', endColorstr='$secondColor',GradientType=0 ); }
  .error-page:before {
    width: 63px;
    height: 63px;
    border-radius: 50%;
    box-shadow: 3px 25px 0 5px #C95439;
    content: '';
    z-index: -1;
    display: block;
    position: relative;
    top: -19px;
    left: 44px; }
  .error-page:after {
    width: 310px;
    height: 17px;
    margin: 0 auto;
    top: 25px;
    content: '';
    z-index: -1;
    display: block;
    position: relative;
    background: -moz-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.65) 0%, rgba(35, 26, 26, 0) 59%, rgba(60, 44, 44, 0) 100%);
    background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(0, 0, 0, 0.65)), color-stop(59%, rgba(35, 26, 26, 0)), color-stop(100%, rgba(60, 44, 44, 0)));
    background: -webkit-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.65) 0%, rgba(35, 26, 26, 0) 59%, rgba(60, 44, 44, 0) 100%);
    background: -o-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.65) 0%, rgba(35, 26, 26, 0) 59%, rgba(60, 44, 44, 0) 100%);
    background: -ms-radial-gradient(center, ellipse cover, rgba(0, 0, 0, 0.65) 0%, rgba(35, 26, 26, 0) 59%, rgba(60, 44, 44, 0) 100%);
    background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.65) 0%, rgba(35, 26, 26, 0) 59%, rgba(60, 44, 44, 0) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a6000000', endColorstr='#003c2c2c',GradientType=1 ); }
  .error-page h1 {
    color: rgba(255, 255, 255, 0.94);
    font-size: 100px;
    margin: 65px auto 0 auto;
    text-shadow: 0px 0 7px rgba(0, 0, 0, 0.5); }
    .error-page h1:before {
      width: 260px;
      height: 1px;
      position: relative;
      margin: 0 auto;
      top: 70px;
      content: '';
      display: block;
      background: -moz-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(111, 25, 25, 0.65)), color-stop(70%, rgba(75, 38, 38, 0)), color-stop(100%, rgba(60, 44, 44, 0)));
      background: -webkit-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: -o-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: -ms-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: radial-gradient(ellipse at center, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a66f1919', endColorstr='#003c2c2c',GradientType=1 ); }
    .error-page h1:after {
      width: 260px;
      height: 1px;
      content: '';
      display: block;
      opacity: 0.2;
      margin: 0 auto;
      top: 50px;
      position: relative;
      background: -moz-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(247, 173, 148, 0.65)), color-stop(99%, rgba(255, 255, 255, 0.01)), color-stop(100%, rgba(255, 255, 255, 0)));
      background: -webkit-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: -o-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: -ms-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: radial-gradient(ellipse at center, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a6f7ad94', endColorstr='#00ffffff',GradientType=1 ); }
  .error-page h2 {
    margin: 55px 0 30px 0;
    font-size: 17px; }
    .error-page h2:before {
      width: 130px;
      height: 1px;
      position: relative;
      margin: 0 auto;
      top: 31px;
      content: '';
      display: block;
      background: -moz-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(111, 25, 25, 0.65)), color-stop(70%, rgba(75, 38, 38, 0)), color-stop(100%, rgba(60, 44, 44, 0)));
      background: -webkit-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: -o-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: -ms-radial-gradient(center, ellipse cover, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      background: radial-gradient(ellipse at center, rgba(111, 25, 25, 0.65) 0%, rgba(75, 38, 38, 0) 70%, rgba(60, 44, 44, 0) 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a66f1919', endColorstr='#003c2c2c',GradientType=1 ); }
    .error-page h2:after {
      width: 130px;
      height: 1px;
      content: '';
      display: block;
      opacity: 0.2;
      margin: 0 auto;
      top: 11px;
      position: relative;
      background: -moz-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(247, 173, 148, 0.65)), color-stop(99%, rgba(255, 255, 255, 0.01)), color-stop(100%, rgba(255, 255, 255, 0)));
      background: -webkit-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: -o-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: -ms-radial-gradient(center, ellipse cover, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      background: radial-gradient(ellipse at center, rgba(247, 173, 148, 0.65) 0%, rgba(255, 255, 255, 0.01) 99%, rgba(255, 255, 255, 0) 100%);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#a6f7ad94', endColorstr='#00ffffff',GradientType=1 ); }

	.error-back {
	  text-decoration: none;
	  color: #430400;
	  font-size: 15px; }
  .error-back:hover {
    color: #EB957D;
    text-shadow: 0 0 3px black; }

	</style>

</head>
<body>
	<div class="error-page-wrap">
		<article class="error-page gradient">
			<hgroup>
				<h1>404</h1>
				<h2 style="color: #FFF;">oops! page not found</h2>
			</hgroup>
			<a href="<?= BASE_URL; ?>" title="Home" class="error-back" style="color: #FFF;">Home</a>
		</article>
	</div>
</body>
</html>