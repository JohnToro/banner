<?php
/**
*   Common AJAX functions
*
*   @author     Lee Garner <lee@leegarner.com>
*   @copyright  Copyright (c) 2009-2017 Lee Garner <lee@leegarner.com>
*   @package    banner
*   @version    0.2.1
*   @license    http://opensource.org/licenses/gpl-2.0.php
*               GNU Public License v2 or later
*   @filesource
*/
namespace Banner;

/**
*  Include required glFusion common functions
*/
require_once '../../../lib-common.php';

switch ($_POST['action']) {
case 'toggleEnabled':
    $oldval = $_POST['oldval'] == 1 ? 1 : 0;

    switch ($_POST['type']) {
    case 'banner':
        USES_banner_class_banner();
        $B = new Banner($_POST['id']);
        $newval = $B->toggleEnabled($oldval);
        break;

    case 'category':
        USES_banner_class_category();
        $newval = Category::toggleEnabled($oldval, $_POST['id']);
        $status = true;
        break;

    case 'campaign':
        USES_banner_class_campaign();
        $newval = Campaign::toggleEnabled($oldval, $_POST['id']);
        break;

    case 'cat_cb':
        USES_banner_class_category();
        $newval = Category::toggleCenterblock($oldval, $_POST['id']);
        $status = true;
        break;

    default:
        exit;
    }
    if ($newval == $oldval) {   // no change made
        $msg = $LANG_BANNER['msg_item_nochange'];
    } else {
        $msg = $newval ? $LANG_BANNER['msg_item_enabled'] :
                $LANG_BANNER['msg_item_disabled'];
    }
    $result = array(
        'newval' => $newval,
        'statusMessage' => $msg,
    );
    $result = json_encode($result);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-cache, must-revalidate');
    //A date in the past
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

    echo $result;
    break;
}

?>
