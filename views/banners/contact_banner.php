<section id="banner" class="blue_gradient content">
  <div id="banner_image" class="bgs"></div>
  <article>
    <header>Contact the Author</header>
    <p>Questions for the author?  Comments about the Book?<br />Complete the form below.</p>
    <div id="form_wrap">
    	<?php
if(isset($sent) && $sent == true)
{
echo "";
}else{
?>
  
  <?php if(isset($warning)){echo "$message";} ?>
  <form method="post" action="form_script.php" name="contact">
			<div class="form_field">
				<label>* First Name:</label><br/>
    		<input name="firstname" type="text" value="<?php echo $firstname; ?>" size="16"/><br />
    		<div class="error">
					<!--ERRORMSG:firstname-->
				</div>
			</div>
			<div class="form_field">
				<label>* Last Name:</label><br/>
    		<input name="lastname" type="text" value="<?php echo $lastname; ?>" size="16"/><br />
    		<div class="error">
					<!--ERRORMSG:lastname-->
				</div>
			</div>
			<div class="form_field">
				<label>* Phone: (555-555-5555)</label><br />
      	<input name="tel" type="text" value="<?php echo $tel; ?>" size="16"/><br />
      	<div class="error">
					<!--ERRORMSG:tel-->
				</div>
			</div>
			<div class="form_field">
				<label>* Email:</label><br/>
      	<input name="email_address" type="text" value="<?php echo $email_address; ?>" size="16"/><br />
      	<div class="error">
					<!--ERRORMSG:email_address-->
				</div>
			</div>
			<div class="clear"></div>
			<div class="form_field">
				<label>Message:</label><br />
    		<textarea name="comments" cols="19" rows="3"><?php echo $comments; ?></textarea>
			</div>
			<div class="form_field button_wrap bgs">
      <input name="submit" type="submit" value="Contact Us" class="button green_button" />
			</div>
  </form>
	<?php } ?>
    </div>
  </article>
</section>