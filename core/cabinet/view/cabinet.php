<?php define('DONOTCACHEPAGE', 1); ?>
<?php
global $wp_query, $wp;
$wp_query->is_home = false;

$cabinet_route = $args['route'];

$patient_info = (new Cabinet_User())->get_user_data();//Cabinet_Request_Logic::get_patient_info_by_emc();
$patient_full_name = '';
$is_doctor = false;
if (!is_wp_error($patient_info)) {
    $patient_full_name = $patient_info['FirstName'] . ' ' . $patient_info['MiddleName'] . ' ' . $patient_info['LastName'];
    $is_doctor = !empty($patient_info['EmpPosId']);
}
?>
<?php
//$cabinet_cache = new Cabinet_Cache();
//$header = $cabinet_cache->get('header' . LOCALE);
//if ($header) {
//	echo $header;
//}
//else {
//	ob_start();
//	get_header();
//	$content = ob_get_clean();
//	$result = $cabinet_cache->set($content, 'header' . LOCALE);
//	echo $content;
//	if (!$result || is_wp_error($result)) {
//		get_header();
//	}
//}
get_header();
?>
<script>
    const CABINET_PATH = '<?php echo $wp->request?>';
    const ITEMS_FOR_ONE_SHOW = <?php echo ITEMS_FOR_ONE_SHOW?>;
</script>
<main role="main" class="content cabinet">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a
                        href="/<?php echo (LOCALE !== 'ru') ? LOCALE : ''; ?>"><?php _e("головна", 'mz') ?></a></li>
            <?php if ($cabinet_route === 'index'): ?>
                <li class="breadcrumb-item index"><span><?php _e("особистий кабінет", 'mz') ?></span></li>
            <?php else: ?>
                <li class="breadcrumb-item hide index"><a
                            href="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/' : ''; ?>cabinet/"
                            data-routelink="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/'
                                : ''; ?>cabinet/"><?php _e("особистий кабінет", 'mz') ?></a></li>
                <?php if ($cabinet_route === 'appointments'): ?>
                    <li class="breadcrumb-item page"><span><?php _e("візити до лікаря", 'mz') ?></span></li>
                <?php elseif ($cabinet_route === 'analysis'): ?>
                    <li class="breadcrumb-item page"><span><?php _e("результати аналізів", 'mz') ?></span></li>
                <?php elseif ($cabinet_route === 'patient'): ?>
                    <li class="breadcrumb-item page"><span><?php _e("особиста інформація", 'mz') ?></span></li>
                <?php elseif ($cabinet_route === 'doctor-shedule'): ?>
                    <li class="breadcrumb-item page"><span><?php _e("Графік лікаря", 'mz') ?></span></li>
                <?php endif; ?>
            <?php endif; ?>
        </ol>
        <div class="c-infobar">
            <div class="c-infobar__name">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="16" fill="#F9F9F9"/>
                    <path
                            d="M15.9968 19.1747C11.6838 19.1747 7.99976 19.8547 7.99976 22.5747C7.99976 25.2957 11.6608 25.9997 15.9968 25.9997C20.3098 25.9997 23.9938 25.3207 23.9938 22.5997C23.9938 19.8787 20.3338 19.1747 15.9968 19.1747Z"
                            fill="#707E98"/>
                    <path opacity="0.4"
                          d="M15.9967 16.5838C18.9347 16.5838 21.2887 14.2288 21.2887 11.2918C21.2887 8.35476 18.9347 5.99976 15.9967 5.99976C13.0597 5.99976 10.7047 8.35476 10.7047 11.2918C10.7047 14.2288 13.0597 16.5838 15.9967 16.5838Z"
                          fill="#707E98"/>
                </svg>
                <a href="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/' : ''; ?>cabinet/"
                   data-routelink="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/'
                       : ''; ?>cabinet/"><?php echo $patient_full_name ?></a>
            </div>
            <div class="c-infobar__exit" onclick="cabinetExit()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.89535 11.23C9.45785 11.23 9.11192 11.57 9.11192 12C9.11192 12.42 9.45785 12.77 9.89535 12.77H16V17.55C16 20 13.9753 22 11.4724 22H6.51744C4.02471 22 2 20.01 2 17.56V6.45C2 3.99 4.03488 2 6.52762 2H11.4927C13.9753 2 16 3.99 16 6.44V11.23H9.89535ZM19.6302 8.5402L22.5502 11.4502C22.7002 11.6002 22.7802 11.7902 22.7802 12.0002C22.7802 12.2002 22.7002 12.4002 22.5502 12.5402L19.6302 15.4502C19.4802 15.6002 19.2802 15.6802 19.0902 15.6802C18.8902 15.6802 18.6902 15.6002 18.5402 15.4502C18.2402 15.1502 18.2402 14.6602 18.5402 14.3602L20.1402 12.7702H16.0002V11.2302H20.1402L18.5402 9.6402C18.2402 9.3402 18.2402 8.8502 18.5402 8.5502C18.8402 8.2402 19.3302 8.2402 19.6302 8.5402Z"
                          fill="#707E98"/>
                </svg>
                <span><?php _e("Вихід", 'mz') ?></span>
            </div>
        </div>
        <div class="c-sidebar-mob">
            <?php if ($is_doctor): // Если врач ?>
                <a href="" data-routelink="" class="btn c-sidebar-mob-button"
                   id="download-last-doctor-shedule"><?php _e("Завантажити останній графік", 'mz') ?></a>
            <?php else: // Если пациент ?>
                <a href="<?php echo get_home_url(null, '/schedule/'); ?>"
                   class="btn c-sidebar-mob-button"><?php _e("записатися на прийом", 'mz') ?></a>
            <?php endif; ?>
            <button class="link-back" id="js-cabinet-sidebar-mob-toggle"><?php _e("розділи", 'mz') ?></button>
            <div class="c-sidebar-mob-wrap">
                <button class="c-sidebar-mob-wrap-cross">
                    <svg class="svg-sprite-icon icon-crossM">
                        <use xlink:href="/wp-content/themes/medzdrav/core/images/svg/symbol/sprite.svg#crossM"></use>
                    </svg>
                </button>
                <?php get_template_part('core/cabinet/view/parts/menu') ?>
            </div>
        </div>
        <div class="rowFlex">
            <div class="colFlex col-sm-4 col-lg-3">
                <div class="sandbar-sticky">
                    <?php get_template_part('core/cabinet/view/parts/menu') ?>
                </div>
            </div>
            <div class="colFlex col-sm-8 col-lg-9">
                <div class="rowFlex" id="js-cabinet-load-page-content">
                    <div class="loading-frame">
                        <svg width="32px" height="24px">
                            <polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
                            <polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
//$footer = $cabinet_cache->get('footer' . LOCALE);
//if ($footer) {
//	echo $footer;
//}
//else {
//	ob_start();
//	get_footer();
//	$content = ob_get_clean();
//	$result = $cabinet_cache->set($content, 'footer' . LOCALE);
//	echo $content;
//	if (!$result || is_wp_error($result)) {
//		get_footer();
//	}
//}
get_footer();
?>
