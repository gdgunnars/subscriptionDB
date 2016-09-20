<?php
/**
 * Created by PhpStorm.
 * User: gd
 * Date: 17.9.2016
 * Time: 22:57
 */

define(fullDirPath, dirname(__FILE__));

include_once (fullDirPath . '/../common/base.php');
$pageTitle = "Mætingaskrá";
include_once (fullDirPath . '/class.sql.php');
$newSQL = new newSQL();

    $yesterDay = date('Y-m-d',strtotime("-1 days"));
    $currDate = date('Y-m-d');
    $boxers_list = $newSQL->list_structured_attendance($currDate);
    $oldBoxer_list = $newSQL->list_structured_attendance($yesterDay);
    include_once (fullDirPath . "/head.php");
    include_once (fullDirPath . "/nav-def.php");

    ?>

    <div class="container">
        <div class="col-sm-6">
            <div class="well">
                <h3> <strong><?php echo date('l d M Y'); ?></strong></h3>
                <?php echo 'Week: ' . date('W') . ' - Day: ' . date('z') ?>
                <br /><br />
                <table id="boxersTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nafn</th>
                        <th>Dagsettning & Tími</th>
                        <th>Hópur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!$boxers_list){
                        print '<p class="text-danger">Enginn hefur skráð sig inn ennþá</p>';
                    } else {
                        print UTF8_encode($boxers_list);
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well">
                <h3> <strong><?php echo date('l d M Y', strtotime("-1 days")); ?></strong></h3>
                <?php echo 'Week: ' . date('W', strtotime("-1 days")) . ' - Day: ' . date('z', strtotime("-1 days")) ?>
                <br /><br />
                <table id="boxersTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nafn</th>
                        <th>Dagsettning & Tími</th>
                        <th>Hópur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!$oldBoxer_list){
                        print '<p class="text-danger">Enginn hefur skráð sig inn ennþá</p>';
                    } else {
                        print UTF8_encode($oldBoxer_list);
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php

