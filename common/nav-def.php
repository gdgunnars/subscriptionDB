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
                <li><a href="index.php">Yfirlit <span class="sr-only">(current)</span></a></li>
                <li><a href="modals/addBoxer.php" data-toggle="modal" data-target="#addBoxerModal">Nýskrá iðkanda</a></li>
                <li class="active"><a>
                        <?php if(!isset($name)){print 'No User';} else print $name ?>
                <span class="sr-only">(current)</span></a></li>
                <li class="active"><a href="#addSubscriptionModal" class="btn btn-success" role="button" data-toggle="modal" data-target="#addSubscriptionModal"> Kaupa Áskrift </a></li>
                <li class="active"><a href="#updateInfo" class="btn btn-info" role="button" data-toggle="modal" data-target="#updateInfo"> Breyta upplýsingum </a></li>
                <li class="active"><a href="#" class="btn btn-warning" role="button" data-toggle="modal" data-target="#"> Senda SMS </a></li>
                <?php
                else:
                    echo '<li class="active"><a href="">Yfirlit <span class="sr-only">(current)</span></a></li>
                          <li><a href="modals/addBoxer.php" data-toggle="modal" data-target="#addBoxerModal">Nýskrá iðkanda</a></li>';
                endif;
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Senda tilkynningu <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tilkynningar">Senda tilkynningu á netfang eða SMS</a></li>
                        <li class="divider"></li>
                        <li><a href="modals/contact.php" data-toggle="modal" data-target="#contact">Senda tilkynningu á vefstjóra</a></li>
                    </ul>
                </li>
                <li><a href="http://www.hfh.is">Vefsíða HFH</a></li>
            </ul>
        </div>
    </div>

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
