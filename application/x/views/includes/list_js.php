<?php
$this->headerlib->add_js(
                            array(
                                'js/bootstrap.min.js',
                                'js/bootstrap.min.js',
                                'bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
                                'jquery-slimscroll/jquery.slimscroll.min.js',
                                'js/jquery.blockui.min.js',
                                'uniform/jquery.uniform.min.js',
                                'bootstrap-switch/js/bootstrap-switch.min.js',
                                'js/datatable.js',
                                'datatables/datatables.min.js',
                                'datatables/plugins/bootstrap/datatables.bootstrap.js',
                                'bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                                'datatables/table-datatables-ajax.min.js',
                                'fancybox/source/jquery.fancybox.pack.js',
                                'js/layout.min.js',
                                'js/demo.min.js',
                                'js/quick-sidebar.min.js'
                            )
                        );
echo $this->headerlib->put_headers_js();
?>

<script>

    function DateCheck()
    {

        var startDate = new Date(document.getElementById("from_created_at").value);
        var endDate = new Date(document.getElementById("to_created_at").value);
        var message = document.getElementById("message");

        if ( startDate > endDate ){

            message.innerHTML = 'from Date is greater';

        }

        else{

            message.innerHTML = '';
        }
    }
</script>