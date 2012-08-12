<?PHP

define('kOptional', true);
define('kMandatory', false);

define('kStringRangeFrom', 1);
define('kStringRangeTo', 2);
define('kStringRangeBetween', 3);
        
define('kYes', 'yes');
define('kNo', 'no');




error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('track_errors', true);

function DoStripSlashes($fieldValue)  { 
 if ( get_magic_quotes_gpc() ) { 
  if (is_array($fieldValue) ) { 
   return array_map('DoStripSlashes', $fieldValue); 
  } else { 
   return stripslashes($fieldValue); 
  } 
 } else { 
  return $fieldValue; 
 } 
}

function FilterCChars($theString) {
 return preg_replace('/[\x00-\x1F]/', '', $theString);
}

function ProcessPHPFile($PHPFile) {
 
 ob_start();
 
 if (file_exists($PHPFile)) {
  require $PHPFile;
 } else {
  echo "Forms To Go - Error: Unable to load HTML form: $PHPFile";
  exit;
 }
 
 return ob_get_clean();
}

function CheckString($value, $low, $high, $mode, $limitAlpha, $limitNumbers, $limitEmptySpaces, $limitExtraChars, $optional) {
 if ($limitAlpha == kYes) {
  $regExp = 'A-Za-z';
 }
 
 if ($limitNumbers == kYes) {
  $regExp .= '0-9'; 
 }
 
 if ($limitEmptySpaces == kYes) {
  $regExp .= ' '; 
 }

 if (strlen($limitExtraChars) > 0) {
 
  $search = array('\\', '[', ']', '-', '$', '.', '*', '(', ')', '?', '+', '^', '{', '}', '|', '/');
  $replace = array('\\\\', '\[', '\]', '\-', '\$', '\.', '\*', '\(', '\)', '\?', '\+', '\^', '\{', '\}', '\|', '\/');

  $regExp .= str_replace($search, $replace, $limitExtraChars);

 }

 if ( (strlen($regExp) > 0) && (strlen($value) > 0) ){
  if (preg_match('/[^' . $regExp . ']/', $value)) {
   return false;
  }
 }

 if ( (strlen($value) == 0) && ($optional === kOptional) ) {
  return true;
 } elseif ( (strlen($value) >= $low) && ($mode == kStringRangeFrom) ) {
  return true;
 } elseif ( (strlen($value) <= $high) && ($mode == kStringRangeTo) ) {
  return true;
 } elseif ( (strlen($value) >= $low) && (strlen($value) <= $high) && ($mode == kStringRangeBetween) ) {
  return true;
 } else {
  return false;
 }

}


function CheckEmail($email, $optional) {
 if ( (strlen($email) == 0) && ($optional === kOptional) ) {
  return true;
 } elseif ( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email) ) {
  return true;
 } else {
  return false;
 }
}


function CheckTelephone($telephone, $valFormat, $optional) {
 if ( (strlen($telephone) == 0) && ($optional === kOptional) ) {
  return true;
 } elseif ( ereg($valFormat, $telephone) ) {
  return true;
 } else {
  return false;
 }
}



if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
 $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
 $clientIP = $_SERVER['REMOTE_ADDR'];
}

$FTGfirstname = DoStripSlashes( $_POST['firstname'] );
$FTGlastname = DoStripSlashes( $_POST['lastname'] );
$FTGtel = DoStripSlashes( $_POST['tel'] );
$FTGemail_address = DoStripSlashes( $_POST['email_address'] );
$FTGcomments = DoStripSlashes( $_POST['comments'] );



$validationFailed = false;

# Fields Validations


if (!CheckString($FTGfirstname, 2, 50, kStringRangeBetween, kYes, kNo, kNo, '', kMandatory)) {
 $FTGErrorMessage['firstname'] = 'Enter a Valid First Name';
 $validationFailed = true;
}

if (!CheckString($FTGlastname, 2, 50, kStringRangeBetween, kYes, kNo, kNo, '', kMandatory)) {
 $FTGErrorMessage['lastname'] = 'Enter a Valid Last Name';
 $validationFailed = true;
}

if (!CheckTelephone($FTGtel, '[0-9]{3}\-[0-9]{3}\-[0-9]{4}', kMandatory)) {
 $FTGErrorMessage['tel'] = 'Enter Valid Phone Number';
 $validationFailed = true;
}

if (!CheckEmail($FTGemail_address, kMandatory)) {
 $FTGErrorMessage['email_address'] = 'Enter Valid Email';
 $validationFailed = true;
}



# Embed error page and dump it to the browser

if ($validationFailed === true) {

 $fileErrorPage = 'contact.php';

 if (file_exists($fileErrorPage) === false) {
  echo '<html><head><title>Error</title></head><body>The error page: <b>' . $fileErrorPage. '</b> cannot be found on the server.</body></html>';
  exit;
 }

 $errorPage = ProcessPHPFile($fileErrorPage);

 $errorList = @implode("<br />\n", $FTGErrorMessage);
 $errorPage = str_replace('<!--VALIDATIONERROR-->', $errorList, $errorPage);

 $errorPage = str_replace('<!--FIELDVALUE:firstname-->', $FTGfirstname, $errorPage);
 $errorPage = str_replace('<!--FIELDVALUE:lastname-->', $FTGlastname, $errorPage);
 $errorPage = str_replace('<!--FIELDVALUE:tel-->', $FTGtel, $errorPage);
 $errorPage = str_replace('<!--FIELDVALUE:email_address-->', $FTGemail_address, $errorPage);
 $errorPage = str_replace('<!--FIELDVALUE:comments-->', $FTGcomments, $errorPage);
 $errorPage = str_replace('<!--ERRORMSG:firstname-->', $FTGErrorMessage['firstname'], $errorPage);
 $errorPage = str_replace('<!--ERRORMSG:lastname-->', $FTGErrorMessage['lastname'], $errorPage);
 $errorPage = str_replace('<!--ERRORMSG:tel-->', $FTGErrorMessage['tel'], $errorPage);
 $errorPage = str_replace('<!--ERRORMSG:email_address-->', $FTGErrorMessage['email_address'], $errorPage);


 echo $errorPage;

}

if ( $validationFailed === false ) {

 # Email to Form Owner
  
 $emailSubject = FilterCChars("Contact Request");
  
 $emailBody = "Contact Request from ExitPlan\n"
  . "\n"
  . "First Name : $FTGfirstname\n"
  . "Last Name : $FTGlastname\n"
  . "Phone : $FTGtel\n"
  . "Email : $FTGemail_address\n"
  . "Comments : $FTGcomments\n"
  . "";
  $emailTo = 'cinneman@gmail.com';
   
  $emailFrom = FilterCChars("contact@exitplan.me");
   
  $emailHeader = "From: $emailFrom\n"
   . "MIME-Version: 1.0\n"
   . "Content-type: text/plain; charset=\"ISO-8859-1\"\n"
   . "Content-transfer-encoding: 7bit\n";
   
  mail($emailTo, $emailSubject, $emailBody, $emailHeader);
  
  
  # Redirect user to success page

header("Location: http://www.exitplan.me/thank_you.php");

}

?>