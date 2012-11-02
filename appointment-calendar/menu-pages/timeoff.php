<!--date-picker css -->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/datepicker-assets/css/jquery-ui-1.8.23.custom.css', __FILE__); ?>' />

<!-----bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap.min.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.min.css', __FILE__); ?>' />
<div class="bs-docs-example tooltip-demo">

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3><?php _e('Time Off','appointzilla','appointzilla'); ?></h3> 
</div>
<form name="timeoff" id="timeoff" method="post" action="" >
<table width="100%" border="0" class="table">
  <tr>
    <th scope="col"><?php _e('No.','appointzilla'); ?></th>
    <th scope="col"><?php _e('Name','appointzilla'); ?></th>
    <th scope="col"><?php _e('Date','appointzilla'); ?></th>
    <th scope="col"><?php _e('Time','appointzilla'); ?></th>
    <th scope="col"><?php _e('Repeat','appointzilla'); ?></th>
    <th scope="col"><?php _e('Status','appointzilla'); ?></th>
    <th scope="col"><?php _e('Action','appointzilla'); ?></th>
    <th scope="col"><a rel="tooltip" title="<?php _e('Select All','appointzilla'); ?>"><input type="checkbox" id="checkbox" name="checkbox[]" value="checkbox" /></a></th>
  </tr>
  <?php
  		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$FindAllevents = "SELECT * FROM `$EeventTable` ORDER BY `start_date` DESC";
		$AllEvents = $wpdb->get_results($FindAllevents, OBJECT);
		$no = 1; 
		if($AllEvents)
		{
			foreach($AllEvents as $Event)
			{
  ?>
  <tr>
    <td><em><?php echo $no.".";  ?></em></td>
    <td><em><?php echo $Event->name; ?></em></td>
    <td><em><?php if($Event->repeat == 'N') echo date("F jS Y", strtotime($Event->start_date)) ; else echo date("M. jS", strtotime($Event->start_date))." To ".date("M. jS Y", strtotime($Event->end_date)); ?></em></td>
    <td><em><?php echo date("g:ia", strtotime($Event->start_time))." To ".date("g:ia", strtotime($Event->end_time)); ?></em></td>
    <td>
	  <em>
	  <?php
	  		if($Event->repeat == 'N' && !$Event->allday)
					{ 
						//$diff = ( strtotime($Event->end_date) - strtotime($Event->start_date)  ) /60/60/24; 
						echo "None";
					}
					if($Event->repeat == 'PD')
					{ 
						//$diff = ( strtotime($Event->end_date) - strtotime($Event->start_date)  ) /60/60/24; 
						echo "Particular Date(s)";
					}
					if($Event->repeat == 'D')
					{ 	echo "Daily"; }
					if($Event->repeat == 'W')
					{ 
						//$diff = ( strtotime($Event->end_date) - strtotime($Event->start_date)  ) /60/60/24/7;
						//$diff = $diff + 1;
						echo "Weekly";
					}
					if($Event->repeat == 'M')
					{ 
						$diff = ( strtotime($Event->end_date) - strtotime($Event->start_date)  ) /60/60/24/31; 
						//echo ceil($diff)." Month(s)";
						echo "Monthly";
					}
					if($Event->allday)
					{ 
						echo "All Day Event";
					}
				?>
      </em> </td>
    <td>
	  <em>
	  <?php 
	  		if($Event->repeat != 'N')
			{
				if(strtotime("$Event->end_date") < strtotime(date('Y-m-d')))
				{
			   		echo "Gone";
				}
		if( strtotime("$Event->start_date") <= strtotime(date('Y-m-d')) && strtotime("$Event->end_date") >= strtotime(date('Y-m-d')))
				{
					echo "Running";
				}
				if(strtotime("$Event->start_date") > strtotime(date('Y-m-d')))
				{
			   		echo "Up-Comming";
				}
			}
			else if($Event->repeat == 'N')
			{
				if(strtotime("$Event->end_date") < strtotime(date('Y-m-d')))
				{
			   		echo "Gone";
				}
		if( strtotime("$Event->start_date") <= strtotime(date('Y-m-d')) && strtotime("$Event->end_date") >= strtotime(date('Y-m-d')))
				{
					echo "Running";
				}
				if(strtotime("$Event->start_date") > strtotime(date('Y-m-d')))
				{
			   		echo "Up-Comming";
				}
			}
	  ?>
      </em> 
	</td>
    <td>
		<a href="?page=update-timeoff&update_timeoff=<?php echo $Event->id; ?>" title="<?php _e('Update','appointzilla'); ?>" rel="tooltip"><i class="icon-pencil"></i></a>&nbsp;
		<a href="?page=timeoff&delete_timeoff=<?php echo $Event->id; ?>" title="<?php _e('Delete','appointzilla'); ?>" onclick="return confirm('<?php _e('Do you want to delete this time off.','appointzilla');?>')" rel="tooltip"><i class="icon-remove"></i></td>
    <td><a rel="tooltip" title="<?php _e('Select','appointzilla'); ?>"><input type="checkbox" id="checkbox[]" name="checkbox[]" value="<?php echo $Event->id; ?>" /></a></td>
  </tr>
  <?php
  			$no++;
  			} // foreach
  		} // if
  ?>
  <tr>
    <td colspan="2"><button name="addnewtimeoff" id="addnewtimeoff" class="btn btn-primary" type="button" ><?php _e('Add New Time Off','appointzilla'); ?></button></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   <td><button name="deleteall" class="btn btn-primary" type="submit" id="deleteall" onclick="return confirm('<?php _e('Do you want to delete all Time Off','appointzilla'); ?>')" ><?php _e('Delete','appointzilla'); ?></button></td>
  </tr>
</table>
</form>

<style type='text/css'>

.error{ 
	color:#FF0000; 
}

.modal{
	top: 40%;
}
.modal-body {
	max-height: 535px;
}

</style>

<!--------TimeOff For Add New TimeOff-->
<div id="TimeOffModal" style="display:none;">

	<div class="modal" id="myModal">
	<form action="" method="post" name="AddNewTimeOff-From" id="AddNewTimeOff-From">
		<div class="modal-info">
			<div class="alert alert-info"><h4><?php _e('Add New Time Off','appointzilla'); ?></h4></div>
		</div>
		<div class="modal-body">
			<table width="100%" class="table">
			  <tr>
				<th scope="row"><?php _e('All Day Time Off','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="allday" id="allday" type="checkbox" value="1" /><!--
				&nbsp;<a href="#" rel="tooltip" title="All Day Time Off." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('Name','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="name" id="name" type="text" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Name." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('Start Time','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="start_time" id="start_time" type="text" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Time." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('End Time','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="end_time" id="end_time" type="text" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off End Time." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="event_date_tr">
				<th scope="row"><?php _e('Date','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="event_date" id="event_date" type="text" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('Repeat','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><select name="repeat" id="repeat">
						<option onclick="hideAll()" value="N"><?php _e('No','appointzilla'); ?></option>
						<option onclick="showPD()" value="PD"><?php _e('Particular Date(s)','appointzilla'); ?></option>
						<option onclick="showDaily()" value="D"><?php _e('Daily','appointzilla'); ?></option>
						<option onclick="showWeekly()" value="W"><?php _e('Weekly','appointzilla'); ?></option>
						<option onclick="showMonthly()" value="M"><?php _e('Monthly','appointzilla'); ?></option>
					</select>
					<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Repeat Days." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="re_days_tr" style="display:none;">
				<th scope="row"><?php _e('Repeat Day(s)','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="re_days" id="re_days" type="text"  maxlength="2"/>
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="re_weeks_tr" style="display:none;">
				<th scope="row"><?php _e('Repeat Week(s)','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="re_weeks" id="re_weeks" type="text"  maxlength="2"/>
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
  			  <tr id="re_months_tr" style="display:none;">
				<th scope="row"><?php _e('Repeat Month(s)','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="re_months" id="re_months" type="text"  maxlength="2"/>
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="start_date_tr" style="display:none;">
				<th scope="row"><?php _e('Start Date','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="start_date" id="start_date" type="text" maxlength="2"/>
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="end_date_tr" style="display:none;">
				<th scope="row"><?php _e('End Date','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="end_date" id="end_date" type="text" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off End Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('Note','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><textarea name="note" id="note"></textarea>
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Note." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr>
				<th scope="row">&nbsp;</th>
				<td>&nbsp;</td>
				<td><a href="#"class="btn btn-primary" id="close"><?php _e('Close','appointzilla'); ?></a>
				<button name="create" id="create" class="btn btn-primary" type="submit"><?php _e('Create Time Off','appointzilla'); ?></button></td>
				
			  </tr>
			</table>
	  </div>
		</div>
	</form>
	
</div>
</div>


<!------Insert Time-off in db -------->
<?php 
	if(isset($_POST['create']))
	{
	
		if($_POST['allday'])	// all day event
		{
			$allday = 1;
			$start_time = '12:00 AM';
			$end_time = '11:59 PM';
		}
		else
		{
			$allday = 0;
			$start_time = $_POST['start_time'];
			$end_time = $_POST['end_time'];
		}
		$name = $_POST['name'];
			
		$repeat = $_POST['repeat'];
		$start_date = $_POST['event_date'];
		$start_date = date("Y-m-d", strtotime($start_date)); //convert format
		
		
			
		//not repaet
		if($repeat == 'N')
		{
			$end_date =  date("Y-m-d", strtotime($start_date)); //convert format
		}
		
		//purticularday
		if($repeat == 'PD')
		{
			$end_date = $_POST['end_date'];
			$end_date =  date("Y-m-d", strtotime($end_date)); //convert format
		}
		
		//daily event will be  90 days
		if($repeat == 'D')
		{
			$repeat_days = $_POST['re_days'];
			$repeat_days = $repeat_days - 1;
			$end_date = strtotime($start_date); 
			$end_date = date("Y-m-d", strtotime("+$repeat_days days", $end_date)); 	//add 3 month 
		}
		//weekly event add 1 week
		if($repeat == 'W')
		{
			$repeat_weeks = $_POST['re_weeks'];
			$end_date = strtotime($start_date); 
			$end_date = date("Y-m-d", strtotime("+$repeat_weeks week", $end_date)); 	//add 1 week
		}
		//monthly event add 1 month
		if($repeat == 'M')
		{
			$repeat_months = $_POST['re_months'] + 1;
			$end_date = strtotime($start_date); 
			$end_date = date("Y-m-d", strtotime("+$repeat_months months", $end_date)); 	//add 1 month 
		}
		$note = $_POST['note'];
		
		$status = "";
		
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$eventinsert_sql = "INSERT INTO `$EeventTable` ( `id` , `name` , `allday` , `start_time` , `end_time` , `repeat` ,
			`start_date` , `end_date` , `note` , `status` ) VALUES (
			NULL , '$name', '$allday', '$start_time', '$end_time', '$repeat', '$start_date', '$end_date', '$note', '$status');";
			
		if($wpdb->query($eventinsert_sql))
		{
			echo "<script>alert('".__('Time-off successfully added.','appointzilla')."')</script>";
			echo "<script>location.href='?page=timeoff';</script>";
		}
	}
?>


<!--------Delete time off single row------------>
<?php 
	if(isset($_GET['delete_timeoff']))
	{
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$del_id = $_GET['delete_timeoff'];
		$timeoffdelete_sql = "delete from `$EeventTable` where `id` = '$del_id'";
		if($wpdb->query($timeoffdelete_sql))
		{
			echo "<script>alert('".__('Time-off successfully deleted.','appointzilla')."')</script>";
			echo "<script>location.href='?page=timeoff';</script>";
		}
		else
			echo "<script>location.href='?page=timeoff';</script>";
	}

?>

<?php 		
// Delete Multiple time-off
if(isset($_POST['deleteall']))
{
 	$table_name = $wpdb->prefix . "ap_events";
  	for($i=0;$i<=count($_POST['checkbox'])-1;$i++)
  	{
		$res=$_POST['checkbox'][$i];
		$deleteid= $res;
		$delete_app_query="DELETE FROM `$table_name` WHERE `id` = '$deleteid';";
		$wpdb->query($delete_app_query); 
	}
		if(count($_POST['checkbox']))
		{
			echo "<script>alert('".__('Selected Time-off successfully deleted.','appointzilla')."')</script>";
		}
		else
		{
			echo "<script>alert('".__('No time-off selected to delete.','appointzilla')."')</script>";
		}
		echo "<script>location.href='?page=timeoff';</script>";	
}
?>

<!--validation js lib-->

<script src="<?php echo plugins_url('/js/jquery.min.js', __FILE__); ?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {
	
	//select all checkbox for multiple delete
	$('#checkbox').click(function(){
		if($('#checkbox').is(':checked'))
		{
			$(":checkbox").prop("checked", true);
		}
		else
		{
			$(":checkbox").prop("checked", false);
		}
	});
		
		


		<!-------------Launch Modal Form-------------------->
		//hide modal
		$('#close').click(function(){
			
			$('#TimeOffModal').hide();
		});
		
		//show modal
		$('#addnewtimeoff').click(function(){
			$('#TimeOffModal').show();
		});
		
		
	
		
	<!------------------Validation---------------------->
		
	//when load for update time-off
	if ($('#allday').is(':checked'))
	{
		$('#start_time').attr("disabled", true);
		$('#end_time').attr("disabled", true);
	}

	//repeat
	var repeat = $("#repeat").val();
	
	if (repeat == 'N')
	{
		$('#start_date_tr').hide();
		$('#end_date_tr').hide();
		$('#re_days_tr').hide();
		$('#re_weeks_tr').hide();
		$('#re_months_tr').hide();
		$('#event_date_tr').show();
	}

	if (repeat == 'PD')
	{
		$('#start_date_tr').show();
		$('#end_date_tr').show();
		$('#re_days_tr').hide();
		$('#re_weeks_tr').hide();
		$('#re_months_tr').hide();
		$('#event_date_tr').hide();
	}
	
	if (repeat == 'D')
	{
		$('#start_date_tr').hide();
		$('#end_date_tr').hide();
		$('#re_days_tr').show();
		$('#re_weeks_tr').hide();
		$('#re_months_tr').hide();
		$('#event_date_tr').hide();

	}
	
	if (repeat == 'W')
	{
		$('#start_date_tr').hide();
		$('#end_date_tr').hide();
		$('#re_days_tr').hide();
		$('#re_weeks_tr').show();
		$('#re_months_tr').hide();
		$('#event_date_tr').hide();
	}
	
	if (repeat == 'M')
	{
		$('#start_date_tr').hide();
		$('#end_date_tr').hide();
		$('#re_days_tr').hide();
		$('#re_weeks_tr').hide();
		$('#re_months_tr').show();
		$('#event_date_tr').hide();
	}

	
	// all day event check
	$('#allday').click(function(){
		if ($(this).is(':checked'))
		{
			//$('#name').attr("disabled", true);
			// hasName = 1;
			$('#start_time').attr("disabled", true);
			 hasST = 1;
			$('#end_time').attr("disabled", true);
			 hasET = 1;
		} else {
			$('#start_time').attr("disabled", false);
			 hasST = 0;
			$('#end_time').attr("disabled", false);
			 hasET = 0;
		}
	});
	
	
	/*************************ON-FORM SUBMIT********************************/
	
	// start/end times and dates
	$('#create').click(function() {

		$(".error").hide();
		
		//name
		var nameVal = $("#name").val();
		if(nameVal == ''){
			$("#name").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
			return false;
		}
		
		//if allday is not checked then check start/ent time required
		if (!$('#allday').is(':checked'))
		{
			//start time
			var start_time = $("#start_time").val();
			if(start_time == ''){
				$("#start_time").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			} 
			
			//end time
			var end_time = $("#end_time").val();
			if(end_time == ''){
				$("#end_time").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			}
			
			
			if(start_time == end_time) {
				$("#start_time").after('<span class="error"><br><strong><?php _e("Start-time and End-time cant be equal.",'appointzilla'); ?></strong></span>');
				$("#end_time").after('<span class="error"><br><strong><?php _e("Start-time and End-time cant be equal.",'appointzilla'); ?></strong></span>');
				return false;
			}
			
			console.log(Date.parse("1-1-2000 " + start_time) + " " + Date.parse("1-1-2000 " + end_time));
			start_time = Date.parse("1-1-2000 " + start_time);
			end_time = Date.parse("1-1-2000 " + end_time);
			
			if(start_time > end_time) {
				
				$("#start_time").after('<span class="error"><br><strong><?php _e("Start-time must be smaller then End-time.",'appointzilla'); ?></strong></span>');
				$("#end_time").after('<span class="error"><br><strong><?php _e("End-time must be bigger then Start-time.",'appointzilla'); ?></strong></span>');
				return false;
			}
		}
	
		 
		
		//repeat
		var repeat = $("#repeat").val();
		
		// PURTICULAR DATES
		if(repeat == 'PD'){
			var start_date = $("#start_date").val();
			if(start_date == '')
			{
				$("#start_date").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			}
			var end_date = $("#end_date").val();
			if(end_date == '')
			{
				$("#end_date").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			}
		}
		
		//DAILY
		if(repeat == 'D'){
		
			var re_days = $("#re_days").val();
			if(re_days == '')
			{
				$("#re_days").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			}
		}
		
		//WEEKLY
		if(repeat == 'W'){
		
			var re_weeks = $("#re_weeks").val();
			if(re_weeks == '')
			{
				$("#re_weeks").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			}
		}
		
		//MONTHLY
		if(repeat == 'M'){
		
			var re_months = $("#re_months").val();
			if(re_months == '')
			{
				$("#re_months").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			}
		}
		
		//date
		var event_date = $("#event_date").val();
		if(repeat != 'PD'){
		
			if(event_date == ''){
				$("#event_date").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
				return false;
			}
		}
	
	});
		
	
		
});


$(function(){
		
	<!---------------load date and time picker ------------------>
	$('#start_time').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT',
		stepMinute: 5,
	});
		
	$('#end_time').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT',
		stepMinute: 5,
	});
		
	$('#start_date').datepicker({
		minDate: 0,
		dateFormat: 'dd-mm-yy',
	});
		
	$('#end_date').datepicker({
		dateFormat: 'dd-mm-yy',
		minDate: 0,
	});
		
	$('#event_date').datepicker({
		dateFormat: 'dd-mm-yy',
		minDate: 0,
	});

});

function hideAll()
{
	$('#start_date_tr').hide();
	$('#end_date_tr').hide();
	$('#re_days_tr').hide();
	$('#re_weeks_tr').hide();
	$('#re_months_tr').hide();
	$('#event_date_tr').show();
}

function showPD()
{
	$('#start_date_tr').show();
	$('#end_date_tr').show();
	$('#re_days_tr').hide();
	$('#re_weeks_tr').hide();
	$('#re_months_tr').hide();
	$('#event_date_tr').hide();
}

function showWeekly()
{
	$('#start_date_tr').hide();
	$('#end_date_tr').hide();
	$('#re_days_tr').hide();
	$('#re_weeks_tr').show();
	$('#re_months_tr').hide();
	$('#event_date_tr').show();
}

function showMonthly()
{
	$('#start_date_tr').hide();
	$('#end_date_tr').hide();
	$('#re_days_tr').hide();
	$('#re_weeks_tr').hide();
	$('#re_months_tr').show();
	$('#event_date_tr').show();
}

function showDaily()
{
	$('#start_date_tr').hide();
	$('#end_date_tr').hide();
	$('#re_days_tr').show();
	$('#re_weeks_tr').hide();
	$('#re_months_tr').hide();
	$('#event_date_tr').show();
}

</script>

<!--time-picker js -->
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-1.7.2.min.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-ui.min.js', __FILE__); ?>" type="text/javascript"></script>
<script src="<?php echo plugins_url('/timepicker-assets/js/jquery-ui-timepicker-addon.js', __FILE__); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo plugins_url('js/date.js', __FILE__); ?>"></script>

<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
</div>
