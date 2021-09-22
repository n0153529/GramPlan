<?php the_content(); /* Template Name: IG Tracker */


$userm = MeprUtils::get_currentuserinfo(); //print_r($userm);


get_header();

    // load all data for this user and current week
    global $wpdb;
	global $current_user;
	wp_get_current_user();    
	$date = date('Y-m-d');
    if(isset($_GET['date'])){
		$date = strval($_GET['date']);
	}
   
    $username = $current_user->user_login;
	$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ig_tracker_prd WHERE YEARWEEK(created_date) = YEARWEEK('".$date."') AND user = '".$username."' AND datetype = 'weekly'");
	$weekly_array = $wpdb->get_results( $sql , ARRAY_A );
	$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ig_tracker_prd WHERE YEAR(created_date) = YEAR('".$date."')
  AND MONTH(created_date) = MONTH('".$date."') AND user = '".$username."' AND datetype = 'monthly'");
	$monthly_array = $wpdb->get_results( $sql , ARRAY_A );  






// if a checkbox and not exist, output  class as 'new'  and  'data' as ""
// if a checkbox and exists, output  class as ""  and  'data' as checked="checked"
// if a text field and not exist, output class as 'new' and data as 'value=""'
// if a text field and not exist, output class as "" and data as 'value="data"'



function get_value($section,$typea,$typeb,$array,$method,$element_type){
	$found = "0";
	$data = "";
	$id = "";
	foreach($array as $arr){
        if($arr['section'] == $section){
          if($arr['typea'] == $typea){
            if($arr['typeb'] == $typeb){
               $data = $arr['data'];
			   $found = "1";
			   $id = $arr['id'];
			};
		  };
		};
	};
    if($found == "1"){
		if($method == "class"){
		  if($element_type == "checkbox"){
		     return '_checkbox" id="'.$id.'"';
		  };
		  if($element_type == "text"){
		     return '_text" id="'.$id.'"';
		  };
		  if($element_type == "textarea"){
		     return '_textarea" id="'.$id.'"';			  
		  };
		};
		if($method == "value"){
			if($element_type == "checkbox"){
				return 'checked="checked"';
			};
			if($element_type == "text"){
				return 'value="'.$data.'"';
			};
			if($element_type == "textarea"){
				return $data;
			};			
		};
	} else {
		if($method == "class"){
		  if($element_type == "checkbox"){
		     return '_checkbox new"';
		  };
		  if($element_type == "text"){
		     return '_text new"';
		  };
		  if($element_type == "textarea"){
		     return '_textarea new"';
		  };
		};
		if($method == "value"){
			if($element_type == "checkbox"){
				return "";
			};
			if($element_type == "text"){
				return 'value=""';
			};			
			if($element_type == "textarea"){
				return "";
			};	
		};
	}
};
?>

<script>

jQuery(document).ready(function ($) {
	
	$(".ig_item_checkbox").click(function(){
        
        jQuery('.saving_loader').css('display','block');		

		var method_n = "exist";
		var id = "none";
		var data = "";
		if($(this).hasClass("new")){ 
		   method_n = "new";
		} else {
			id = $(this).attr("id");
		};		
		if($(this).attr("type")=="checkbox"){
			if($(this).prop("checked")){
				data = "yes";
			} else {
				data = "no";
			};
		} else {
			data = $(this).val();
		};
		
		
	              
		var data_arr = {action: "update_ig_entry", method_n: method_n, id: id, datetype: $(this).attr("datetype"),section: $(this).attr("section_n"), typea: $(this).attr("typea"), typeb: $(this).attr("typeb"), data:data<?php if(isset($_GET['date'])){ echo ',date:"'.strval($_GET['date']).'"';}; ?>};
		$.post("https://socialteacup.co.uk/wp-admin/admin-ajax.php", data_arr, function(res) {		
		console.log(res);
					
		});	
        jQuery('.saving_loader').css('display','none');			
	});
	
	$(".ig_item_text").on('focusout', function () { 

       jQuery('.saving_loader').css('display','block');	
		
		var method_n = "exist";
		var id = "none";
		var data = "";
		if($(this).hasClass("new")){ 
		   method_n = "new";
		} else {
			id = $(this).attr("id");
		};		
		if($(this).attr("type")=="checkbox"){
			if($(this).prop("checked")){
				data = "yes";
			} else {
				data = "no";
			};
		} else {
			data = $(this).val();
		};
	              
		var data_arr = {action: "update_ig_entry", method_n: method_n, id: id, datetype: $(this).attr("datetype"),section: $(this).attr("section_n"), typea: $(this).attr("typea"), typeb: $(this).attr("typeb"), data:data<?php if(isset($_GET['date'])){ echo ',date:"'.strval($_GET['date']).'"';}; ?>};
		$.post("https://socialteacup.co.uk/wp-admin/admin-ajax.php", data_arr, function(res) {		
		console.log(res);
					
		})	
       jQuery('.saving_loader').css('display','none');			
	});
	
	$(".ig_item_textarea").on('focusout', function () { 

       jQuery('.saving_loader').css('display','block');	
		
		var method_n = "exist";
		var id = "none";
		var data = "";
		if($(this).hasClass("new")){ 
		   method_n = "new";
		} else {
			id = $(this).attr("id");
		};		
		if($(this).attr("type")=="checkbox"){
			if($(this).prop("checked")){
				data = "yes";
			} else {
				data = "no";
			};
		} else {
			data = $(this).val();
		};
	              
		var data_arr = {action: "update_ig_entry", method_n: method_n, id: id, datetype: $(this).attr("datetype"),section: $(this).attr("section_n"), typea: $(this).attr("typea"), typeb: $(this).attr("typeb"), data:data<?php if(isset($_GET['date'])){ echo ',date:"'.strval($_GET['date']).'"';}; ?>};
		$.post("https://socialteacup.co.uk/wp-admin/admin-ajax.php", data_arr, function(res) {		
		console.log(res);
					
		})	
       jQuery('.saving_loader').css('display','none');			
	});

 }) 
 </script>




 <!-- loader -->
 <div class="saving_loader" style="display:none;width:100px;height:100px;position:absolute;top:0;right:0;z-index:99999;background-color:#000;"><img src="https://socialteacup.co.uk/wp-content/uploads/2021/08/Rolling-2s-200px.gif" alt="Saving..." /></img></div>


 <!-- NEW TOP OF PAGE TITLE SAVE BUTTON -->
 <!-- NEW TOP OF PAGE TITLE SAVE BUTTON -->
<div style="padding: 30px 0px 20px 0px; width: 100%;">
<div>
	<h3 style="color:#F0ECED; display: inline-block;margin: 5px 5px 0px 0px; vertical-align: middle;">Gram Plan for:  <? if(isset($_GET['date'])){ $ddate = $_GET['date']; $date=explode('-',$ddate)[2].'-'.explode('-',$ddate)[1].'-'.explode('-',$ddate)[0]; echo $date; } else { echo "This week"; }; ?> </h3>

<div class="elementor-button-wrapper" style="display: inline-block; float:right;">
<a onClick="window.location.reload()" id="refreshPage" class="elementor-button elementor-size-sm elementor-animation-grow" style="font-size: 1rem; font-weight: 600; text-transform: uppercase; line-height: 1.6em; letter-spacing: 0.5px; fill: #000000; color: #000000; background-color: #ACBBCB; border-radius: 50px 50px 50px 50px; padding: 10px 40px 10px 50px;cursor:pointer;" role="button">
<span class="elementor-button-text">Save <img draggable="false" role="img" class="emoji" alt="💾" src="https://s.w.org/images/core/emoji/13.1.0/svg/1f4be.svg"></span>
</a>
</div>

<div class="elementor-button-wrapper" style="display: inline-block; float:right;">
<a href="/wp-content/uploads/2021/08/TST-The-Gram-Plan-Guide.pdf" target="_blank" class="elementor-button-link elementor-button elementor-size-sm elementor-animation-grow ari-fancybox-pdf ari-fancybox" style="font-size: 1rem; font-weight: 600; text-transform: uppercase; line-height: 1.6em; letter-spacing: 0.5px; fill: #000000; color: #000000; background-color: #D0D6F6; border-radius: 50px 50px 50px 50px; padding: 10px 40px 10px 40px;cursor:pointer;margin: 0px 10px;" role="button">
<span class="elementor-button-text">'Gram Guide </span>
</a>
</div>
		
<p style="float: right;vertical-align: middle;display: inline-block;line-height: 1.6em;margin: 10px 5px;color: #f0eced;">Read me <i class="fas fa-angle-double-right"></i></p>		
		
</div>
</div>
 <!-- NEW TOP OF PAGE TITLE SAVE BUTTON -->
 <!-- NEW TOP OF PAGE TITLE SAVE BUTTON -->	


<div id="maingramplan-left">
	


<!-- TO DO -->
<div class="gram-box">

<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">Weekly Tasks:</h3>	
</div>	
	
<div class="todo">
<input class="ig_item<?php echo get_value('todo','content-creation-day','none',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="todo" typea="content-creation-day" typeb="none" <?php echo get_value('todo','content-creation-day','none',$weekly_array,'value','checkbox'); ?> />
		   Content creation day
</div>
<div class="todo">
	       <input class="ig_item<?php echo get_value('todo','welcome-new-follows','none',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="todo" typea="welcome-new-follows" typeb="none" <?php echo get_value('todo','welcome-new-follows','none',$weekly_array,'value','checkbox'); ?>/>
	Welcome new followers
</div>
<div class="todo">
	       <input class="ig_item<?php echo get_value('todo','share-love','none',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="todo" typea="share-love" typeb="none" <?php echo get_value('todo','share-love','none',$weekly_array,'value','checkbox'); ?>/>
	Share the love
</div>

</div>



<!-- TO LEARN -->
<div class="gram-box">


<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">Monthly Teachings:</h3>	
</div>

<div class="tolearn">
	       <input class="ig_item<?php echo get_value('tolearn','masterclass','none',$monthly_array,'class','checkbox');?> type="checkbox" datetype="monthly" section_n="tolearn" typea="masterclass" typeb="none" <?php echo get_value('tolearn','masterclass','none',$monthly_array,'value','checkbox'); ?>/>
		   This months masterclass
</div>
<div class="tolearn">
	       <input class="ig_item<?php echo get_value('tolearn','tutorial','none',$monthly_array,'class','checkbox');?> type="checkbox" datetype="monthly" section_n="tolearn" typea="tutorial" typeb="none" <?php echo get_value('tolearn','tutorial','none',$monthly_array,'value','checkbox'); ?>/>
	This months teachings
</div>

</div>	



<!-- TO POST -->
<div class="gram-box">	


<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">This Weeks Content:</h3>	
</div>	
	
<table class="tablesorter topost">
   <thead  style="background-color: #D0D6F6;color: #343232; border-top-left-radius: 10px;border-top-right-radius: 10px;">
      <tr class="table-header">
         <th class="" id="" colspan="" style="border-top-left-radius: 10px;">
            <span class="data-table-header-text"></span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">MON</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">TUE</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">WED</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">THU</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">FRI</span>
         </th>
         <th class="" id="" colspan="" style="border-top-right-radius: 10px;">
            <span class="data-table-header-text">SAT</span>
         </th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">Reel</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Reel','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Reel" typeb="Mon" <?php echo get_value('topost','Reel','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Reel','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Reel" typeb="Tue" <?php echo get_value('topost','Reel','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Reel','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Reel" typeb="Wed" <?php echo get_value('topost','Reel','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Reel','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Reel" typeb="Thur" <?php echo get_value('topost','Reel','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Reel','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Reel" typeb="Fri" <?php echo get_value('topost','Reel','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Reel','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Reel" typeb="Sat" <?php echo get_value('topost','Reel','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">Video</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Video','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Video" typeb="Mon" <?php echo get_value('topost','Video','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Video','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Video" typeb="Tue" <?php echo get_value('topost','Video','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Video','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Video" typeb="Wed" <?php echo get_value('topost','Video','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Video','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Video" typeb="Thur" <?php echo get_value('topost','Video','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Video','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Video" typeb="Fri" <?php echo get_value('topost','Video','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Video','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Video" typeb="Sat" <?php echo get_value('topost','Video','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">Post</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Photo','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Photo" typeb="Mon" <?php echo get_value('topost','Photo','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Photo','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Photo" typeb="Tue" <?php echo get_value('topost','Photo','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Photo','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Photo" typeb="Wed" <?php echo get_value('topost','Photo','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Photo','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Photo" typeb="Thur" <?php echo get_value('topost','Photo','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Photo','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Photo" typeb="Fri" <?php echo get_value('topost','Photo','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Photo','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Photo" typeb="Sat" <?php echo get_value('topost','Photo','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">Carousel</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Carousel','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Carousel" typeb="Mon" <?php echo get_value('topost','Carousel','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Carousel','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Carousel" typeb="Tue" <?php echo get_value('topost','Carousel','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Carousel','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Carousel" typeb="Wed" <?php echo get_value('topost','Carousel','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Carousel','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Carousel" typeb="Thur" <?php echo get_value('topost','Carousel','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Carousel','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Carousel" typeb="Fri" <?php echo get_value('topost','Carousel','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','Carousel','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="Carousel" typeb="Sat" <?php echo get_value('topost','Carousel','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">IGTV</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','IGTV','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="IGTV" typeb="Mon" <?php echo get_value('topost','IGTV','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','IGTV','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="IGTV" typeb="Tue" <?php echo get_value('topost','IGTV','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','IGTV','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="IGTV" typeb="Wed" <?php echo get_value('topost','IGTV','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','IGTV','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="IGTV" typeb="Thur" <?php echo get_value('topost','IGTV','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','IGTV','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="IGTV" typeb="Fri" <?php echo get_value('topost','IGTV','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('topost','IGTV','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="topost" typea="IGTV" typeb="Sat" <?php echo get_value('topost','IGTV','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
	</tbody>
	</table>

	
</div>	
	
	



<!-- TO SHARE -->
<div class="gram-box">	

<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">Stories To Share:</h3>	
</div>
	
<table class="tablesorter toshare">
   <thead  style="background-color: #D0D6F6;color: #343232; border-top-left-radius: 10px;border-top-right-radius: 10px;">
      <tr class="table-header">
         <th class="" id="" colspan="" style="border-top-left-radius: 10px;">
            <span class="data-table-header-text"></span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">MON</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">TUE</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">WED</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">THU</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">FRI</span>
         </th>
         <th class="" id="" colspan="" style="border-top-right-radius: 10px;">
            <span class="data-table-header-text">SAT</span>
         </th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">1</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','1','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="1" typeb="Mon" <?php echo get_value('toshare','1','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','1','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="1" typeb="Tue" <?php echo get_value('toshare','1','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','1','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="1" typeb="Wed" <?php echo get_value('toshare','1','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','1','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="1" typeb="Thur" <?php echo get_value('toshare','1','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','1','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="1" typeb="Fri" <?php echo get_value('toshare','1','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','1','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="1" typeb="Sat" <?php echo get_value('toshare','1','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">2</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','2','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="2" typeb="Mon" <?php echo get_value('toshare','2','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','2','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="2" typeb="Tue" <?php echo get_value('toshare','2','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','2','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="2" typeb="Wed" <?php echo get_value('toshare','2','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','2','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="2" typeb="Thur" <?php echo get_value('toshare','2','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','2','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="2" typeb="Fri" <?php echo get_value('toshare','2','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','2','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="2" typeb="Sat" <?php echo get_value('toshare','2','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">3</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','3','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="3" typeb="Mon" <?php echo get_value('toshare','3','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','3','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="3" typeb="Tue" <?php echo get_value('toshare','3','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','3','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="3" typeb="Wed" <?php echo get_value('toshare','3','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','3','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="3" typeb="Thur" <?php echo get_value('toshare','3','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','3','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="3" typeb="Fri" <?php echo get_value('toshare','3','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toshare','3','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toshare" typea="3" typeb="Sat" <?php echo get_value('toshare','3','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
	</tbody>
	</table>

</div>	
	
</div>





<div id="maingramplan-right">
	



<!-- TO REPLY TO -->
<div class="gram-box">	

<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">To Reply To:</h3>	
</div>
<a class="elementor-icon" href="https://www.instagram.com/direct/inbox/">
<img src="https://socialteacup.co.uk/wp-content/uploads/2021/08/icon-mail2-60.png" alt="Reply" id="reply-icon" style="vertical-align: middle;line-height: 1.5em;margin-left: 10px;">
<!-- <i aria-hidden="true" class="fas fa-mail-bulk" style="color: #c3504c;font-size: 0.6em;line-height: 1.5em;margin-left: 10px;"></i> -->
</a>

	
<div>
  <button class="" style="width:49%; border-radius:0px;background-color:#d0d6f6; color:#343232;" onclick="openTabs('DMs')">DMs</button>
  <button class="" style="width:49%; border-radius:0px;" onclick="openTabs('Commentsbox')">Comments</button>
</div>

<div id="DMs" class="tabswap">
<p style="margin:5px 0px; text-align:centre;">Have you replied to your DM's today?</p>	
<table class="tablesorter toreply-dm">
   <thead  style="background-color: #D0D6F6;color: #343232; border-top-left-radius: 10px;border-top-right-radius: 10px;">
      <tr class="table-header">
         <th class="" id="" colspan="" style="border-top-left-radius: 10px;">
            <span class="data-table-header-text"></span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">MON</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">TUE</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">WED</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">THU</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">FRI</span>
         </th>
         <th class="" id="" colspan="" style="border-top-right-radius: 10px;">
            <span class="data-table-header-text">SAT</span>
         </th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">AM</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','AM','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="AM" typeb="Mon" <?php echo get_value('toreply-dm','AM','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','AM','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="AM" typeb="Tue" <?php echo get_value('toreply-dm','AM','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','AM','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="AM" typeb="Wed" <?php echo get_value('toreply-dm','AM','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','AM','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="AM" typeb="Thur" <?php echo get_value('toreply-dm','AM','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','AM','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="AM" typeb="Fri" <?php echo get_value('toreply-dm','AM','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','AM','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="AM" typeb="Sat" <?php echo get_value('toreply-dm','AM','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">PM</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','PM','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="PM" typeb="Mon" <?php echo get_value('toreply-dm','PM','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','PM','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="PM" typeb="Tue" <?php echo get_value('toreply-dm','PM','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','PM','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="PM" typeb="Wed" <?php echo get_value('toreply-dm','PM','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','PM','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="PM" typeb="Thur" <?php echo get_value('toreply-dm','PM','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','PM','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="PM" typeb="Fri" <?php echo get_value('toreply-dm','PM','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-dm','PM','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-dm" typea="PM" typeb="Sat" <?php echo get_value('toreply-dm','PM','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>   
	</tbody>
	</table>

</div>

<div id="Commentsbox" class="tabswap" style="display:none">
<p style="margin:5px 0px; text-align:centre;">Have you replied to your comments today?</p>
<table class="tablesorter toreply-comments">
      <thead  style="background-color: #363640;color: #D0D6F6; border-top-left-radius: 10px;border-top-right-radius: 10px;">
      <tr class="table-header">
         <th class="" id="" colspan="" style="border-top-left-radius: 10px;">
            <span class="data-table-header-text"></span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">MON</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">TUE</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">WED</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">THU</span>
         </th>
         <th class="" id="" colspan="">
            <span class="data-table-header-text">FRI</span>
         </th>
         <th class="" id="" colspan="" style="border-top-right-radius: 10px;">
            <span class="data-table-header-text">SAT</span>
         </th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">AM</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','AM','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="AM" typeb="Mon" <?php echo get_value('toreply-comments','AM','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','AM','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="AM" typeb="Tue" <?php echo get_value('toreply-comments','AM','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','AM','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="AM" typeb="Wed" <?php echo get_value('toreply-comments','AM','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','AM','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="AM" typeb="Thur" <?php echo get_value('toreply-comments','AM','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','AM','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="AM" typeb="Fri" <?php echo get_value('toreply-comments','AM','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','AM','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="AM" typeb="Sat" <?php echo get_value('toreply-comments','AM','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>
      <tr>
         <td colspan="" rowspan="" class="">
               <div class="td-content">PM</div>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','PM','Mon',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="PM" typeb="Mon" <?php echo get_value('toreply-comments','PM','Mon',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','PM','Tue',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="PM" typeb="Tue" <?php echo get_value('toreply-comments','PM','Tue',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','PM','Wed',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="PM" typeb="Wed" <?php echo get_value('toreply-comments','PM','Wed',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','PM','Thur',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="PM" typeb="Thur" <?php echo get_value('toreply-comments','PM','Thur',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','PM','Fri',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="PM" typeb="Fri" <?php echo get_value('toreply-comments','PM','Fri',$weekly_array,'value','checkbox'); ?>/>
         </td>
         <td colspan="" rowspan="" class="">
		          <input class="ig_item<?php echo get_value('toreply-comments','PM','Sat',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="toreply-comments" typea="PM" typeb="Sat" <?php echo get_value('toreply-comments','PM','Sat',$weekly_array,'value','checkbox'); ?>/>
         </td>	 
      </tr>   
	</tbody>
	</table>
</div>


<script>
function openTabs(tabName) {
  var i;
  var x = document.getElementsByClassName("tabswap");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(tabName).style.display = "block";  
}
</script>	
	
	
	


	
	


</div>		
	



<!-- To Analyse -->
<div class="gram-box">	

<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">Weekly insights:</h3>	
</div>
	
<div style="display: inline-flex;">
<div class="toanalyse">
<label style="font-size:1em;">Accounts reached:</label>
<input class="ig_item<?php echo get_value('toanalyse','accounts_reached','none',$weekly_array,'class','text');?> type="text" datetype="weekly" section_n="toanalyse" typea="accounts_reached" typeb="none" <?php echo get_value('toanalyse','accounts_reached','none',$weekly_array,'value','text'); ?>/>
</div>

<div class="toanalyse">
<label style="font-size:1em;">Content interactions:</label>
<input class="ig_item<?php echo get_value('toanalyse','content_interactions','none',$weekly_array,'class','text');?> type="text" datetype="weekly" section_n="toanalyse" typea="content_interactions" typeb="none" <?php echo get_value('toanalyse','content_interactions','none',$weekly_array,'value','text'); ?>/>
</div>
</div>


<div style="display: inline-flex;">	
<div class="toanalyse">
<label style="font-size:1em;">Profile visits:</label>
<input class="ig_item<?php echo get_value('toanalyse','profile_visits','none',$weekly_array,'class','text');?> type="text" datetype="weekly" section_n="toanalyse" typea="profile_visits" typeb="none" <?php echo get_value('toanalyse','profile_visits','none',$weekly_array,'value','text'); ?>/>
</div>

<div class="toanalyse">
<label style="font-size:1em;">Website taps:</label>
<input class="ig_item<?php echo get_value('toanalyse','website_taps','none',$weekly_array,'class','text');?> type="text" datetype="weekly" section_n="toanalyse" typea="website_taps" typeb="none" <?php echo get_value('toanalyse','website_taps','none',$weekly_array,'value','text'); ?>/>
</div>
</div>

</div>	
	
	
<!-- To Unwind -->
<div class="gram-box">	

<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">The Recharge:</h3>	
</div>	
	
	<div class="self-love-time-sunday">
	       <input class="ig_item<?php echo get_value('tounwind','self-love-sunday','none',$weekly_array,'class','checkbox');?> type="checkbox" datetype="weekly" section_n="tounwind" typea="self-love-sunday" typeb="none" <?php echo get_value('tounwind','self-love-sunday','none',$weekly_array,'value','checkbox'); ?>/>
		   Weekly self-care task
	</div>

</div>



<!-- To Remember -->
<div class="gram-box">	

<div style="display: inline-block; padding: 2px 20px 2px 20px; background-color: #C3504C; border-radius: 10px 10px 10px 10px; margin-bottom: 10px;">
	<h3 style="color:#fff; margin-bottom:-2px; font-family: 'Brasika Display'; font-weight: 400; text-transform: uppercase;font-size: 1.75em;">Journal Entries:</h3>	
</div>	


	<div class="remember">
	      <textarea class="ig_item<?php echo get_value('toremember','none','none',$weekly_array,'class','textarea');?> type="textarea" rows="5" cols="40" placeholder="Enter your notes here..." datetype="weekly" align="top" section_n="toremember" typea="none" typeb="none" style="width:100%;height:250px;"/><?php echo get_value('toremember','none','none',$weekly_array,'value','textarea'); ?></textarea>
	</div>
	
	
	
</div>	
	


	
	
	
	
</div>	



	
	
	

<?php



// get_footer();

// id
// user
// created_date
// datetype (daily, weekly, monthly)
// section (tolearn/tolearn/toanalyse/tounwind/remember/to post/to share/reply to)
// type

 ?>