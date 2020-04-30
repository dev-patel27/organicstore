<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mybtraintreelib
{
    public function __construct()
    {
        //require_once APPPATH.'third_party/hArpanet/hDash/libraries/dash.php';
        require_once APPPATH.'third_party/braintree/Braintree.php';
    }
}