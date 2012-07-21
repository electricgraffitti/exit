<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<head>
  <?php require_once("layouts/headmeta.php"); ?>
</head>

<body>
    <?php require_once("layouts/facebook_script.php"); ?>
    <section id="mast_header" class="full_section">
      <?php require_once("layouts/header.php"); ?>
      <section id="banner" class="red_gradient full_section">
        <ul id="main_sections" class="content">
          <li>
            <img src="public/images/engine_repair.png" alt="">
            <header class="custom_bold">Engine Repair</header>
            <p>Our technicians provide top quality repairs for all major brands of small engines, as well as maintenance repairs to keep your job trouble free.</p>
            <a href="service.php" title="Service" class="button black_button">Get Service</a>
          </li>
          <li>
            <img src="public/images/service.png" alt="">
            <header class="custom_bold">Parts &#38; Service</header>
            <p>We carry a complete line of replacement parts and maintenance products for all major brands of small engines.</p>
            <a href="service.php" title="Service" class="button black_button">Get Parts</a>
          </li>
          <li>
            <img src="public/images/midget_engines.png" alt="">
            <header class="custom_bold">Midget Engines</header>
            <p>Our high performance speed shop can provide you with the best custom engine modifications to help you get to the finish line.</p>
            <a href="midgets.php" title="" class="button black_button">Get Fast</a>
          </li>
          <div class="clear"></div>
        </ul>
      </section>
      <div class="clear"></div>
    </section>
    
    <section id="content" class="full_section">
      <?php require_once("views/index_content.php"); ?>
      <div class="clear"></div>
    </section>

    <footer id="mast_footer" class="full_section">
      <?php require_once("layouts/footer.php"); ?>
      <div class="clear"></div>
    </footer>
    <div class="clear"></div>

  
  
  
  <?php require_once("layouts/scripts.php"); ?>
  
  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

    });
  </script>
</body>

</html>