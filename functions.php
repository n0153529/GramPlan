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
	if(count($check_array)>0){  ?>

		<div><a href="https://socialteacup.co.uk/the-gram-plan/?date=<?php echo $date; ?>" ><h3 style="color:#EFECED; font-size: 1.5em;">Previous Weeks 'Gram Plan</h3></a></div>

<?php	} else { ?>

		<div><h4 style="color:#EFECED;">Previous Weeks - Does Not Exist</h4></div>

<?php }
}