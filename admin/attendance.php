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
if(!empty($_GET)):
    echo $newSQL->attendance_for_all_groups_json($_GET['date']);
else:
    $attendanceToday = $newSQL->list_structured_attendance_for_all_groups(date('Y-m-d'));
    $attendanceYesterday = $newSQL->list_structured_attendance_for_all_groups(date('Y-m-d',strtotime("-1 days")));
    $attendance2DaysAgo = $newSQL->list_structured_attendance_for_all_groups(date('Y-m-d',strtotime("-2 days")));
    include_once (fullDirPath . "/head.php");
    include_once (fullDirPath . "/nav-def.php");
?>
    <div class="container">
        <div class="col-sm-12">
            <div class="well">
                <h3> <strong><?php echo date('l d M Y'); ?></strong></h3>
                <?php echo 'Week: ' . date('W') . ' - Day: ' . date('z') ?>
                <br />
                <?php
                if(!$attendanceToday){
                    print '<p class="text-danger">Enginn hefur skráð sig inn ennþá</p>';
                } else {
                    foreach($attendanceToday as $g=>$a){
                        print UTF8_encode($a);
                    }
                }
                ?>
            </div>
        </div>
        <div class="row col-sm-6">
            <div class="col-sm-12">
                <div class="well">
                    <h3> <strong><?php echo date('l d M Y', strtotime("-1 days")); ?></strong></h3>
                    <?php echo 'Week: ' . date('W', strtotime("-1 days"))  . ' - Day: ' . date('z', strtotime("-1 days")) ?>
                    <br />
                    <?php
                    if(!$attendanceYesterday){
                        print '<p class="text-danger">No one signed in yesterday</p>';
                    } else {
                        foreach($attendanceYesterday as $g=>$a){
                            print UTF8_encode($a);
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="well">
                    <h3> <strong><?php echo date('l d M Y', strtotime("-2 days")); ?></strong></h3>
                    <?php echo 'Week: ' . date('W', strtotime("-2 days")) . ' - Day: ' . date('z', strtotime("-2 days")) ?>
                    <br />
                    <?php
                    if(!$attendance2DaysAgo){
                        print '<p class="text-danger">No one signed in yesterday</p>';
                    } else {
                        foreach($attendance2DaysAgo as $g=>$a){
                            print UTF8_encode($a);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="well">
                <h4 id="datePickerHeader"> </h4>
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputDate" class="col-lg-4 control-label"> Veldu dagsettningu </label>
                            <div class="col-lg-4">
                                <input type="date" id="datePicker" class="form-control" name="attendanceDate" />
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div id="dateData">
                    <p> Please select a date </p>
                </div>
            </div>
        </div>
    </div>
<script>
    $("#datePicker").change(function() {
      var date = {'date':$("#datePicker").val()};
      event.preventDefault();
      if($("#datePicker").val() !== ''){
          $.ajax({
              url: 'attendance.php',
              data: date,
              method:'GET',
              success: function(result) {
                  console.log(result);
                  var rArray = JSON.parse(result);
                  var newTables = "";
                  for(var i = 0; i < rArray.length; i++){
                      var secondArray = rArray[i];
                      if (secondArray.length !== 0){
                          newTables += '<table id="boxersTable" class="table table-striped table-hover">'
                          + '<thead> <h3><strong>' + secondArray[0].group + '</strong></h3>'
                          + '<tr><th> Nafn </th><th> M&aelig;tti kl: </th><th> H&oacute;pur </th></tr></thead><tbody>';
                          for(var j = 0; j < secondArray.length; j++){
                              newTables += '<td><a href="user.php?boxerID='+ secondArray[j].id +'">'
                              + '<strong>' + secondArray[j].name + '</strong></a></td>'
                              + '<td>' + secondArray[j].time_logged + '</td><td>' + secondArray[j].group + '</td></tr>';
                          }
                         newTables +='</tbody></table>';
                     }
                     if(newTables.length === 0){
                         newTables += "<p> No one signed in on " + date.date;
                     }
                     document.getElementById('dateData').innerHTML = newTables;
                     document.getElementById('datePickerHeader').innerHTML = "<strong>" + date.date + "</strong>";
                 }
              }
          });
      } else {
          document.getElementById('dateData').innerHTML = "<p> Not a Valid Input</p>";
      }
    });
</script>
<?php
endif; ?>
