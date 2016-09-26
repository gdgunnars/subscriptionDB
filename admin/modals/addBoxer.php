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
                    <input type="text" class="form-control" id="inputName" name="name" placeholder="Jon Jonsson" required />
                </div>
            </div>
            <div class="form-group required">
                <label for="inputSSN" class="col-lg-2 control-label">Kennitala</label>
                <div class="col-lg-9">
                    <input type="number" class="form-control" id="inputSSN" name="kt" placeholder="Kennitala t.d. 0102034399" maxlength="10"  required />
                </div>
            </div>
            <div class="form-group">
                <label for="inputPhone" class="col-lg-2 control-label">Sími</label>
                <div class="col-lg-9">
                    <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="símanúmer t.d. 1231234" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Netfang</label>
                <div class="col-lg-9">
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="jon@gmail.com" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Rfid</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" id="inputRfid" name="rfid" placeholder="1234567890" />
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
