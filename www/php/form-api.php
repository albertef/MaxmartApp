<?php

function connect_db(){
    $username = "max_mobile_user";
    $password = "max_mobile_user";
    $database = "max_mobile";
    $hostname = "localhost";
        
    $con = mysql_connect($hostname,$username,$password) or die('Could not connect: ' . mysql_error());
    mysql_select_db($database, $con) or die('Unable to select database ' . mysql_error());
}

function sendEntryEmail($name, $email, $phone, $company, $category, $refno){
	
	$tomail=$email;
	$tomail1="sales@maxmarttrading.com,niaz.ommer@maxmarttrading.com,maxmartmobile@gmail.com";
	$subject="Maxmart Mobile App Enquiry Details";
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From:".$email;
	
	$message = "<table width=90%  border=0 cellspacing=0 cellpadding=0 style='background:#FFF; border: 1px solid #8fba2c;'>
	<tr>
	<td colspan=2 align=center ><img src='http://maxmarttrading.com/images/logo.jpg' width='150'></td>
	</tr>
	<tr>
	<td colspan=2 align=center style='background:#8fba2c; height:5px;' ></td>
	</tr>
	<tr style='background:#F0F0F0;'>
	<td style='padding:30px 10px;' colspan='2' align='center'>Your enquiry has been sent successfully.</td>
	</tr>
	<tr>
	<td style='padding:10px 10px 25px;' colspan='2' align='center'>
	<span style='padding:20px; font-size: 16px; border-radius: 5px; background: lightblue; border: 2px dashed #233a77; display: block; margin:10px auto; font-weight: bold;'>$refno</span>
	<em>Use the above reference number for future tracking</em>
	</td>
	</tr>
	<tr>
	<td colspan=2 align=center style='background:#244386; padding:10px; text-align:center; color: #FFF;' >© Maxmart Trading 2017.</td>
	</tr>
	</table>
	";
	
	$message1 = "<table width=90%  border=0 cellspacing=0 cellpadding=0 style='background:#FFF; border: 1px solid #8fba2c;'>
	<tr>
	<td colspan=2 align=center ><img src='http://maxmarttrading.com/images/logo.jpg' width='150'></td>
	</tr>
	<tr>
	<td colspan=2 align=center style='background:#8fba2c; height:5px;' ></td>
	</tr>
	<tr style='background:#F0F0F0;'>
	<td style='padding:10px;'>Name :</td>
	<td style='padding:10px;' colspan=2>$name</td>
	</tr>
	<tr>
	<td style='padding:10px;' >Email : </td>
	<td style='padding:10px;' colspan=2>$email</td>
	</tr>
	<tr style='background:#F0F0F0;'>
	<td style='padding:10px;' >Phone No : </td>
	<td style='padding:10px;' colspan=2>$phone</td>
	</tr>
	<tr>
	<td style='padding:10px;' >Company : </td>
	<td style='padding:10px;' colspan=2>$company</td>
	</tr>
	<tr style='background:#F0F0F0;'>
	<td style='padding:10px;' >Category : </td>
	<td style='padding:10px;' colspan=2>$category</td>
	</tr>
	<tr>
	<td style='padding:10px;' >Ref.No : </td>
	<td style='padding:10px;'>$refno</td>
	</tr>
	<tr>
	<td colspan=2 align=center style='background:#244386; padding:10px; text-align:center; color: #FFF;' >© Maxmart Trading 2017.</td>
	</tr>
	</table>
	";

	mail($tomail1, $subject, $message1, $headers);
	mail($tomail, $subject, $message, $headers);
}

if(isset($_GET['name']) && isset($_GET['email']) && isset($_GET['phone']) && isset($_GET['company']) && isset($_GET['category'])) {
    
    connect_db();

    $name = $_GET['name'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $company = $_GET['company'];
	$category = $_GET['category'];
	$refno = $_GET['refno'];
	
	sendEntryEmail($name, $email, $phone, $company, $category, $refno);
	
	$query = "INSERT INTO main_entry (name, email, phone, company, category, refno) VALUES ('". $name . "', '". $email . "', ". $phone . ", '". $company . "', '" . $category . "', '" . $refno . "')";

    if(mysql_query($query)) {
        echo "success";
    }
    else {
        echo "fail";
    }
}
elseif(isset($_GET['track'])) {
	connect_db();
	$trackref = $_GET['track'];
	$query = "SELECT * FROM main_entry WHERE refno='" . $trackref . "'";
    $result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if($num_rows == 0) {
		echo 'Invalid Ref.No';
	}
	else {
		$row = mysql_fetch_array($result);
		$source = $row["date"];
		$date = new DateTime($source);
		if($row["status"] == "" || $row["status"] == NULL){
			echo "Please check again later!";
		}
		else{
			echo '<p>Ref.No: ' . $row["refno"] . '</p>';
			echo '<p>Enquiry Date: ' . $date->format('d.m.Y') . '</p>';
			echo '<p>Current Status: <span class="text-danger">' . $row["status"] . '</span>';
		}
	}
}
else {
    echo "complete";
}

?>