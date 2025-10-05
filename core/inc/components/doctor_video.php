<?php
$videoLink = CFS()->get('doctor_video');
if ($videoLink && $videoLink != '') {
    ?>
    <div class="container-fluid">
        <div class="col-md-8 mx-auto">
            <div class="video-card">
                <?php

                parse_str( parse_url( $videoLink, PHP_URL_QUERY ), $my_array_of_vars );
                $videId = $my_array_of_vars['v'];

                ?>
                <iframe class="video-card-iframe no-lazy"
                        loading="lazy"
                        src="https://www.youtube.com/embed/<?php echo $videId; ?>"
                        srcdoc="
                                        <style>
                                        *{
                                            padding:0;
                                            margin:0;
                                            overflow:hidden;
                                        }
                                        html,body{
                                        height:100%
                                        }
                                        img,span{
                                        position:absolute;
                                        width:100%;
                                        top:0;
                                        bottom:0;
                                        margin:auto;
                                        }
                                        span{
                                        height:1.5em;
                                        text-align:center;
                                        font:48px/1.5 sans-serif;
                                        color:white;
                                        animation: zoomIn 2s infinite ease-in-out;
                                        text-shadow:0 0 0.5em black;
                                        }
                                        span:hover{
                                           animation-play-state:paused;
                                        }
                                        @keyframes zoomIn {
                                            0% {
                                                transform: scale(1);
                                            }
                                            50% {
                                                 transform: scale(.9,.9);
                                                }
                                            100% {
                                                transform: scale(1);
                                             }
                                        }

                                        </style>
                                        <a href=https://www.youtube.com/embed/<?php echo $videId; ?>?autoplay=1>
                                        <img src=https://img.youtube.com/vi/<?php echo $videId; ?>/sddefault.jpg alt=''>
                                 <span>
                               <svg width='72' height='72' viewBox='0 0 72 72' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                <circle cx='36' cy='36' r='36' fill='#95C53D' fill-opacity='0.24'/>
                                <circle cx='36' cy='36' r='27' fill='#95C53D'/>
                                <path d='M45 36L31.5 43.7942L31.5 28.2058L45 36Z' fill='white'/>
                               </svg>
                                </span>
                                </a>"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        title=""
                ></iframe>


            </div>

            <div class="video-text">
                <?php echo CFS()->get('doctor_video_name'); ?>
            </div>
        </div>
    </div>
<?php } ?>