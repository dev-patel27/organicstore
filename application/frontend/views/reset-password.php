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
        <div class="form-group" style="font-size : 25px;" for='password'>
          Change Password
        </div>
            <?php
if (!empty($no_result_found)) {
    echo $no_result_found;
}
if (!empty($message)) {
    echo '<h3><div class="alert alert-danger">' . $message . '</div></h3>';
} else {
    ?>
      <form name='resetpass-form' id='resetpass-form'>
        <input type=hidden name='user_id' id="user_id" value=<?=$id?> />
        <div class='form-group'>
          <input type='password' name='reset_password' id='reset_password' placeholder='Enter Password' class='form-control display-block'>
        </div>
        <div class='form-group'>
            <input type='password' name='reset_password2' id='reset_password2' placeholder='Re-enter Password' class='form-control'>
        </div>
        <input type='submit' class='btn btn-success btn-lg' value='Reset Password'>
      </form>
<?php
}
?>
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
