<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Schedule extends Admin_Controller {
	private $error = array();
	
	public function __construct(){
      parent::__construct();
		$this->load->model('schedule_model');
		$this->load->model('common/common_model');
		$this->load->model('users/users_model');
		//$this->load->model('templates/templates_model');
	}
	
	public function index(){
      $this->lang->load('schedule');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		//$this->getList(); 
		$data = array();

		// Get the current year (according to the ISO-8601 standard)
		$data['currentYear'] = date("o");
		// Get the current week number (according to the ISO-8601 standard)
		$data['currentWeek'] = (int)date("W");

		$this->template->view('schedules', $data);
	}

	public function getDatesOfWeek($year, $weekNumber) {
		$result = [];
	
		// Create a new DateTime object and set it to the first day of the specified week
		$date = new DateTime();
		$date->setISODate($year, $weekNumber);
		//make it sunday
		$date->modify('-1 day');
	
		// Iterate through the next 7 days to get all dates of the week
		for ($i = 0; $i < 7; $i++) {
			// Add the date to the result array
			$result[] = $date->format('d-M');
	
			// Move to the next day
			$date->add(new DateInterval('P1D'));
		}
	
		return $result;
	}

	public function getDBDatesOfWeek($year, $weekNumber) {
		$result = [];
	
		// Create a new DateTime object and set it to the first day of the specified week
		$date = new DateTime();
		$date->setISODate($year, $weekNumber);
		//make it sunday
		$date->modify('-1 day');
	
		// Iterate through the next 7 days to get all dates of the week
		for ($i = 0; $i < 7; $i++) {
			// Add the date to the result array
			$result[] = $date->format('Y-m-d');
	
			// Move to the next day
			$date->add(new DateInterval('P1D'));
		}
	
		return $result;
	}

	public function loadscheduletable(){
		$html = '';
		$drivers = $this->users_model->getActiveUsers();
		//print_r($drivers);
		// Example usage
		$year = $_POST['year'];
		$weekNumber = $_POST['week'];
		$datesOfWeek = $this->getDatesOfWeek($year, $weekNumber);
		

		$html.= '
		<table id="datatable" class="table table-bordered" width="100%">
		<thead>';

		$html.= '<tr class="fw-bold"><td>#</td><td>NAME</td>';

		for($i=0;$i<count($datesOfWeek);$i++){
			$html.= '<td class="text-center">'.$datesOfWeek[$i].'</td>';
		}

		$html.= '<td>Days</td><td>Action</td></tr>';

		

		$html.= '</thead>
		<tbody>';

		$c = 1;

		foreach($drivers as $d){
			$html .= '<tr><td class="text-center">'.$c++.'</td><td>'.$d->name.'</td>';
			//<td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small" data-bs-toggle="modal" data-bs-target="#pointModal">LATE</span></td>
			$count_working_days = 0;
			for($i=0;$i<count($datesOfWeek);$i++){
				//fetch punch data;
				$punch_data = $this->schedule_model->getPunchData($d->id, $weekNumber, $year, date('m-d', strtotime($datesOfWeek[$i])));
				//print_r($punch_data);
				if(!empty($punch_data)){
					$in_text = '';
					$out_text = '';
					/*
					if(!empty($punch_data->in_time)){
						$in_time = @explode(' ', $punch_data->in_time);
						$in_text = $in_time[1].' '.$in_time[2];
					}

					
					if(!empty($punch_data->out_time)){
						$out_time = @explode(' ', $punch_data->out_time);
						$out_text = $out_time[1].' '.$out_time[2];
					}*/

					//count working days
					if(!empty($punch_data->schedule_code_id) && $punch_data->schedule_code_id > 0){
						if($punch_data->schedule_code_id == 1){
							$count_working_days++;
						}
						//get short code for schedule id
						$code = $this->schedule_model->getShortCodeText($punch_data->schedule_code_id);
						$html.= '<td '.($punch_data->schedule_code_id == 5 ? 'style="background-color:#e7e7e7;"' : '').' class="text-center cursor-pointer position-relative '.(strlen($punch_data->notes) ? 'notes' : '').'" onclick="loadschedulemodal('.$d->id.', '.strtotime($datesOfWeek[$i]).', '.$weekNumber.', '.$year.')">
									'.$code.'
								</td>';
								//<span class="text-primary" style="font-size:11px">'.$in_text.'</span>
								//<br/> 
								//<span class="text-success" style="font-size:11px">'.$out_text.'</span>
					}else{
						//$html.= '<td class="text-center"></td>';
						$html.= '<td class="text-center cursor-pointer position-relative" onclick="loadschedulemodal('.$d->id.', '.strtotime($datesOfWeek[$i]).', '.$weekNumber.', '.$year.')">
									
									
								</td>';
								//<div class="position-absolute top-0 end-0"><i style="font-size:10px" class="las la-info-circle"></i></div>
					}

					
						
					
					
					//<p class="mb-0">1</p><span class="fw-normal small">LATE</span>
				}else{
					$html.= '<td class="text-center">-</td>';
				}
				
			}
			//to use
			//<td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td>
			
			
			//<td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td>
			$html .= '<td>'.$count_working_days.'/7</td>
			<td class="text-center">
			<div class="btn-group1 btn-group-sm1 pull-right1">
			
			<button type="button" class="d-none btn btn-outline-dark"><i class="las la-eye"></i></button>
			<a href="'.admin_url('users/chatroom/'.$d->id).'" class="btn btn-sm btn-outline-dark"><i class="las la-comment"></i></a>
			
			</div></td></tr>';
		}
		
		




		
		$html .= '</tbody>
		</table>
		';

		echo $html;

		/*

		<tr><td>2</td><td>Anthony Michael Reed</td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-danger" style="font-size:11px">20:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td>4</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>
		<tr><td>3</td><td>Marco Antonio Serna</td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td>5</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>
		<tr><td>4</td><td>Nicholas Ryan Hogue</td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td>5</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>
		<tr><td>5</td><td>Andrew David Renteria</td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td>5</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>

		*/
	}

	public function schedulemodalbody(){
		$output = '';
		//fetch driver details
		$driver = $this->users_model->getUser($_POST['driver_id']);
		//$dt = new DateTime($_POST['dt']);
		$dt = date("M d",$_POST['dt']);

		//$output .= '<div class="text-center fs-6 mb-3">Driver Name: <strong>'.$driver->name.'</strong> (Date: '.$dt.' | Week: '.$_POST['week'].' | Year: '.$_POST['year'].')</div>';
		$output .= '
		<div class="d-flex justify-content-between">
			<div class="mb-3"><h5>'.$driver->name.'</h5><div class="small">Date: '.$dt.' | Week: '.$_POST['week'].' | Year: '.$_POST['year'].'</div></div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		';
		

		$output .= '<div class="row g-3">';
		//fetch schedule
		$pd = $this->schedule_model->getSinglePunchData($driver->id, $_POST['dt'], $_POST['week'], $_POST['year']);

		$sc = $this->schedule_model->getScheduleCodes();
		$a_remarks = '<select class="form-select" onchange="updateschedulecode(this.value, '.(!empty($pd) ? $pd->id : 0).', '.$driver->id.', '.$_POST['dt'].', '.$_POST['week'].', '.$_POST['year'].')">';
		$a_remarks .= '<option value="0">-Select-</option>';
		foreach($sc as $s){
			$a_remarks .= '<option value="'.$s->id.'" '.(!empty($pd) && $s->id == $pd->schedule_code_id ? 'selected' : '').'>'.$s->short_code.' - '.$s->description.'</option>';
		}
		$a_remarks .= '</select>';
		$a_remarks .= '<div id="code_status_message" class="text-success small"></div>';

		
		if(!empty($pd)){
			//data exists to show
			$output .= '
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->scheduled_punch_in_time.'" readonly>
					<label>Scheduled Punch-In Time</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->scheduled_punch_out_time.'" readonly>
					<label>Scheduled Punch-Out Time</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->actual_punch_in_time.'" readonly>
					<label>Actual Punch-In Time</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->actual_punch_out_time.'" readonly>
					<label>Actual Punch-Out Time</label>
				</div>
			</div>
			';
		}else{
			//blank table
			$output .= '
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="" readonly>
					<label>Scheduled Punch-In Time</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="" readonly>
					<label>Scheduled Punch-Out Time</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="" readonly>
					<label>Actual Punch-In Time</label>
				</div>
			</div>
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="" readonly>
					<label>Actual Punch-Out Time</label>
				</div>
			</div>
			';
		}

		$output .= '
		<div class="col-12">
			<div class="form-floating">
				'.$a_remarks.'
				<label>Work Status</label>
			</div>
		</div>';

		$output .= '
		<div class="col-12">
			<div class="form-floating">
				<textarea class="form-control" id="notes_schedule" name="notes_schedule" placeholder="">'.(!empty($pd) ? $pd->notes : '').'</textarea>
				<label>Notes</label>
			</div>
			<button type="button" class="btn btn-dark mt-2" onclick="updatenotes('.(!empty($pd) ? $pd->id : 0).', '.$driver->id.', '.$_POST['dt'].', '.$_POST['week'].', '.$_POST['year'].')">Update</button>
			 <div id="note_status_message" class="text-success small"></div>
		</div>';
		

		$output .= '</div>';
		
		/*$output = $accordion = '';
		//fetch driver details
		$driver = $this->users_model->getUser($_POST['driver_id']);

		$output .= '<div class="text-center fs-6 mb-3">Driver Name: <strong>'.$driver->name.'</strong> (Week: '.$_POST['week'].' | Year: '.$_POST['year'].')</div>';
		
		//fetch schedule
		$punch_data = $this->schedule_model->getSinglePunchData($driver->id, $_POST['dt'], $_POST['week'], $_POST['year']);

		$row1 = '
		<tr><th>Driver Name</th><td>'.$driver->name.'</td></tr>
		<tr><th>Date</th><td>'.date('M d, Y', $_POST['dt']).'</td></tr>
		<tr><th>Week</th><td>'.$_POST['week'].'</td></tr>';

		//$row2 = '';

		$accordion_closed = 1;
		$shift = 1;


		

		foreach($punch_data as $pd){
			$row1 = '
			<tr><th>EE Code</th><td>'.$pd->ee_code.'</td></tr>
			<tr><th>Home Department</th><td>'.$pd->home_department.'</td></tr>
			<tr><th>Home Allocation</th><td>'.$pd->home_allocation.'</td></tr>
			<tr><th>Pay Class</th><td>'.$pd->pay_class.'</td></tr>
			<tr><th>Badge</th><td>'.$pd->badge.'</td></tr>
			<tr><th>Punch-In Time</th><td>'.$pd->punch_in_time.'</td></tr>
			<tr><th>Punch-Out Time</th><td>'.$pd->punch_out_time.'</td></tr>
			<tr><th>Allocation</th><td>'.$pd->allocation.'</td></tr>
			<tr><th>Earn Code</th><td>'.$pd->earn_code.'</td></tr>
			<tr><th>Earn Hours</th><td>'.$pd->earn_hours.'</td></tr>
			';

			$row2 = '
			<tr><th>Dollars</th><td>'.$pd->dollars.'</td></tr>
			<tr><th>Employee Approved</th><td>'.$pd->employee_approved.'</td></tr>
			<tr><th>Supervisor Approved</th><td>'.$pd->supervisor_approved.'</td></tr>
			<tr><th>Tax Profile</th><td>'.$pd->tax_profile.'</td></tr>
			<tr><th>Home Department Cesc</th><td>'.$pd->home_department_desc.'</td></tr>
			<tr><th>Home Delivery Station Code Code</th><td>'.$pd->home_delivery_station_code_code.'</td></tr>
			<tr><th>Home Delivery Station Code Desc</th><td>'.$pd->home_delivery_station_code_desc.'</td></tr>
			<tr><th>Dist Department Desc</th><td>'.$pd->dist_department_desc.'</td></tr>
			<tr><th>Dist Delivery Station Code Code</th><td>'.$pd->dist_delivery_station_code_code.'</td></tr>
			<tr><th>Dist Delivery Station Code Desc</th><td>'.$pd->dist_delivery_station_code_desc.'</td></tr>
			<tr><th>Distributed Department Code</th><td>'.$pd->distributed_department_code.'</td></tr>
			';

			$accordion .= '
				<div class="accordion-item">
					<h2 class="accordion-header">
					<button class="accordion-button '.($accordion_closed ? '' : 'collapsed').'" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$shift.'" aria-expanded="true" aria-controls="collapse'.$shift.'">
						Shift #'.$shift.'
					</button>
					</h2>
					<div id="collapse'.$shift.'" class="accordion-collapse collapse '.($accordion_closed ? 'show' : '').'" data-bs-parent="#accordionSchedule">
					<div class="accordion-body">
						
						<div class="row g-0">
							<!-- First Column -->
							<div class="col-md-6">
								<table class="table table-bordered mb-0">
									<tbody>
										'.$row1.'
									</tbody>
								</table>
							</div>
							<!-- Second Column -->
							<div class="col-md-6">
								<table class="table table-bordered mb-0">
									<tbody>
										'.$row2.'
									</tbody>
								</table>
							</div>
						</div>


					</div><!-- accordion body ends -->
					</div>
				</div>

					';

			$shift++;
			$accordion_closed--;
		}

		
		$output .= '
			<div class="accordion" id="accordionSchedule">
				'.$accordion.'
			</div>';*/
		
	

		echo $output;
	}

	public function showsummarymodalbody(){
		$output = '';

		$output .= '<table class="table table-bordered mb-0">';

		$year = $_POST['year'];
		$weekNumber = $_POST['week'];
		$datesOfWeek = $this->getDatesOfWeek($year, $weekNumber);
		$getDBDatesOfWeek = $this->getDBDatesOfWeek($year, $weekNumber);
		

		$output.= '<thead>';

		$output.= '<tr class="fw-bold text-center"><td>#</td>';

		for($i=0;$i<count($datesOfWeek);$i++){
			$output.= '<td>'.$datesOfWeek[$i].'</td>';
		}

		$output.= '</tr>';

		
		
		

		$output.= '</thead>
		<tbody>';

		//calculate all 5 one by one
		$summary_enum_values = array(
			0 =>'Scheduled',
			1 => 'Target DA',
			2 => 'Core Routes',
			3 => 'Other Routes',
			4 => 'Extra/Rescue'
		);

		for($j=0;$j<count($summary_enum_values);$j++){
			$output .= '<tr class="text-center"><td>'.$summary_enum_values[$j].'</td>';
			for($i=0;$i<count($datesOfWeek);$i++){
				$value = $this->schedule_model->getSummaryItemforDay($summary_enum_values[$j], $getDBDatesOfWeek[$i]);
				$output .= '<td>'.$value.'</td>';
			}
			$output .= '</tr>';
		}
		$output .= '</tbody></table>';

		echo $output;
	}

	public function updateschedulecode(){
		$this->schedule_model->updateScheduleCode($_POST['code_id'], $_POST['schedule_id'], $_POST['driver_id'], $_POST['dt'], $_POST['week'], $_POST['year']);
	}

	public function updateschedulenote(){
		$this->schedule_model->updateScheduleNote($_POST['notes'], $_POST['schedule_id'], $_POST['driver_id'], $_POST['dt'], $_POST['week'], $_POST['year']);
	}

	public function publishschedule(){
		$this->schedule_model->publishSchedule($_POST['week'], $_POST['year']);
	}

	public function preview(){
		$schedule_id = 0;
		$f = json_decode($_POST['ls_headers']);
		$total = count($f);

		$response = array();

		//echo $total;die;
		//echo '<pre>';print_r($f[0][2]);
		$starting_date = @$f[0][2];//deliberately supressing the error message
		if(strlen($starting_date)){
			//read date details
			$input = $starting_date;//"'Sunday 2/4";

			// Create DateTime object from the string
			$date = DateTime::createFromFormat("l n/j", $input);

			// Check if the date was parsed correctly
			if ($date) {
				// Set the year to the current year
				$currentYear = date('Y');
				$date->setDate($currentYear, $date->format('n'), $date->format('j'));

				//echo $date->format('Y-m-d H:i:s'); // Output the date in the desired format
				// Array to hold the dates
				$dates = [];

				// Add the parsed date to the array
				$dates[] = $date->format('M d, Y');
			
				// Add dates until next Saturday
				while ($date->format('l') !== 'Saturday') {
					$date->modify('+1 day');
					$dates[] = $date->format('M d, Y');
				}
			
				// Output the dates
				//print_r($dates);
				$weekNumber = $date->format('W');//placing it here will give current week since week starts from monday and this files atrts from sunday
				

				//find for how many drivers, data is present
				$d = json_decode($_POST['ls_values']);

				//echo count($d);
				//print_r($d);
				//start driver loop
				$total_driver_count = 0;
				$scheduled_column = 0;
				for($i=0;$i<count($d);$i++){
					if(!empty($d[$i][0])){
						$total_driver_count++;
					}else{
						//break on first blank encounter
						$scheduled_column = $i;
						break;
					}
				}

				$next = $scheduled_column + 2;//scheduled
				$s_loop = 6;//$d[$scheduled_column+2][0] + 1;$d[$i][$s_loop + 4]
				$value = '';
				for($dl=0;$dl<7;$dl++){
					$value .= $d[$next][$s_loop].',';
					//save code
					/*$data = array(
						'week_number' => ($dl == 0 ? $weekNumber - 1 : $weekNumber),
						'year_number' => $currentYear,
						'scheduled_punch_in_time' => $scheduled_punch_in_time,
						'scheduled_punch_out_time' => $scheduled_punch_out_time,
						'actual_punch_in_time' => $actual_punch_in_time,
						'actual_punch_out_time' => $actual_punch_out_time,
						'schedule_code_id' => $status_code
					);*/
					//$this->
					$s_loop += 5;
				}

				$response['status'] = 1;
				// '.$value.'
				$response['message'] = '
						<p class="fw-bold mb-0">New Schedule detected</p>
						<div class="d-flex justify-content-between text-success">
							<div><i class="las la-calendar-week"></i> Week '.$weekNumber.' ('.$dates[0].' - '.$dates[count($dates) - 1].')</div>
							<div><i class="las la-user-circle"></i> '.$total_driver_count.' Drivers listed</div>
						</div>
				';
				//echo '<div class="alert alert-success">Total drivers found '.$total_driver_count.'</div>';
				
			} else {
				$response['status'] = 0;
				$response['message'] = '<div class="text-danger">Invalid date format</div>';
			}
		}else{
			//invalid header format
			$response['status'] = 0;
			$response['message'] = '<div class="text-danger">Invalid header format</div>';
		}

		echo json_encode($response);
	}


	public function add(){
		$schedule_id = 0;
		$f = json_decode($_POST['ls_headers']);
		$total = count($f);

		$response = array();

		//echo $total;die;
		//echo '<pre>';print_r($f[0][2]);die;
		$starting_date = @$f[0][2];//deliberately supressing the error message
		if(strlen($starting_date)){
			//read date details
			$input = $starting_date;//"'Sunday 2/4";

			// Create DateTime object from the string
			$date = DateTime::createFromFormat("l n/j", $input);

			// Check if the date was parsed correctly
			if ($date) {
				// Set the year to the current year
				$currentYear = date('Y');
				$date->setDate($currentYear, $date->format('n'), $date->format('j'));

				//echo $date->format('Y-m-d H:i:s'); // Output the date in the desired format
				// Array to hold the dates
				$dates = [];

				// Add the parsed date to the array
				$dates[] = $date->format('Y-m-d');
			
				// Add dates until next Saturday
				while ($date->format('l') !== 'Saturday') {
					$date->modify('+1 day');
					$dates[] = $date->format('Y-m-d');
				}
			
				// Output the dates
				//print_r($dates);die;
				$weekNumber = $date->format('W');//placing it here will give current week since week starts from monday and this files atrts from sunday
				//echo $weekNumber;die;

				//find for how many drivers, data is present
				$d = json_decode($_POST['ls_values']);

				//echo count($d);
				//print_r($d);
				//start driver loop
				$total_driver_count = 0;
				$scheduled_column = 0;
				for($i=0;$i<count($d);$i++){
					if(!empty($d[$i][0])){
						$total_driver_count++;
						//IMPORT SCHEDULE HERE
						//first find the driver
						$driver = $this->users_model->getDriverbyFirstLastName($d[$i][0], $d[$i][1]);
						$userid = 0;
						if(empty($driver)){
							//create driver if not exists
							$tmp_driver_data = array(
								"name"=>$d[$i][0].' '.$d[$i][1],
								"password"=>md5(1234),
								"show_password"=>1234,
								"email"=>time().'@tntmail.com',
								"status" => 1,	
								"user_group_id" => 2,
								//"template_file"=>$this->input->post('template_file'),
								"activated" => 1
							);
	
							
							$userid = $this->users_model->addUser($tmp_driver_data);
						}else{
							$userid = $driver->id;
						}
						
						//echo $userid;die;
						
						//loop for 7 times
						$s_loop = 2;
						for($dl=0;$dl<7;$dl++){
							//re-create punch times
							$scheduled_punch_in_time = (!empty($d[$i][$s_loop]) ? $dates[$dl].' '.$d[$i][$s_loop] : '');
							$scheduled_punch_out_time = (!empty($d[$i][$s_loop + 1]) ? $dates[$dl].' '.$d[$i][$s_loop + 1] : '');

							$actual_punch_in_time = (!empty($d[$i][$s_loop + 2]) ? $dates[$dl].' '.$d[$i][$s_loop + 2] : '');
							$actual_punch_out_time = (!empty($d[$i][$s_loop + 3]) ? $dates[$dl].' '.$d[$i][$s_loop + 3] : '');

							//echo $d[$i][6];die;
							/*
							UPT - Unpaid time off
							PTO  - Paid time off
							NCNS - No call no show
							Call Off
							RW - Refused work
							L - Late
							WC - workers comp
							M - Medical 
							*/
							$status_code = 0;
							//echo $d[$i][$s_loop + 4];die;
							//fetch status code
							$status_code = $this->schedule_model->getScheduleStatusCodeforText(@$d[$i][$s_loop + 4]);
							//echo $status_code;

							$no_data_exists = $this->schedule_model->noScheduleExists($userid, $weekNumber, $currentYear, $scheduled_punch_in_time, $scheduled_punch_out_time);

							if($no_data_exists && $userid > 0){
								//add new schedule
								$data = array(
									'driver_id' => $userid,
									'week_number' => $weekNumber,//($dl == 0 ? $weekNumber - 1 : $weekNumber),
									'year_number' => $currentYear,
									'scheduled_punch_in_time' => $scheduled_punch_in_time,
									'scheduled_punch_out_time' => $scheduled_punch_out_time,
									'actual_punch_in_time' => $actual_punch_in_time,
									'actual_punch_out_time' => $actual_punch_out_time,
									'schedule_code_id' => $status_code
								);
								//print_r($data);
								$schedule_id = $this->schedule_model->addSchedule($data);
							}
							
							
							//jump to next day
							$s_loop = $s_loop + 5;
						}
						
						
						

						
						
						
						//echo $scheduled_punch_in_time;die;
						
						//echo $punch_out_time->format('Y-m-d H:i A');die;
						//$no_data_exists = $this->schedule_model->noScheduleExists($userid, $weekNumber, $currentYear, $at[7], $at[8]);

					}else{
						//break on first blank encounter
						$scheduled_column = $i;
						break;
					}
				}

				//rest 5 items scheduled to other import to another table
				$summary_enum_values = array(
					0 =>'Scheduled',
					1 => 'Target DA',
					2 => 'Core Routes',
					3 => 'Other Routes',
					4 => 'Extra/Rescue'
				);
				$sev = 0;

				for($next=$scheduled_column + 2;$next<($scheduled_column + 2)+5;$next++){
					//loop 7 times for each
					$s_loop = 6;//$d[$scheduled_column+2][0] + 1;$d[$i][$s_loop + 4]

					for($dl=0;$dl<7;$dl++){
						$value = (!empty($d[$next][$s_loop]) ? $d[$next][$s_loop] : '');
						//save code
						$data = array(
							'week_number' => $weekNumber,//($dl == 0 ? $weekNumber - 1 : $weekNumber),
							'year_number' => $currentYear,
							'for_date' => $dates[$dl],
							'summary_title' => $summary_enum_values[$sev],
							'summary_value' => $value
						);
						//INSERT INTO `schedule_summary`(`week_number`, `year_number`, `for_date`, `summary_title`, `summary_value`) 
						//VALUES ('1','2024','2024-01-01','0','40');
						$i_s = $this->schedule_model->addScheduleSummary($data);
						$s_loop += 5;
					}//day loop ends

					$sev++;
				}//next loop ends

				//echo 1111;
				


				$response['status'] = 1;
				$response['message'] = '<div class="text-success">Schedule imported</div>';
				//echo '<div class="alert alert-success">Total drivers found '.$total_driver_count.'</div>';
				
			} else {
				$response['status'] = 0;
				$response['message'] = '<div class="text-danger">Invalid date format</div>';
			}
		}else{
			//invalid header format
			$response['status'] = 0;
			$response['message'] = '<div class="text-danger">Invalid header format</div>';
		}

		echo json_encode($response);
	}





	public function add_oldcode(){//based on previous schedule
		$schedule_id = 0;
		$f = json_decode($_POST['ls_headers']);
		$total = count($f);

		//echo $total;die;
		echo '<pre>';print_r($f[0][2]);die;

		//first check formats and correct file
		$tmp_check = (array) $f[0];
		//print_r($tmp_check);die;
		//echo $tmp_check[0];echo count((array) $f[0]);die;
		//echo (count((array) $f[0]) == 23 && $tmp_check[0] == "EECode");die;
		if(count((array) $f[0]) == 23 && array_key_exists("EECode", $tmp_check)){
			for($i=1;$i<$total;$i++){
				$a_at = (array) $f[$i];
				// Convert associative array to indexed array
				$at = array_values($a_at);
	
				//find driver ID
				$driver = $this->users_model->getDriverbyFirstLastName($at[2], $at[1]);
	
				//print_r($at);die;
	
				if(!empty($driver)){
					$in_time = new DateTime($at[7]);
					$weekNumber = (int)$in_time->format('W');
					$yearNumber = $in_time->format('o');
					//check if exists
					$no_data_exists = $this->schedule_model->noScheduleExists($driver->id, $weekNumber, $yearNumber, $at[7], $at[8]);
	
					//echo $driver->id.'-'.$weekNumber.'-'.$yearNumber;
					if($no_data_exists && $driver->id > 0){
	
						
	
						
						$data = array(
							'driver_id' => $driver->id,
							'week_number' => $weekNumber,
							'year_number' => $yearNumber,
							'ee_code' => $at[0],
							'home_department' => $at[3],
							'home_allocation' => $at[4],
							'pay_class' => $at[5],
							'badge' => $at[6],
							'punch_in_time' => $at[7],
							'punch_out_time' => $at[8],
	
							'allocation' => $at[9],
							'earn_code' => $at[10],
							'earn_hours' => $at[11],
							'dollars' => $at[12],
							'employee_approved' => $at[13],
							'supervisor_approved' => $at[14],
							'tax_profile' => $at[15],
							'home_department_desc' => $at[16],
							'home_delivery_station_code_code' => $at[17],
							'home_delivery_station_code_desc' => $at[18],
							'dist_department_desc' => $at[19],
							'dist_delivery_station_code_code' => $at[20],
							'dist_delivery_station_code_desc' => $at[21],
							'distributed_department_code' => $at[22]
						);
						//print_r($data);die;
						$schedule_id = $this->schedule_model->addSchedule($data);
					}else{
						$_SESSION['message'] = '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Data already exists</div>';
					}
	
					
				}//if(!empty($driver)){ ends
				
			}//for ends
		}else{//if file valid check ends
			$_SESSION['message'] = '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Invalid format. File upload failed.</div>';
		}//else file valid check ends
		

		if($schedule_id > 0){
			$_SESSION['message'] = '<div class="alert alert-success text-white mb-2" role="alert"><strong>Success!</strong> Schedule uploaded successfully</div>';
		}

		echo admin_url('schedule');
	}
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */