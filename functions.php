<?php


// IG TRACKER CODE
// IG TRACKER CODE
// IG TRACKER CODE


function show_loggedin_function( $atts ) {

	global $current_user, $user_login;
      	get_currentuserinfo();
	add_filter('widget_text', 'do_shortcode');
	if ($user_login) 
		return '' . $current_user->user_firstname . '!';
	else
		return '<a href="' . wp_login_url() . ' ">Login</a>';
	
}
add_shortcode( 'show_loggedin_as', 'show_loggedin_function' );


add_action( 'wp_ajax_update_ig_entry', 'update_ig_entry' );

function delete_row($id){
            $table_name  = $wpdb->prefix."ig_tracker_prd";
            $wpdb->delete( $table_name, array( 'id' => $id ) );
};			

function update_ig_entry(){

	global $wpdb,$current_user,$user_login;
    get_currentuserinfo();
	$user = $current_user->user_login;
	 
	if(isset($_POST['method_n'],$_POST['datetype'],$_POST['section'],$_POST['typea'],$_POST['typeb'])){
		
		$method_n = $_POST['method_n'];
		
		if($method_n=="new"){
			$date = date('Y-m-d');
			if(isset($_POST['date'])){
				$date = strval($_POST['date']);
			};
			echo $date;

			//$id = $_POST['id'];
			$datetype = $_POST['datetype'];
			$section = $_POST['section'];
			$typea = $_POST['typea'];
			$typeb = $_POST['typeb'];			
			$data = $_POST['data'];
			//wp_get_current_user();
			//$user = $current_user->user_login;			
			$table = $wpdb->prefix.'ig_tracker_prd';
			$query_data = array('user'=>$user,'datetype' => $datetype, 'section' => $section, 'typea' => $typea, 'typeb' => $typeb,'created_date' => $date, 'data'=> $data);
			$format = array( '%s', '%s', '%s', '%s','%s', '%s', '%s');
			$wpdb->insert($table,$query_data,$format);				
			return 'Success - added';
        } else {
			
			$data = $_POST['data'];
			$id = $_POST['id'];
			if($data == "no" or $data == ""){ 
				$table_name  = $wpdb->prefix."ig_tracker_prd";
                $wpdb->delete( $table_name, array( 'id' => $id ) );
			} else {		
				wp_get_current_user();
				$user = $current_user->user_login;
				$table_name  = $wpdb->prefix."ig_tracker_prd"; //custom table name
				$wpdb->query( $wpdb->prepare("UPDATE ".$table_name." SET data = '".$data."' WHERE id ='".$id."' AND user ='".$user."'"));
			};
			return 'Success - updated';
		};
	} else {
		return 'A wild ghost appeared. -10HP.';
	}
	wp_die(); 
};

add_shortcode('tracker_prev_week_link', 'output_previous_week');
function output_previous_week(){
	$type = 'next';
    global $wpdb;
	global $current_user;
	wp_get_current_user();
	if($type=="next"){
	    $date = date('Y-m-d', strtotime("+1 week"));	
	} else {
		$date = date('Y-m-d', strtotime("-1 week"));
	};	
    $username = $current_user->user_login;
	$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ig_tracker_prd WHERE YEARWEEK(created_date) = YEARWEEK('".$date."') AND user = '".$username."' AND datetype = 'weekly'");
	$check_array = $wpdb->get_results( $sql , ARRAY_A );
	if(count($check_array)>0){  ?>

	<div><h5 style="color:#EFECED;">next week entries exist</h5></div>

<?php	} else { ?>

	<div><h4 style="color:#EFECED;">next week entries DO NOT exist</h4></div>

<?php }
};

add_shortcode('tracker_last_week_link', 'output_last_week');
function output_last_week(){
	$type = 'last';
    global $wpdb;
	global $current_user;
	wp_get_current_user();
	if($type=="next"){
	    $date = date('Y-m-d', strtotime("+1 week"));	
	} else {
		$date = date('Y-m-d', strtotime("-1 week"));
	};	
    $username = $current_user->user_login;
	$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ig_tracker_prd WHERE YEARWEEK(created_date) = YEARWEEK('".$date."') AND user = '".$username."' AND datetype = 'weekly'");
	$check_array = $wpdb->get_results( $sql , ARRAY_A );
	
	// Get the earliest "created_date", which we'll assume was created when the user was
	// first registered as an alternative means to get the first possible date
	// $sql = $wpdb->prepare( "SELECT min(created_date) as `created_date` FROM {$wpdb->prefix}ig_tracker_prd WHERE YEARWEEK(created_date) <= YEARWEEK('".$date."') AND user = '".$username."' AND datetype = 'weekly'");
	// $first_plan_date = $wpdb->get_results( $sql , ARRAY_A );
	
	if(count($check_array)>0){ ?>

		<div><a href="https://socialteacup.co.uk/the-gram-plan/?date=<?php echo $date; ?>" ><h3 style="color:#EFECED; font-size: 1.5em;">Previous Weeks 'Gram Plan</h3></a></div>

<?php	    		 
		// Get user's registration date
    	$udata = get_userdata( $current_user->ID );
    	$registered = strtotime($udata->user_registered);
							  
		// Determine all Mondays after the user's registration date, but before Monday last week
		$startMonday = strtotime('last Monday', $registered);
		$endDate = strtotime('-2 week', strtotime('Monday')); 
							  
		echo "<!-- User Reg: " . date('Y-m-d', $registered) . "-->";
		echo "<!-- First plan: " . date('Y-m-d', $startMonday) . "-->";
		echo "<!-- Last plan: " . date('Y-m-d', $endDate) . "-->";
							 					   
		for ($i = $endDate; $i >= $startMonday; $i = strtotime('-1 week', $i)) {
			// Output each Monday
    		$sunday = strtotime('Sunday', $i);
			?>
	<div class="elementor-element elementor-element-8303dd9 testfont elementor-widget elementor-widget-heading" data-id="8303dd9" data-element_type="widget" data-widget_type="heading.default">
		<div class="elementor-widget-container">
			<h5 class="elementor-heading-title elementor-size-default">
				<a href="/the-gram-plan/?date=<?php echo date('Y-m-d', $sunday) ?>">
					The Gram Plan<br>
					<span style="color:#D0D6F6; font-size:0.8em;"><?php echo date('M', $i) . " - " . date('j', $i) . "-" . date('jS', $sunday) ?></span>
				</a>
			</h5>		
		</div>
	</div>
		<?php
		}

							 } else { ?>

		<div><h4 style="color:#EFECED;">Previous Weeks - Does Not Exist</h4></div>

<?php
									}
}
