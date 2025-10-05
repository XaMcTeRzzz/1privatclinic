<?php get_header(); ?>

<main role="main" class="content">
    <section class="cont">
        <div class="container-fluid">
            <div class="rowFlex">
                <div class="cont-container colFlex col-lg-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/"><?php
								if (LOCALE == 'ru') {
									echo 'Главная';
								} else if (LOCALE == 'ua') {
									echo 'Головна';
								} else {
									echo 'Home';
								}
								?></a>
                        </li>
                        <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
                    </ol>
                    <div class="title wow" data-wow-delay="5s">
                        <div class="title-wrap">
							<h1><?php the_title(); ?></h1>
                        </div>
                    </div>
                    <div class="price-block price-block--page">
                        <div class="price-block-item">
                            <a href="#" class="price-block-item-icon">
                                <svg class="svg-sprite-icon icon-pin">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#pin"></use>
                                </svg>
                            </a>
                            <div class="price-block-item-text">
								<?php
								$address = CFS()->get('contacts_address_' . LOCALE);
								if ($address == '') {
									$address = CFS()->get('contacts_address_ua');
								}
								?>
                                <div class="title-sm"><?php echo $address; ?></div>
                            </div>
                        </div>
                        <div class="price-block-item">
                            <a href="#" class="price-block-item-icon">
                                <svg class="svg-sprite-icon icon-phone">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#phone"></use>
                                </svg>
                            </a>
                            <div class="price-block-item-text">
                                <div class="title-sm">
									<?php $contacts_phone = CFS()->get('contacts_phone'); ?>

									<?php foreach ($contacts_phone as $phone):?>
                                    <div class="price-block-item__link">
                                        <a href="tel:<?=$phone['phone']?>"><?=$phone['phone']?></a>
                                    </div>
									<?php endforeach;?>
                                </div>
                            </div>
                        </div>
                        <?php if(CFS()->get('contacts_email')): ?>
                        <div class="price-block-item">
                            <a href="#" class="price-block-item-icon">
                                <svg class="svg-sprite-icon icon-mail">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#mail"></use>
                                </svg>
                            </a>
                            <div class="price-block-item-text">
                                <div class="title-sm"><a href="mailto:<?php echo CFS()->get('contacts_email'); ?>"><?php echo CFS()->get('contacts_email'); ?></a></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="cont-full--right col-lg-6" >
            <div class="cont-full--right-item">
                <div class="map-small" id="map"></div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="rowFlex">
                <div class="cont-containerTwo colFlex col-lg-6">
                    <div class="price-block price-block--page">
                        <div class="price-block-item" style="min-height: 64px;">
<!--                            <a href="--><?php //the_permalink(754);?><!--" class="price-block-item-icon">-->
<!--                                <svg class="svg-sprite-icon icon-drop">-->
<!--                                    <use xlink:href="--><?php //echo get_template_directory_uri() . '/core/' ?><!--images/svg/symbol/sprite.svg#drop"></use>-->
<!--                                </svg>-->
<!--                            </a>-->
<!--                            <div class="price-block-item-text">-->
<!--                                <div class="title-sm">--><?php //echo get_the_title(754); ?><!--</div>-->
<!--                                <a href="--><?php //the_permalink(754);?><!--" class="link-bubbles">--><?php
//									if (LOCALE == 'ru') {
//										echo 'подробнее';
//									} else if (LOCALE == 'ua') {
//										echo 'докладніше';
//									} else {
//										echo 'more';
//									}
//									?><!--</a>-->
<!--                            </div>-->
                        </div>
                        <div class="price-block-item">
                            <a href="<?php the_permalink(714);?>" class="price-block-item-icon">
                                <svg class="svg-sprite-icon icon-phone">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/core/' ?>images/svg/symbol/sprite.svg#phone"></use>
                                </svg>
                            </a>
                            <div class="price-block-item-text">
                                <div class="title-sm"><?php echo get_the_title(714); ?></div>
                                <a href="<?php the_permalink(714);?>" class="link-bubbles"><?php
									if (LOCALE == 'ru') {
										echo 'подробнее';
									} else if (LOCALE == 'ua') {
										echo 'докладніше';
									} else {
										echo 'more';
									}
									?></a>
                            </div>
                        </div>
                        <!--                        <div class="price-block-item">-->
                        <!--                            <a href="/grafik-raboty/" class="price-block-item-icon">-->
                        <!--                                <svg class="svg-sprite-icon icon-clock">-->
                        <!--                                    <use xlink:href="--><?php //echo get_template_directory_uri() . '/core/' ?><!--images/svg/symbol/sprite.svg#clock"></use>-->
                        <!--                                </svg>-->
                        <!--                            </a>-->
                        <!--                            <div class="price-block-item-text">-->
                        <!--                                <div class="title-sm">--><?php //echo get_the_title(721); ?><!--</div>-->
                        <!--                                <a href="/grafik-raboty/" class="link-bubbles">--><?php
						//                                    if (LOCALE == 'ru') {
						//                                        echo 'подробнее';
						//                                    } else if (LOCALE == 'ua') {
						//                                        echo 'докладніше';
						//                                    } else {
						//                                        echo 'more';
						//                                    }
						//                                    ?><!--</a>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="cont-full--left  col-lg-6">
            <img class="" src="<?php echo get_template_directory_uri() . '/core/' ?>images/content/cont.jpg" alt="Контакты">
        </div>
    </section>
    <script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?language=ru&key=AIzaSyChUAu7Vm9buM_QaDDvC99xh62FokWVqKQ#038;region=RU&amp;ver=4.7.5'></script>
    <script>
        // if HTML DOM Element that contains the map is found...
        if (document.getElementById('map')){
            var latLng = new google.maps.LatLng(49.42978713823434, 27.008128634715195),
                markerIcon = {
                    url: '/wp-content/themes/privatclinic/core/images/general/marker.png',
                    scaledSize: new google.maps.Size(50, 50),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(20,40)
                };

            var mapOptions = {
                zoom: 17,
                center: latLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            var marker = new google.maps.Marker({
                map: map,
                animation: google.maps.Animation.DROP,
                position: latLng,
                icon: markerIcon
            });
            var infowindow = new google.maps.InfoWindow({ // Create a new InfoWindow
                content:"Перша приватна лікарня Старокостянтинівське шосе, 20/4 м. Хмельницький" // HTML contents of the InfoWindow
            });
            google.maps.event.addListener(marker, 'click', function() { // Add a Click Listener to our marker
                infowindow.open(map,marker); // Open our InfoWindow
            });
        }
    </script>
</main>

<?php get_footer(); ?>
