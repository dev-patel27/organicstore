<?php
$cssArray = array(
                'datatables/datatables.min.css',
                'datatables/plugins/bootstrap/datatables.bootstrap.css',
                'bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                'fancybox/source/jquery.fancybox.css'
            );
echo $this->headerlib->put_css( $cssArray );
?>