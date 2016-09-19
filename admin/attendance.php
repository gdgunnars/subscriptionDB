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


    $boxers_list = $newSQL->list_structured_attendance();
    include_once (fullDirPath . "/head.php");
    include_once (fullDirPath . "/nav-def.php");

    ?>

    <div class="container">
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
                print '<p class="text-danger">There was a problem connecting to the database, contact administrator</p>';
            } else {
                print UTF8_encode($boxers_list);
            }
            ?>
            </tbody>
        </table>
    </div>


<?php

