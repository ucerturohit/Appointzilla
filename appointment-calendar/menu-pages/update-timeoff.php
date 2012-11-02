<!--date-picker css -->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/datepicker-assets/css/jquery-ui-1.8.23.custom.css', __FILE__); ?>' />

<!-----bootstrap css----->
<link rel='stylesheet' type='text/css' href='<?php echo plugins_url('/bootstrap-assets/css/bootstrap.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap.min.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.css', __FILE__); ?>' />
<link rel='stylesheet' type='text/css' href='<?php //echo plugins_url('/bootstrap-assets/css/bootstrap-responsive.min.css', __FILE__); ?>' />

<div style="background:#C3D9FF; margin-bottom:10px; padding-left:10px;">
  <h3><?php _e('Update Time Off','appointzilla'); ?></h3> 
</div>

<!--load timeoff modal for update -->

<?php 
	if(isset($_GET['update_timeoff']))
	{
		
		$update_id = $_GET['update_timeoff'];
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$timeoff_sql = "select * from `$EeventTable` where `id` = '$update_id'";
		$TimeOffData = $wpdb->get_row($timeoff_sql, OBJECT);
	?>
	<form action="" method="post" name="AddNewTimeOff-From" id="AddNewTimeOff-From">
			<input name="update_id" id="update_id" type="hidden" value="<?php echo $update_id; ?>" />
			<input name="fromback" id="fromback" type="hidden" value="<?php echo $_GET['from']; ?>" />
			<table width="100%" class="table">
			  <tr>
				<th width="21%" scope="row"><?php _e('All Day Time Off','appointzilla'); ?></th>
				<td width="4%"><strong>:</strong></td>
				<td width="75%"><input name="allday" id="allday" type="checkbox" value="1" <?php if($TimeOffData->allday) echo "checked=checked"; ?> /></td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('Name','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="name" id="name" type="text" value="<?php echo $TimeOffData->name; ?>" /></td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('Start Time','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="start_time" id="start_time" type="text" value="<?php if(!$TimeOffData->allday) echo $TimeOffData->start_time; ?>" /></td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('End Time','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="end_time" id="end_time" type="text" value="<?php if($TimeOffData->allday == 0) echo $TimeOffData->end_time; ?>" /></td>
			  </tr>
			   <tr id="event_date_tr" style="display:<?php if($TimeOffData->repeat == 'PD') echo "none"; else echo ""; ?> ">
				<th scope="row"><?php _e('Date','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="event_date" id="event_date" type="text"  value="<?php echo $TimeOffData->start_date; ?>" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  
			  <tr>
				<th scope="row"><?php _e('Repeat','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><select name="repeat" id="repeat">
						<option onclick="hideAll()" value="N" <?php if($TimeOffData->repeat == 'N') echo "selected=selected"; ?> ><?php _e('No','appointzilla'); ?></option>
						<option onclick="showPD()" value="PD" <?php if($TimeOffData->repeat == 'PD') echo "selected=selected"; ?> ><?php _e('Particular Date(s)','appointzilla'); ?></option>
						<option onclick="showDaily()" value="D" <?php if($TimeOffData->repeat == 'D') echo "selected=selected"; ?> ><?php _e('Daily','appointzilla'); ?></option>
						<option onclick="showWeekly()" value="W" <?php if($TimeOffData->repeat == 'W') echo "selected=selected"; ?> ><?php _e('Weekly','appointzilla'); ?></option>
						<option onclick="showMonthly()" value="M" <?php if($TimeOffData->repeat == 'M') echo "selected=selected"; ?> ><?php _e('Monthly','appointzilla'); ?></option>
					</select>
				</td>
			  </tr>
			  <tr id="re_days_tr" style="display:none;">
				<th scope="row"><?php _e('Repeat Day(s)','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<?php
					if($TimeOffData->repeat == 'PD' || $TimeOffData->repeat == 'D' )
					{ 
						$diff = ( strtotime($TimeOffData->end_date) - strtotime($TimeOffData->start_date)  ) /60/60/24; 
						$diff = $diff + 1;
					}
					if($TimeOffData->repeat == 'W')
					{ 
						$diff = ( strtotime($TimeOffData->end_date) - strtotime($TimeOffData->start_date)  ) /60/60/24/7;
						$diff = $diff + 1;
					}
					if($TimeOffData->repeat == 'M')
					{ 
						$diff = ( strtotime($TimeOffData->end_date) - strtotime($TimeOffData->start_date)  ) /60/60/24/31; 
					}
				?>
				<td><input name="re_days" id="re_days" type="text" value="<?php echo $diff; ?>" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="re_weeks_tr" style="display:none;">
				<th scope="row"><?php _e('Repeat Weeks(s)','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="re_weeks" id="re_weeks" type="text" value="<?php echo $diff; ?>" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
  			  <tr id="re_months_tr" style="display:none;">
				<th scope="row"><?php _e('Repeat Month(s)','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="re_months" id="re_months" type="text" value="<?php echo ceil($diff); ?>" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="start_date_tr" style="display:none;">
				<th scope="row"><?php _e('Start Date','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="start_date" id="start_date" type="text" value="<?php echo $TimeOffData->start_date; ?>" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off Start Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr id="end_date_tr" style="display:none;">
				<th scope="row"><?php _e('End Date','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><input name="end_date" id="end_date" type="text" value="<?php if($TimeOffData->repeat == 'PD')echo $TimeOffData->end_date; ?>" />
				<!--&nbsp;<a href="#" rel="tooltip" title="Time Off End Date." ><i  class="icon-question-sign"></i> </a>-->
				</td>
			  </tr>
			  <tr>
				<th scope="row"><?php _e('Note','appointzilla'); ?></th>
				<td><strong>:</strong></td>
				<td><textarea name="note" id="note"><?php echo $TimeOffData->note; ?></textarea></td>
			  </tr>
			  <tr>
				<th scope="row">&nbsp;</th>
				<td>&nbsp;</td>
				<td><button name="create" id="create" class="btn btn-primary" type="submit"><?php _e('Update','appointzilla'); ?></button>
				<a href="?page=timeoff" class="btn btn-primary"><?php _e('Cancel','appointzilla'); ?></a>
				</td>
			  </tr>
			</table>
	</form>
		<?php
	}
?>

<style type='text/css'>
.error{ 
	color:#FF0000; 
}
</style>

<!------Insert/update Time-off in db -------->
<?php 
	if(isset($_POST['create']))
	{
		$update_id = $_POST['update_id'];
		$fromback = $_POST['fromback'];
		
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
			$start_date = $_POST['start_date'];
			$start_date = date("Y-m-d", strtotime($start_date)); //convert format
			
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
		
		$status = "Up-Comming";
		
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$event_update_sql = "UPDATE `$EeventTable` SET `name` = '$name',
												`allday` = '$allday',
												`start_time` = '$start_time',
												`end_time` = '$end_time',
												`repeat` = '$repeat',
												`start_date` = '$start_date',
												`end_date` = '$end_date',
												`note` = '$note',
												`status`= '$status' WHERE `id` ='$update_id';";
		if($wpdb->query($event_update_sql))
		{
			
		}
		
		if($fromback)
		{
			echo "<script>alert('".__('Time-off successfully updated.','appointzilla')."')</script>";
			echo "<script>location.href='?page=appointment-calendar';</script>";
		}
		else
		{
			echo "<script>alert('".__('Time-off successfully updated.','appointzilla')."')</script>";
			echo "<script>location.href='?page=timeoff';</script>";
		}
		
	}
?>


<!--------Delete single time off------------>
<?php 
	if(isset($_GET['delete_timeoff']))
	{
		global $wpdb;
		$EeventTable = $wpdb->prefix."ap_events";
		$del_id = $_GET['delete_timeoff'];
		$timeoffdelete_sql = "delete from `$EeventTable` where `id` = '$del_id'";
		if($wpdb->query($timeoffdelete_sql))
		{
			echo "<script>alert('".__('Time Off deleted successfully.','appointzilla')."')</script>";
			echo "<script>location.href='?page=timeoff';</script>";
		}
		else
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
		$('#event_date_tr').show();
		$('#start_date_tr').hide();
		$('#end_date_tr').hide();
		$('#re_days_tr').show();
		$('#re_weeks_tr').hide();
		$('#re_months_tr').hide();
		

	}
	
	if (repeat == 'W')
	{
		$('#start_date_tr').hide();
		$('#end_date_tr').hide();
		$('#re_days_tr').hide();
		$('#re_weeks_tr').show();
		$('#re_months_tr').hide();
		$('#event_date_tr').show();
	}
	
	if (repeat == 'M')
	{
		$('#start_date_tr').hide();
		$('#end_date_tr').hide();
		$('#re_days_tr').hide();
		$('#re_weeks_tr').hide();
		$('#re_months_tr').show();
		$('#event_date_tr').show();
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
		}
	
		 
		
		//date
		var event_date = $("#event_date").val();
		if(event_date == ''){
			$("#event_date").after('<span class="error"><br><strong><?php _e('This field required.','appointzilla'); ?></strong></span>');
			return false;
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
<!---Tooltip js ---------->
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-tooltip.js', __FILE__); ?>" type="text/javascript"></script>
	<script src="<?php echo plugins_url('/bootstrap-assets/js/bootstrap-affix.js', __FILE__); ?>" type="text/javascript"></script>
    <script src="<?php echo plugins_url('/bootstrap-assets/js/application.js', __FILE__); ?>" type="text/javascript"></script>
