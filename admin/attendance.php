<?php
/**
 * Created by PhpStorm.
 * User: gd
 * Date: 17.9.2016
 * Time: 22:57
 */

define(fullDirPath, dirname(__FILE__));
define('HAS_LOADED', true);

include_once (fullDirPath . '/../common/base.php');
$pageTitle = "Mætingaskrá";
$navAction = 'attendance';
include_once (fullDirPath . '/class.sql.php');
$newSQL = new newSQL();

    $yesterDay = date('Y-m-d',strtotime("-1 days"));
    $currDate = date('Y-m-d');
    $attendanceToday = $newSQL->list_structured_attendance($currDate);
    $attendanceYesterday = $newSQL->list_structured_attendance($yesterDay);
    $attendance2DaysAgo = $newSQL->list_structured_attendance(date('Y-m-d',strtotime("-2 days")));
    //$framhalds = $newSQL->list_structured_attendance_for_group($currDate, utf8_decode('Framhaldshópur'));
    include_once (fullDirPath . "/head.php");
    include_once (fullDirPath . "/nav-def.php");


?>

    <div class="container">
        <div class="col-sm-12">
            <div class="well">
                <h3> <strong><?php echo date('l d M Y'); ?></strong></h3>
                <?php echo 'Week: ' . date('W') . ' - Day: ' . date('z') ?>
                <br /><br />
                <table id="boxersTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nafn</th>
                        <th>Mætti kl:</th>
                        <th>Hópur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!$attendanceToday){
                        print '<p class="text-danger">Enginn hefur skráð sig inn ennþá</p>';
                    } else {
                        print UTF8_encode($attendanceToday);
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well">
                <h3> <strong><?php echo date('l d M Y', strtotime("-1 days")); ?></strong></h3>
                <?php echo 'Week: ' . date('W', strtotime("-1 days"))  . ' - Day: ' . date('z', strtotime("-1 days")) ?>
                <br /><br />
                <table id="boxersTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nafn</th>
                        <th>Mætti kl:</th>
                        <th>Hópur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!$attendanceYesterday){
                        print '<p class="text-danger">Enginn hefur skráð sig inn ennþá</p>';
                    } else {
                        print UTF8_encode($attendanceYesterday);
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well">
                <h3> <strong><?php echo date('l d M Y', strtotime("-2 days")); ?></strong></h3>
                <?php echo 'Week: ' . date('W', strtotime("-2 days")) . ' - Day: ' . date('z', strtotime("-2 days")) ?>
                <br /><br />
                <table id="boxersTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nafn</th>
                        <th>Mætti kl:</th>
                        <th>Hópur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!$attendance2DaysAgo){
                        print '<p class="text-danger">Enginn skráði sig inn í gær</p>';
                    } else {
                        print UTF8_encode($attendance2DaysAgo);
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<?php

