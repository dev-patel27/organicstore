<!DOCTYPE html>
<html lang="en">
  <head>
  <!--=======================header & start file==============================-->
  <?php include 'includes/start.php';?>
  <?php include 'includes/header.php';?>
  <!--=======================header & start file==============================-->
  <div class="container mb-5">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb2">
            <li class="breadcrumb-item">
            <a href="<?=site_url('')?>">
              <i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li class="breadcrumb-item">My Account</li>
        </ol>
      </nav>
      <div>
        <div class="account-dashboard">
            <div class="row">
              <div class="col-md-12 col-lg-2">
                  <!-- Nav tabs -->
                  <ul role="tablist" class="nav flex-column dashboard-list">
                    <li><a href="#dashboard" data-toggle="tab" class="active">Dashboard</a></li>
                    <li> <a href="#orders" data-toggle="tab">Orders</a></li>
                    <li><a href="#address" data-toggle="tab">Addresses</a></li>
                    <li><a href="#account-details" data-toggle="tab" >Account details</a></li>
                    <li><a href="<?=site_url('logout')?>">logout</a></li>
                  </ul>
              </div>
              <div class="col-md-12 col-lg-10">
                  <!-- Tab panes -->
                  <div class="tab-content dashboard-content">
                    <div class="tab-pane active" id="dashboard">
                        <h3>Dashboard </h3>
                        <div class="row">
                          <div class="col-md-4 mb-3">
                              <div class="card">
                                <div class="card-body" role="tablist">
                                    <div class="text-center">
                                      <a><img src="assets/images/page-img/lunch-box.png"></a>
                                    </div>
                                      <h2>Your Orders</h2>
                                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                      <a><img src="assets/images/page-img/login.png"></a>\
                                    </div>
                                      <h2>Login & security</h2>
                                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                      <a><img src="assets/images/page-img/notebook.png"></a>
                                    </div>
                                      <h2>Your Addresses</h2>
                                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="orders">
                        <h3>Orders</h3>
                        <div class="table-responsive">
                          <table class="table boder-b">
                              <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
$user_id = $this->session->userdata('userSession')->id;
$orders = $this->db->where(array('status' => '1', 'user_id' => $user_id))->order_by('id', 'desc')->group_by('order_id')->get('tbl_order_details')->result_array();
if (!empty($orders)) {
    $order = 1;
    foreach ($orders as $key => $value) {
        echo '<tr>
                                <td>' . $order . '</td>
                                <td>' . date("M d, Y l", strtotime($value['created_at'])) . '</td>
                                <td>&#x20B9;' . $value['grand_total'] . '</td>
                                <td><a href="#" id="' . $value['order_id'] . '" data-toggle="modal" data-backdrop="false" data-target="#ViewOrderModal" class="view order-popup">view</a></td>
                            </tr>';
        $order++;
    }
}
?>
                              </tbody>
                          </table>
                        </div>
                    </div>


                  <!-- ------- View orders modal------- -->
                    <div class="modal fade" id="ViewOrderModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content" style="width: 150% !important;">
                                <div class="modal-header">
                                    <button type="button" class="close my-close" data-dismiss="modal">
                                      <span aria-hidden="true">×</span>
                                      <span class="sr-only">Close</span></button>
                                </div>
                                <div class="modal-body">
                                  <table border='1' cellpadding='0' cellspacing='0' height='100%' width='100%' ' id='bodyTable ' style='border-collapse: collapse;border-radius: 25px; '>
                                    <tbody class="order-display" style='border:none;'></tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div>
                  <!-- ------- View orders modal Ends ------- -->

                    <div class="tab-pane" id="address">
                        <p>The following addresses will be used on the checkout page by default.</p>
                        <h4 class="billing-address">Billing address</h4>
                        <div class="row">
                        <?php
$user_id = $this->session->userdata('userSession')->id;
$billing_address = $this->db->where(array('status' => '1', 'user_id' => $user_id))->order_by('id', 'desc')->limit(3)->get('tbl_billing_address')->result_array();
$count = count($billing_address);
foreach ($billing_address as $row) {
    $selected = ($row["selected"] == '1') ? ('selected') : ('');
    $country = $this->db->where(array('status' => '1', 'id' => $row["country"]))->get('tbl_countries')->row();
    $state = $this->db->where(array('status' => '1', 'id' => $row["state"]))->get('tbl_states')->row();
    $city = $this->db->where(array('status' => '1', 'id' => $row["city"]))->get('tbl_cities')->row();
    echo '<div class="col-md-4" id="remove-address-' . $row["id"] . '" onclick="selectAddress(' . $row["id"] . ')">
                <button type="button" id="remove-address-' . $row["id"] . '" onclick="removeAddress(' . $row["id"] . ')" class="remove-address close my-close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            <div class="address-1 ' . $selected . '" id="select-address-' . $row["id"] . '">
              <strong style="text-transform: capitalize;"> ' . $row["first_name"] . ' ' . $row["last_name"] . ' </strong>
                <small>
                  <address>' . $row["address"] . ', ' . $city->city_name . ', ' . $state->state_name . ', ' . $country->country_name . '-' . $row["post_code"] . '<br>
                  Mobile No - ' . $row["mobile_no"] . '<br>
                  Email - ' . $row["email"] . '
                  </address>
                </small>
              </div>
            </div>';
}
if ($count == 0) {
    echo '<div class="col-md-4 address-popup">
    <div class="address-1">
      <address>
      <i class="plus-design fa fa-plus" style="font-size:120px;" data-toggle="modal" data-target="#AddressModal" data-dismiss="modal"></i>
      </address>
    </div>
  </div>

        <div class="col-md-4 address-popup">
          <div class="address-1">
            <address>
            <i class="plus-design fa fa-plus" style="font-size:120px;" data-toggle="modal" data-target="#AddressModal" data-dismiss="modal"></i>
            </address>
          </div>
        </div>

        <div class="col-md-4 address-popup">
          <div class="address-1">
            <address>
            <i class="plus-design fa fa-plus" style="font-size:120px;" data-toggle="modal" data-target="#AddressModal" data-dismiss="modal"></i>
            </address>
          </div>
        </div>';
}
if ($count == 1) {
    echo '<div class="col-md-4 address-popup">
            <div class="address-1">
              <address>
              <i class="plus-design fa fa-plus" style="font-size:120px;" data-toggle="modal" data-target="#AddressModal" data-dismiss="modal">
              </i>
              </address>
            </div>
        </div>

        <div class="col-md-4 address-popup">
          <div class="address-1">
            <address>
            <i class="plus-design fa fa-plus" style="font-size:120px;" data-toggle="modal" data-target="#AddressModal" data-dismiss="modal"></i>
            </address>
          </div>
        </div>';
}
if ($count == 2) {
    echo '<div class="col-md-4 address-popup">
    <div class="address-1">
      <address>
      <i class="plus-design fa fa-plus" style="font-size:120px;" data-toggle="modal" data-target="#AddressModal" data-dismiss="modal"></i>
      </address>
    </div>
  </div>';
}
?>
                        </div>
                    </div>

<!-- ------- Address modal------- -->
          <div class="modal fade" id="AddressModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content" style="width: 150% !important;">
                      <div class="modal-header">
                          <button type="button" class="close my-close" data-dismiss="modal">
                              <span aria-hidden="true">×</span>
                              <span class="sr-only">Close</span></button>
                      </div>
                      <div class="modal-body">
                        <form method="post" id="add-address-form" name="add-address-form">
                        <div class="form-heading text-center">
                          <div class="title">Add Address</div>
                        <!-- Social Line -->
                        </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                  <label for="email">First name</label>
                                  <input type="text" name="add_first_name" id="add_first_name" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Last name</label>
                                    <input type="text" name="add_last_name" id="add_last_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="text" name="add_email" id="add_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="text" name="add_number" id="add_number" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address </label>
                                    <textarea name="add_address" style="height : 80px !important;" id="add_address" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="Country">Country</label>
                                <select class="form-control" name="bill_country" id="bill_country" onchange="getCountry()">
                                    <option value="">Select Country</option>
                                    <?php
$country = $this->db->where(array('status' => '1', 'id' => $query->country))->get('tbl_countries')->row();
$selected = ($country->id == $query->country) ? 'selected' : '';
echo '<option value="' . $country->id . '" ' . $selected . '>' . $country->country_name . '</option>';

$country = $this->front_model->getCountryDb();
foreach ($country as $row) {
    echo "<option value='" . $row->id . "'>" . $row->country_name . "</option>";
}
?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="State">State</label>
                                <select class="form-control" name="bill_state" id="bill_state" onchange="getState()">
                                    <option value="">Select State</option>
                                    <?php
$state = $this->db->where(array('status' => '1', 'id' => $query->state))->get('tbl_states')->row();
$selected = ($state->id == $query->state) ? 'selected' : '';
echo '<option value="' . $state->id . '" ' . $selected . '>' . $state->state_name . '</option>';
?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="City">City</label>
                                <select class="form-control" name="bill_city" id="bill_city">
                                    <option value="">Select City</option>
                                    <?php
$city = $this->db->where(array('status' => '1', 'id' => $query->city))->get('tbl_cities')->row();
$selected = ($city->id == $query->city) ? 'selected' : '';
echo '<option value="' . $city->id . '" ' . $selected . '>' . $city->city_name . '</option>';
?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Postcode / ZIP</label>
                                    <input type="text" name="add_post_code" id="add_post_code" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" id="add-address" class="btn btn-md my-btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
                  <!-- ------- Address modal Ends ------- -->


                    <div class="tab-pane fade" id="account-details">
                        <h3>Account details </h3>
                        <div class="login m-0">
                          <div class="login-form-container">
                              <div class="account-login-form">
                                <form method="post" id="change-data-form" name="change-data-form">
                                    <div class="input-radio">
                                      <p>Social title</p>
                                      <span class="custom-radio">
                                      <?php
$user_id = $this->session->userdata('userSession')->id;
$user = $this->db->where(array('status' => '1', 'id' => $user_id))->get('tbl_customer_details')->row();
$new_pass = $user->password;
$new_pass1 = md5($new_pass);
$selected_male = ($user->social_title == 'male') ? ('checked') : ('');
$selected_female = ($user->social_title == 'female') ? ('checked') : ('');
?>
                                        <input type="radio" class="social-title" id="male" name="social_title"<?=$selected_male?> value="male">
                                      Mr.</span> &nbsp;&nbsp;
                                      <span class="custom-radio">
                                        <input type="radio" class="social-title" id="female" name="social_title" <?=$selected_female?> value="female">
                                      Mrs.</span>
                                    </div>
                                    <div class="account-input-box">
                                      <div class="row">
                                          <div class="col-md-6">
                                            <label>First Name</label>
                                            <input type="text" id="change_first_name" name="change_first_name" value="<?=$user->first_name;?>" class="form-control">
                                          </div>
                                          <div class="col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" id="change_last_name" name="change_last_name" value="<?=$user->last_name;?>" class="form-control">
                                          </div>
                                          <div class="col-md-6">
                                            <label>Email</label>
                                            <input type="text" id="change_email" name="change_email" value="<?=$user->email;?>" class="form-control">
                                          </div>
                                          <div class="col-md-6">
                                            <label>Password</label>
                                            <input type="password" data-toggle="modal" data-target="#PasswordModal" data-dismiss="modal" value="<?=$new_pass1;?>" class="form-control">
                                          </div>
                                          <div class="col-md-6">
                                            <label>Birthdate</label>
                                            <input type="text" class="form-control" placeholder="DD/MM/YYYY" value="<?=$user->dob;?>" name="change_dob" id="change_dob">
                                            <div class="example"> (E.g.: 31/05/1970) </div>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="button-box">
                                      <button class="btn default-btn change-details" type="button">Save</button>
                                    </div>
                                </form>
                              </div>
                          </div>
                        </div>
                    </div>
                  </div>

<!-- ------- Password modal ------- -->
<div class="modal fade" id="PasswordModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close my-close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="change-password-form" id="change-password-form">
                    <!-- Form Title -->
                    <div class="form-heading text-center">
                        <div class="title">Change Password</div>
                        <!-- Social Line -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="password" id="old_password" name="old_password" placeholder="Old Password"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <input type="password" id="new_password" name="new_password" placeholder="New Password"/>

                        <input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm Password"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-md my-btn-success">Save</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <hr>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ------- Password modal ends ------- -->

                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
  <!--=======================footer file==============================-->
  <?php include 'includes/footer.php';?>
  <!--=======================footer script==============================-->
  <?php include 'includes/footer_scripts.php';?>
  </body>
</html>