<div id="wowslider-container1">
    <div class="ws_images">
        <ul>
            <?php
            $slider = $this->front_model->get_slider();
            foreach ($slider as $key => $value) {
                ?>
                <li>
                    <img src="<?= SLIDER_IMG_URL . $value['image'] ?>" alt="organic store"/>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <div class="ws_bullets">
        <div>
            <?php
            foreach ($slider as $key => $value) {
                ?>
                <a href="#"><span><?= $key; ?></span></a>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="ws_shadow"></div>
</div>
