<?php
class ConfigClass {
    public static function getConfig() {
        //hér skilgreiningur $CONFIG og svo endaru á return $CONFIG;
        $CONFIG['BASE_PATH'] = dirname(__FILE__);
        $CONFIG['SAVING_USER_IMAGES'] = sprintf("%s/%s", $CONFIG['BASE_PATH'], 'static/img-usr');
        $p = explode("/", $CONFIG['BASE_PATH']);
        $CONFIG['USER_IMAGE_PATH'] = sprintf("/%s/%s", $p[count($p)-1], 'static/img-usr');
        $CONFIG['STATIC_IMAGES'] = sprintf("/%s/%s", $p[count($p)-1], 'static/img');

        $config['FRONTPAGE_LOGO'] = sprintf("%s/%s", $CONFIG['STATIC_IMAGES'], "HFHLogo-192x192.png");

        return $CONFIG;
    }
    // $CONFIG['BASE_STATIC'] = '/var/www/site/static';
    // $CONFIG['ADMIN_USER_IMAGES'] = sprintf("%s/%s", $CONFIG['BASE_STATIC'], 'admin/images';
}
?>
