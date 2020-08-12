<?php /* Template Name: Целевые программы */ ?>
<?php    get_header(); ?>

<?php
$deposit_types = array();
for ($i = 1, $deposit = get_field('deposit_'.$i);
     $i <= 5;
     $i++, $deposit = get_field('deposit_'.$i)
    )
{
    if (empty($deposit) || count($deposit) == 0)
        continue;

    if (!empty($deposit['images']) && !empty($deposit['text']))
        $deposit_types[] = $deposit;
}
//print '<pre>'.print_r($deposit_types, true).'</pre>';
?>

<div class="col-lg-12 deposit_type_page">
    <div class="row">
        <div class="coop_maps col-lg-12">
            <h1 class="coop_maps-h1">Целевые программы</h1>

            <?php foreach ($deposit_types as $deposit_type): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!--[xyz-ips snippet="show-card-images"]-->
                            <?php $images = $deposit_type['images']; ?>
                            <?php if (!empty($images)): ?>
                                <?php foreach ($images as $image): ?>
                                    <?php if (empty($image))
                                        continue;
                                    ?>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="coop_maps-img">
                                            <img src="<?php echo esc_url($image); ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <?php if( !empty($images) ): ?>
                        <div id="carouselExampleControls2" class="carousel slide d-lg-none d-md-none d-sm-block" data-ride="carousel">
                            <div class="row">
                                <ol class="carousel-indicators">
                                    <?php $index = 0; ?>
                                    <?php foreach( $images as $image ): ?>
                                        <?php if (!empty($image)): ?>
                                            <li data-target="#carouselExampleIndicators2" data-slide-to="<?php echo $index ?>" <?php if ($index==0) { ?> class="active" <?php } ?>></li>
                                            <?php $index++ ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php $index = 0; ?>
                                    <?php foreach( $images as $image ): ?>
                                        <?php if (!empty($image)): ?>
                                            <div class="<?php if ($index==0) echo 'carousel-item active'; else echo 'carousel-item' ;?>">
                                                <div class="col-md-12">
                                                    <div class="coop_maps-img">
                                                        <img src="<?php echo esc_url($image); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $index++ ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"><</span>
                                    <span class="sr-only">Previous</span>
                                </a>

                                <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true">></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <p class="coop_maps-p"><?php echo $deposit_type['text']; ?></p>

                        <div class="col-lg-2 col-md-4 col-sm-12 ">
                            <div class="row coop_maps-btn">
                                <div id="chat_button" class="btn-custom-one text-center w-100">Заказать</div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<?php get_footer();