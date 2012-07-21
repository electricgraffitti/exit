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


function CheckValueList_select($values, $valType, $optional) {

 $selCnt = 0;

 $valueList[] = 'General';
 $valueList[] = 'Parts';
 $valueList[] = 'Repair';
 $valueList[] = 'Service';
 $valueList[] = 'Quarter Midgets';



 if (!is_array($values)) {
  if (strlen($values) > 0) {
   $values = array($values);
  } else {
   $values = array();
  }
 }

 foreach ($values as $valuesKey => $valuesVal) {
  foreach ($valueList as $valueListKey => $valueListVal) {  
   if ($valueListVal == $valuesVal) {
    $selCnt++;
    break;
   }
  } 
  reset($valueList);
 }

 if ((count($values) == 0) && ($optional === kOptional)) {
  return true;
 } elseif (($valType == 1) && ($selCnt > 0)) {
  return true;
 } elseif (($valType == 2) && ($selCnt == count($valueList))) {
  return true;
 } elseif (($valType == 3) && ($selCnt == 0)) {
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

$FTGname = DoStripSlashes( $_POST['name'] );
$FTGemail_address = DoStripSlashes( $_POST['email_address'] );
$FTGtel = DoStripSlashes( $_POST['tel'] );
$FTGselect = DoStripSlashes( $_POST['select'] );
$FTGcomments = DoStripSlashes( $_POST['comments'] );



$validationFailed = false;

# Fields Validations


if (!CheckString($FTGname, 2, 35, kStringRangeBetween, kYes, kNo, kYes, '', kMandatory)) {
 $FTGErrorMessage['name'] = 'Enter First & Last Name';
 $validationFailed = true;
}

if (!CheckEmail($FTGemail_address, kMandatory)) {
 $FTGErrorMessage['email_address'] = 'Enter A Valid Email Address';
 $validationFailed = true;
}

if (!CheckTelephone($FTGtel, '[0-9]{3}\-[0-9]{3}\-[0-9]{4}', kMandatory)) {
 $FTGErrorMessage['tel'] = 'Enter A Valid Phone Number';
 $validationFailed = true;
}

# Embed error page and dump it to the browser

if ($validationFailed === true) {

 $fileErrorPage = 'index.php';

 if (file_exists($fileErrorPage) === false) {
  echo '<html><head><title>Error</title></head><body>The error page: <b>' . $fileErrorPage. '</b> cannot be found on the server.</body></html>';
  exit;
 }

 $errorPage = ProcessPHPFile($fileErrorPage);

 $errorList = @implode("<br />\n", $FTGErrorMessage);
 $errorPage = str_replace('<!--VALIDATIONERROR-->', $errorList, $errorPage);

 $errorPage = str_replace('<!--FIELDVALUE:name-->', $FTGname, $errorPage);
 $errorPage = str_replace('<!--FIELDVALUE:email_address-->', $FTGemail_address, $errorPage);
 $errorPage = str_replace('<!--FIELDVALUE:tel-->', $FTGtel, $errorPage);
 $errorPage = str_replace('<!--FIELDVALUE:comments-->', $FTGcomments, $errorPage);
 $errorPage = str_replace('<!--ERRORMSG:name-->', $FTGErrorMessage['name'], $errorPage);
 $errorPage = str_replace('<!--ERRORMSG:email_address-->', $FTGErrorMessage['email_address'], $errorPage);
 $errorPage = str_replace('<!--ERRORMSG:tel-->', $FTGErrorMessage['tel'], $errorPage);


 echo $errorPage;

}

if ( $validationFailed === false ) {

 # Email to Form Owner
  
 $emailSubject = FilterCChars("Contact Inquiry");
  
 $emailBody = "Name : $FTGname\n"
  . "Email_address : $FTGemail_address\n"
  . "Tel : $FTGtel\n"
  . "Inquiry : $FTGselect\n"
  . "Comments : $FTGcomments\n"
  . "\n"
  . "";
  $emailTo = 'Larry Jo <larry@cube2media.com>';
   
  $emailFrom = FilterCChars("Small Engine Contact Request");
   
  $emailHeader = "From: $emailFrom\n"
   . "MIME-Version: 1.0\n"
   . "Content-type: text/plain; charset=\"ISO-8859-1\"\n"
   . "Content-transfer-encoding: 7bit\n";
   
  mail($emailTo, $emailSubject, $emailBody, $emailHeader);
  
  
  # Redirect user to success page

header("");

}

?>