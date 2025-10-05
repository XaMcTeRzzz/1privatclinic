<?php get_header(); ?>

    <style>
        .fancybox-content .schedule-table-mob.enter {
            width: 300px;
            padding: 25px;
        }

        .indicator svg polyline {
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .indicator svg polyline#back {
            stroke: rgba(149, 197, 61, 0.3);
        }

        .indicator svg polyline#front {
            stroke: #95c53d;
            stroke-dasharray: 12, 36;
            stroke-dashoffset: 48;
            animation: dash 1s linear infinite;
        }

        @-moz-keyframes dash {
            62.5% {
                opacity: 0;
            }
            to {
                stroke-dashoffset: 0;
            }
        }

        @-webkit-keyframes dash {
            62.5% {
                opacity: 0;
            }
            to {
                stroke-dashoffset: 0;
            }
        }

        @-o-keyframes dash {
            62.5% {
                opacity: 0;
            }
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes dash {
            62.5% {
                opacity: 0;
            }
            to {
                stroke-dashoffset: 0;
            }
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        :focus {
            outline: none !important;
        }

        .schedule-center-right-top .link-back {
            line-height: 19px;
        }

        @media screen and (min-width: 992px) {
            .schedule {
                min-height: 500px;
            }
        }
    </style>
    <main role="main" class="content">
        <section class="schedule">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><?php _e('Главная', 'mz') ?></a></li>
                    <li class="breadcrumb-item"><span><?php the_title(); ?></span></li>
                </ol>
                <div class="schedule-top">
                    <div class="rowFlex jc-sb-md">
                        <div class="colFlex col-md-4 col-lg-3">
                            <div class="title wow mb-40-20" data-wow-delay="5s">
                                <div class="title-wrap">
                                    <h1><?php the_title(); ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="colFlex col-md-12 listLinksWrapper">
                            <ul class="selectLint"></ul>
                        </div>
                        <div class="colFlex colFlex col-md-8">
                            <div class="select-wrap d-none">
                                <select id="schedule-select">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="schedule-center rowFlex">

                    <div class="schedule-center-left colFlex col-md-4 col-lg-3"></div>

                    <div class="schedule-center-right colFlex col-md-8" style="display: none;">
                        <div class="schedule-center-right-top">
                            <a href="javascript:;" onclick="jQuery('.schedule-center-right').hide();jQuery('.schedule-center-left').slideDown();" class="link-back">
                                <svg class="svg-sprite-icon icon-arrowL">
                                    <use xlink:href="/wp-content/themes/medzdrav/core/images/svg/symbol/sprite.svg#arrowL"></use>
                                </svg>
                                к выбору врача</a>
                            <div id="mini-card-doctor"></div>
                            <div id="littele-schedule-doctor"></div>
                        </div>
                        <div class="schedule-center-right-bottom">
                            <a href="/uslugi/stoimost-uslug/" class="btn" target="_blank"><?php _e('Стоимость', 'mz') ?></a> <span class="text-gray"><?php _e('услуги и консультации', 'mz') ?></span>
                        </div>

                        <div class="tabs-container">
                            <ul class="tabs">
                                <li class="tab-link current" data-tab="tab-1"><?php _e('неделя', 'mz') ?></li>
                                <li class="tab-link" data-tab="tab-2"><?php _e('месяц', 'mz') ?></li>
                            </ul>

                            <div id="tab-1" class="tab-content current">


                                <table class="schedule-table" id="table-week"></table>

                                <div id="schedule-table-mob-week"></div>

                            </div>

                            <div id="tab-2" class="tab-content">


                                <table class="schedule-table" id="table-month"></table>

                                <div id="schedule-table-mob-month"></div>

                            </div>
                        </div>
                        <div id="schedule-time-table-mob"></div>

                    </div>

                </div>
            </div>
        </section>
    </main>

<?php get_footer(); ?>