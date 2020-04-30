<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=WEB_NAME?></title>
 <?php
$this->load->view('includes/start');
$this->load->view('includes/header');
?>
<div id="intro-bg" class="intro-bg text-center">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="hero-content fix">
          <h3><?=$message?></h3>
          </div>
      </div>
    </div>
  </div>
</div>
<?php
$this->load->view('includes/footer');
$this->load->view('includes/footer_scripts');
?>
</body>
</html>
