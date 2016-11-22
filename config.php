<?php
class ConfigClass {
    public static function getConfig() {
        $CONFIG['BASE_PATH'] = dirname(__FILE__);
        $CONFIG['SAVING_USER_IMAGES'] = sprintf("%s/%s", $CONFIG['BASE_PATH'], 'static/img-usr');
        $p = explode("/", $CONFIG['BASE_PATH']);
        $CONFIG['USER_IMAGE_PATH'] = sprintf("/%s/%s", $p[count($p)-1], 'static/img-usr');
        $CONFIG['STATIC_IMAGES'] = sprintf("/%s/%s", $p[count($p)-1], 'static/img');

        $CONFIG['FRONTPAGE_LOGO'] = sprintf("%s/%s", $CONFIG['STATIC_IMAGES'], "HFHLogo-192x192.png");
        $CONFIG['CHECKIN_LOGO'] = sprintf("%s/%s", $CONFIG['STATIC_IMAGES'], "HFHLogo.png");

        return $CONFIG;
    }
}
?>
