<?php
$total_no_img = $this->db->where('status', '1')->order_by('id', 'desc')->get('tbl_promotion')->num_rows();
$dividing_img = ceil($total_no_img / 2);
?>
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-md-6 text-center mb-1">
            <div class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
$first_section = $this->db->where('status', '1')->order_by('id', 'desc')->limit($dividing_img)->get('tbl_promotion')->result_array();
foreach ($first_section as $key => $value) {
    $even_odd = ($key % 2 !== 0) ? 'active' : '';
    $last_id = $value['id'];
    ?>
                        <div class="carousel-item <?=$even_odd?>">
                            <figure class="imghvr-push-right">
                                <a href="<?=site_url('fruits-vegetables')?>">
                                    <img src="<?=PROMOTION_IMG_URL . $value['image']?>"
                                         class="promotion-img img-fluid"
                                         alt="organic store" title="organic store">
                                </a>
                            </figure>
                        </div>
                        <?php
}
?>
                </div>
            </div>
        </div>

        <div class="col-md-6 text-center mb-1">
            <div class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
$second_section = $this->db->where(array('status' => '1', 'id<' => $last_id))->order_by('id', 'desc')->get('tbl_promotion')->result_array();
foreach ($second_section as $key => $value) {
    $even_odd = ($key % 2 !== 0) ? 'active' : '';
    ?>
                        <div class="carousel-item <?=$even_odd?>">
                            <figure class="imghvr-push-right">
                                <a href="<?=site_url('fruits-vegetables')?>">
                                    <img src="<?=PROMOTION_IMG_URL . $value['image']?>"
                                         class="promotion-img img-fluid"
                                         alt="organic store" title="organic store">
                                </a>
                            </figure>
                        </div>
                        <?php
}
?>
                </div>
            </div>
        </div>
    </div>
</div>