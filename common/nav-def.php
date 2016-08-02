<?php
/**
 * Created by PhpStorm.
 * User: gd
 * Date: 29.5.2016
 * Time: 23:36
 */
include_once "common/scripts.php";
?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Hnefaleikafélag Hafnarfjarðar</a> <img src="img/HFHLogo-48x48.png" style="margin:5px;"/>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                if(isset($user)): ?>
                <li class="active"><a href="index.php"><i class="fa fa-users fa-lg" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
                <li class="active"><a href="modals/addBoxer.php" data-toggle="modal" data-target="#addBoxerModal"><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i></a></li>
                <li class="active"><a>
                        <?php if(!isset($name)){print 'No username found';} else print $name ?>
                <span class="sr-only">(current)</span></a></li>
                <li class="active"><a href="#addSubscriptionModal" class="btn btn-success" role="button" data-toggle="modal" data-target="#addSubscriptionModal"><i class="fa fa-ticket fa-lg" aria-hidden="true"></i></a></li>
                <li class="active"><a href="#updateInfo" class="btn btn-info" role="button" data-toggle="modal" data-target="#updateInfo"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> </li>
                <li class="active"><a href="#" class="btn btn-warning" role="button" data-toggle="modal" data-target="#">&nbsp&nbsp<i class="fa fa-mobile fa-lg" aria-hidden="true">&nbsp</i></a></li>
                <?php
                else:
                    echo '<li class="active"><a href=""><i class="fa fa-users fa-lg" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
                          <li><a href="modals/addBoxer.php" data-toggle="modal" data-target="#addBoxerModal"><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i></a></li>';
                endif;
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="modals/contact.php" class="btn btn-danger" role="button" data-toggle="modal" data-target="#contact"><i class="fa fa-bug fa-lg" aria-hidden="true"></i></a></li>
                <li><a href="http://www.hfh.is">Vefsíða HFH</a></li>
            </ul>
        </div>
    </div>
    <noscript>This site will have serious problems and will not work properly if javascript is disabled</noscript>
    <!-- Modal - addBoxer-->
    <div class="modal fade" id="addBoxerModal" tabindex="-1" role="dialog" aria-labelledby="addBoxerLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Modal Contact -->
    <div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
</nav>
