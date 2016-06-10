<?php
/**
 * Created by PhpStorm.
 * User: gd
 * Date: 7.6.2016
 * Time: 19:38
 */
require_once('class.sql.php');

$pageTitle = "Innskráning";
include_once "common/head.php";
include_once "common/scripts.php";
?>
<div id="bg">
    <img src="img/HFHLogo.png" alt="HFH Logo" />
</div>
<div class="container login-window">
    <div class="col-lg-12 ">
        <form id="checkIn" method="POST" action="">
            <div class="row">
            <fieldset class="form-group col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2">
                <label for="inputID">Vinsamlegast skráðu þig inn</label>
                <input type="text" class="form-control" id="inputID" placeholder="kt">
            </fieldset>
            </div>
            <div class="row">
            <button type="submit" class="btn btn-primary col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2">Innskrá</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        var input = document.getElementById('inputID');

        input.focus();
        input.select();
    });
</script>