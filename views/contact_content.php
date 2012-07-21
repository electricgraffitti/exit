<section id="home" class="content regular_content">
	<section id="posts" class="column2">
		<header class="custom_bold section_header">Contact Small Engine Specialties Today!</header>
<?php
if(isset($sent) && $sent == true)
{
echo "";
}else{
?>
  
  <?php if(isset($warning)){echo "$message";} ?>
  <form method="post" action="sidebar_script.php" name="contact">
			<div class="form_field">
				<label>* Name:</label><br/>
    		<input name="name" type="text" value="<?php echo $name; ?>" size="30"/><br />
    		<div class="error">
					<!--ERRORMSG:name-->
				</div>
			</div>
			<div class="form_field">
				<label>* Email:</label><br/>
      	<input name="email_address" type="text" value="<?php echo $email_address; ?>" size="30"/><br />
      	<div class="error">
					<!--ERRORMSG:email_address-->
				</div>
			</div>
			<div class="form_field">
				<label>* Telephone: (555-555-5555)</label><br />
      	<input name="tel" type="text" value="<?php echo $tel; ?>" size="30"/><br />
      	<div class="error">
					<!--ERRORMSG:tel-->
				</div>
			</div>
			<div class="form_field_select">
    		<label>Select One:</label><br /> 
      	<select name="select">
        	<option>General</option>
        	<option>Parts</option>
        	<option>Repair</option>
        	<option>Service</option>
					<option>Quarter Midgets</option>
      	</select>
      	<div class="error"></div>
			</div>
			<div class="clear"></div>
			<div class="form_field_text">
				<label> Additional Comments:</label><br />
    		<textarea name="comments" cols="73" rows="6"><?php echo $comments; ?></textarea>
			</div>
			<div class="clear"></div>
			<div class="form_field_button">
      <input name="submit" type="submit" value="Contact" class="btn red_button custom_regular" />
			</div>
  </form>
	<?php } ?>

	</section>
	<aside id="map" class="column1">
		<header class="custom_bold">Location</header>
		<iframe width="290" height="550" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=1026+N+34th+Avenue+Yakima,+Wa.+98902&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=57.118084,126.035156&amp;ie=UTF8&amp;hq=&amp;hnear=1026+N+34th+Ave,+Yakima,+Washington+98902&amp;t=m&amp;z=14&amp;ll=46.616229,-120.554203&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=1026+N+34th+Avenue+Yakima,+Wa.+98902&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=57.118084,126.035156&amp;ie=UTF8&amp;hq=&amp;hnear=1026+N+34th+Ave,+Yakima,+Washington+98902&amp;t=m&amp;z=14&amp;ll=46.616229,-120.554203" style="color:#0000FF;text-align:left">View Larger Map</a></small>

	</aside>
</section>