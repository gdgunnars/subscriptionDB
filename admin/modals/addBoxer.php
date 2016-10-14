<?php
/**
 * Created by PhpStorm.
 * User: gd
 * Date: 30.5.2016
 * Time: 02:22
 */
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="addBoxerLabel"><i class="fa fa-user-plus" aria-hidden="true"></i> Bæta við Iðkanda</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal" id="addBoxer" method="POST" action="index.php">
        <fieldset>
            <input type="hidden" name="action" value="addBoxer" />
            <div class="form-group required">
                <label for="inputName" class="col-lg-2 control-label">Nafn</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="inputName" name="name" placeholder="Name of Boxer" required />
                </div>
            </div>
            <div class="form-group required">
                <label for="inputSSN" class="col-lg-2 control-label">Kennitala</label>
                <div class="col-lg-9">
                    <input type="number" class="form-control" id="inputSSN" name="kt" maxlength="10"  placeholder="10 digit Icelandic Kennitala" pattern="((0[1-9])|([12][0-9])|(3[01]))((0[1-9])|(1[0-2]))([0-9]{2})[0-9]{4}" required/>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPhone" class="col-lg-2 control-label">Sími</label>
                <div class="col-lg-9">
                    <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="7 digit Icelandic phone number, f.e. 5552233" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Netfang</label>
                <div class="col-lg-9">
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="valid email address, f.e. user@hfh.is" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Rfid</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="inputRfid" name="rfid" placeholder="RFID identity, 10 digit number" />
                </div>
            </div>
            <div class="form-group required">
                <label class='col-lg-5 col-lg-offset-1 control-label'>
                    Fylla þarf út reyti merkta
                </label>
            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="reset" class="btn btn-danger">Hreinsa</button>
                    <button type="submit" name="" class="btn btn-primary">Skrá Iðkanda</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
