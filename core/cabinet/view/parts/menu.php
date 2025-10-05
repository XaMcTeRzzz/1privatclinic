<?php
global $wp;
$route = $wp->request;

$user = new Cabinet_User();
$user_data = $user->get_user_data();
//$is_doctor = !empty($user_data['EmpPosId']);
$is_doctor = false;
?>
<div class="c-sidebar__menu-wrap">
    <ul class="c-sidebar__menu">
        <li class="c-sidebar__menu-item">
            <span class=""><?php _e("Особистий кабінет", 'mz') ?></span>
        </li>
        <?php if (!$is_doctor): // Если пациент ?>
            <li class="c-sidebar__menu-item">
                <a href="<?php echo get_home_url(null, '/cabinet/appointments/'); ?>"
                   data-routelink="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/' : ''; ?>cabinet/appointments/"
                   class="<?php if ($route === 'cabinet/appointments') echo 'active'; ?>"><?php _e("Візити до лікаря", 'mz') ?></a>
            </li>
            <li class="c-sidebar__menu-item">
                <a href="<?php echo get_home_url(null, '/cabinet/analysis/'); ?>"
                   data-routelink="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/' : ''; ?>cabinet/analysis/"
                   class="<?php if ($route === 'cabinet/analysis') echo 'active'; ?>"><?php _e("Результати аналізів", 'mz') ?></a>
            </li>
        <?php else: // Если врач ?>
            <li class="c-sidebar__menu-item">
                <a href="<?php echo get_home_url(null, '/cabinet/doctor-shedule/'); ?>"
                   data-routelink="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/' : ''; ?>cabinet/doctor-shedule/"
                   class="<?php if ($route === 'cabinet/doctor-shedule') echo 'active'; ?>"><?php _e("Графік лікаря", 'mz') ?></a>
            </li>
        <?php endif; ?>
        <li class="c-sidebar__menu-item">
            <a href="<?php echo get_home_url(null, '/cabinet/patient/'); ?>"
               data-routelink="/<?php echo (LOCALE !== 'ru') ? LOCALE . '/' : ''; ?>cabinet/patient/"
               class="<?php if ($route === 'cabinet/patient') echo 'active'; ?>"><?php _e("Особиста інформація", 'mz') ?></a>
        </li>
        <li class="c-sidebar__menu-item exit">
            <a href="javascript:cabinetExit();"><?php _e("вийти", 'mz') ?></a>
        </li>
        <?php if (!$is_doctor): // Если пациент ?>
            <li class="c-sidebar__menu-item create-event">
                <a href="<?php echo get_home_url(null, '/schedule/'); ?>"
                   class="btn"><?php _e("записатися на прийом", 'mz') ?></a>
            </li>
        <?php endif; ?>
    </ul>
</div>