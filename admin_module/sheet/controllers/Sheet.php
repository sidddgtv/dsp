<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sheet extends Admin_Controller {
	private $error = array();
	
	public function __construct(){
      parent::__construct();
		$this->load->model('sheet_model');
		$this->load->model('common/common_model');
		$this->load->model('users/users_model');
		//$this->load->model('templates/templates_model');
	}
	
	public function index(){
      $this->lang->load('sheet');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		//$this->getList(); 
		$data = array();

		// Get the current year (according to the ISO-8601 standard)
		$data['currentYear'] = date("o");
		// Get the current week number (according to the ISO-8601 standard)
		$data['currentWeek'] = (int)date("W");

		$this->template->view('sheets', $data);
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

	public function loadsheettable(){
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

		if(empty($drivers)){
			$html .= '<tr><td class="text-center" colspan="10">No Data to show</td></tr>';
		}

		foreach($drivers as $d){
			$html .= '<tr><td class="text-center">'.$c++.'</td><td>'.$d->name.'</td>';
			//<td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small" data-bs-toggle="modal" data-bs-target="#pointModal">LATE</span></td>
			$count_working_days = 0;
			for($i=0;$i<count($datesOfWeek);$i++){
				//fetch punch data;
				$punch_data = $this->sheet_model->getPunchData($d->id, $weekNumber, $year, date('Y-m-d', strtotime($datesOfWeek[$i].'-'.$year)));
				//print_r($punch_data);
				if(!empty($punch_data)){
					$count_working_days++;
					$html.= '<td class="text-center cursor-pointer position-relative" onclick="loadsheetmodal('.$d->id.', '.strtotime($datesOfWeek[$i].'-'.$year).', '.$weekNumber.', '.$year.')">
									<i class="las la-check-circle text-success"></i>
								</td>';
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

	public function sheetmodalbody(){
		$output = '';
		//fetch driver details
		$driver = $this->users_model->getUser($_POST['driver_id']);
		$dt = date('Y-m-d', $_POST['dt']);
		$output_dt = new DateTime($dt);

		//$output .= '<div class="text-center fs-6 mb-3">Driver Name: <strong>'.$driver->name.'</strong> (Date: '.$dt.' | Week: '.$_POST['week'].' | Year: '.$_POST['year'].')</div>';
		$output .= '
		<div class="d-flex justify-content-between">
			<div class="mb-3"><h5>'.$driver->name.'</h5><div class="small">Date: '.$output_dt->format('M d, Y').' | Week: '.$_POST['week'].' | Year: '.$_POST['year'].'</div></div>
			<button type="button" class="btn btn-none" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times-circle"></i></button>
		</div>
		';
		

		$output .= '<div class="row g-3">';
		//fetch sheet
		$pd = $this->sheet_model->getSinglePunchData($driver->id, $dt, $_POST['week'], $_POST['year']);
	
		if(!empty($pd)){
			//data exists to show
			$output .= '
			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->wave.'" readonly>
					<label>Wave</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->route.'" readonly>
					<label>Route</label>
				</div>
			</div>

			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->stops.'" readonly>
					<label>Stops</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->packages.'" readonly>
					<label>Packages</label>
				</div>
			</div>

			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->staging_zone.'" readonly>
					<label>Staging Zone</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->service_type.'" readonly>
					<label>Service Type</label>
				</div>
			</div>

			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->van_id.'" readonly>
					<label>Van ID</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->device_id.'" readonly>
					<label>Device ID</label>
				</div>
			</div>

			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->service_condition.'" readonly>
					<label>Condition</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->declined_to_rescue.'" readonly>
					<label>Declined to Rescue</label>
				</div>
			</div>

			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->rescued.'" readonly>
					<label>Rescued</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->out_time.'" readonly>
					<label>Out Time</label>
				</div>
			</div>

			<div class="col-6">
				<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->miles.'" readonly>
					<label>Miles</label>
				</div>
			</div>
			<div class="col-6">
					<div class="form-floating">
					<input type="text" class="form-control" value="'.$pd->gas.'" readonly>
					<label>Gas</label>
				</div>
			</div>

			';
		}else{
			//blank table
			$output .= '
			<div class="col-12">
			No data to show
			</div>
			
			';
		}




		

		$output .= '</div>';
		
		/*$output = $accordion = '';
		//fetch driver details
		$driver = $this->users_model->getUser($_POST['driver_id']);

		$output .= '<div class="text-center fs-6 mb-3">Driver Name: <strong>'.$driver->name.'</strong> (Week: '.$_POST['week'].' | Year: '.$_POST['year'].')</div>';
		
		//fetch sheet
		$punch_data = $this->sheet_model->getSinglePunchData($driver->id, $_POST['dt'], $_POST['week'], $_POST['year']);

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
					<div id="collapse'.$shift.'" class="accordion-collapse collapse '.($accordion_closed ? 'show' : '').'" data-bs-parent="#accordionSheet">
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
			<div class="accordion" id="accordionSheet">
				'.$accordion.'
			</div>';*/
		
	

		echo $output;
	}

	public function updatesheetcode(){
		$this->sheet_model->updateSheetCode($_POST['code_id'], $_POST['sheet_id'], $_POST['driver_id'], $_POST['dt'], $_POST['week'], $_POST['year']);
	}

	public function updatesheetnote(){
		$this->sheet_model->updateSheetNote($_POST['notes'], $_POST['sheet_id'], $_POST['driver_id'], $_POST['dt'], $_POST['week'], $_POST['year']);
	}

	public function publishsheet(){
		$this->sheet_model->publishSheet($_POST['week'], $_POST['year']);
	}

	public function preview(){
		$sheet_id = 0;
		$f = json_decode($_POST['ls_headers']);
		$total = count($f);

		$response = array();

		//echo $total;die;
		//echo '<pre>';print_r($f[0][2]);
		$for_date = @$_POST['sheet_date'];//deliberately supressing the error message
		if(strlen($for_date)){
			//read date details
			//$input = $starting_date;//"'Sunday 2/4";

			// Create DateTime object from the string
			$date = new DateTime($for_date);//DateTime::createFromFormat("l n/j", $input);

			// Check if the date was parsed correctly
			if ($date) {
				// Set the year to the current year
				$currentYear = date('Y');
				$weekNumber = $date->format('W');//placing it here will give current week since week starts from monday and this files atrts from sunday
				

				//find for how many drivers, data is present
				$d = json_decode($_POST['ls_values']);

				//echo count($d);
				//print_r($d);
				//start driver loop
				$total_driver_count = 0;
				for($i=0;$i<count($d);$i++){
					if(!empty($d[$i][0])){
						$total_driver_count++;
					}else{
						//break on first blank encounter
						break;
					}
				}

				$response['status'] = 1;
				$response['message'] = '
						<p class="fw-bold mb-0">New Sheet detected</p>
						<div class="d-flex justify-content-between text-success">
							<div><i class="las la-calendar-week"></i> Date '.$date->format('M d, Y').' (Week '.$weekNumber.' | Year '.$currentYear.')</div>
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
			$response['message'] = '<div class="text-danger">No Dates sent, please select date</div>';
		}

		echo json_encode($response);
	}

	public function add(){
		$sheet_id = 0;
		$f = json_decode($_POST['ls_headers']);
		$total = count($f);

		$response = array();

		//echo $total;die;
		//echo '<pre>';print_r($f[0][2]);
		$for_date = @$_POST['sheet_date'];//deliberately supressing the error message
		if(strlen($for_date)){
			//read date details
			//$input = $starting_date;//"'Sunday 2/4";

			// Create DateTime object from the string
			$date = new DateTime($for_date);//DateTime::createFromFormat("l n/j", $input);

			// Check if the date was parsed correctly
			if ($date) {
				// Set the year to the current year
				$currentYear = date('Y');
				$weekNumber = $date->format('W');//placing it here will give current week since week starts from monday and this files atrts from sunday
				

				//find for how many drivers, data is present
				$d = json_decode($_POST['ls_values']);

				//echo count($d);
				//print_r($d);
				//start driver loop
				$total_driver_count = 0;
				for($i=0;$i<count($d);$i++){
					if(!empty($d[$i][0])){
						$total_driver_count++;


						//IMPORT SCHEDULE HERE
						//first find the driver
						$driver_name = explode(' ', $d[$i][2]);
						$driver = $this->users_model->getDriverbyFirstLastName($driver_name[0], $driver_name[count($driver_name) - 1]);
						$userid = 0;
						if(empty($driver)){
							//create driver if not exists
							$tmp_driver_data = array(
								"name"=>$driver_name[0].' '.$driver_name[count($driver_name) - 1],
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
						
						$no_data_exists = $this->sheet_model->noSheetExists($userid, $weekNumber, $currentYear, $date->format('Y-m-d'));

						if($no_data_exists && $userid > 0){
							//add new sheet
							$data = array(
								'driver_id' => $userid,
								'for_date' => $date->format('Y-m-d'),
								'week_number' => $weekNumber,
								'year_number' => $currentYear,
								'wave' => $d[$i][1],
								'route' => $d[$i][3],
								'stops' => $d[$i][4],
								'packages' => $d[$i][5],
								'staging_zone' => $d[$i][6],
								'service_type' => $d[$i][7],
								'van_id' => $d[$i][8],
								'device_id' => $d[$i][9],
								'service_condition' => $d[$i][10],
								'declined_to_rescue' => $d[$i][11],
								'rescued' => $d[$i][12],
								'out_time' => $d[$i][13],
								'miles' => $d[$i][14],
								'gas' => $d[$i][15]
							);
							//print_r($data);
							$sheet_id = $this->sheet_model->addSheet($data);
						}
					}else{
						//break on first blank encounter
						break;
					}
				}

				$response['status'] = 1;
				$response['message'] = '<div class="text-success">Sheet imported</div>';
				//echo '<div class="alert alert-success">Total drivers found '.$total_driver_count.'</div>';
				
			} else {
				$response['status'] = 0;
				$response['message'] = '<div class="text-danger">Invalid date format</div>';
			}
		}else{
			//invalid header format
			$response['status'] = 0;
			$response['message'] = '<div class="text-danger">No Dates sent, please select date</div>';
		}

		echo json_encode($response);
	}


	public function add0(){
		$sheet_id = 0;
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
				$dates[] = $date->format('Y-m-d');
			
				// Add dates until next Saturday
				while ($date->format('l') !== 'Saturday') {
					$date->modify('+1 day');
					$dates[] = $date->format('Y-m-d');
				}
			
				// Output the dates
				//print_r($dates);die;
				$weekNumber = $date->format('W');//placing it here will give current week since week starts from monday and this files atrts from sunday
				

				//find for how many drivers, data is present
				$d = json_decode($_POST['ls_values']);

				//echo count($d);
				//print_r($d);
				//start driver loop
				$total_driver_count = 0;
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
							$sheetd_punch_in_time = (!empty($d[$i][$s_loop]) ? $dates[$dl].' '.$d[$i][$s_loop] : '');
							$sheetd_punch_out_time = (!empty($d[$i][$s_loop + 1]) ? $dates[$dl].' '.$d[$i][$s_loop + 1] : '');

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
							$status_code = $this->sheet_model->getSheetStatusCodeforText(@$d[$i][$s_loop + 4]);
							//echo $status_code;

							$no_data_exists = $this->sheet_model->noSheetExists($userid, $weekNumber, $currentYear, $sheetd_punch_in_time, $sheetd_punch_out_time);

							if($no_data_exists && $userid > 0){
								//add new sheet
								$data = array(
									'driver_id' => $userid,
									'week_number' => ($dl == 0 ? $weekNumber - 1 : $weekNumber),
									'year_number' => $currentYear,
									'sheetd_punch_in_time' => $sheetd_punch_in_time,
									'sheetd_punch_out_time' => $sheetd_punch_out_time,
									'actual_punch_in_time' => $actual_punch_in_time,
									'actual_punch_out_time' => $actual_punch_out_time,
									'sheet_code_id' => $status_code
								);
								//print_r($data);
								$sheet_id = $this->sheet_model->addSheet($data);
							}
							
							
							//jump to next day
							$s_loop = $s_loop + 5;
						}
						
						
						

						
						
						
						//echo $sheetd_punch_in_time;die;
						
						//echo $punch_out_time->format('Y-m-d H:i A');die;
						//$no_data_exists = $this->sheet_model->noSheetExists($userid, $weekNumber, $currentYear, $at[7], $at[8]);

					}else{
						//break on first blank encounter
						break;
					}
				}

				$response['status'] = 1;
				$response['message'] = '<div class="text-success">Sheet imported</div>';
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





	public function add_oldcode(){//based on previous sheet
		$sheet_id = 0;
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
					$no_data_exists = $this->sheet_model->noSheetExists($driver->id, $weekNumber, $yearNumber, $at[7], $at[8]);
	
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
						$sheet_id = $this->sheet_model->addSheet($data);
					}else{
						$_SESSION['message'] = '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Data already exists</div>';
					}
	
					
				}//if(!empty($driver)){ ends
				
			}//for ends
		}else{//if file valid check ends
			$_SESSION['message'] = '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Invalid format. File upload failed.</div>';
		}//else file valid check ends
		

		if($sheet_id > 0){
			$_SESSION['message'] = '<div class="alert alert-success text-white mb-2" role="alert"><strong>Success!</strong> Sheet uploaded successfully</div>';
		}

		echo admin_url('sheet');
	}
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */