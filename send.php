<?php
// you e-mail:
$mail_to = 'm.schewrina@yandex.ru';





header('Content-Type: text/plain; charset=utf-8');

function get_client_ip() {
	$ipaddress = '';
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(!empty($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(!empty($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(!empty($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
function get_current_date(){
	return strftime('%d.%m.%Y %H:%M:%S', time());
}
function get_html_headers($from_name, $from_email){
	$header = "MIME-Version: 1.0\r\n";
	$header.= "Content-type: text/html; charset=UTF-8\r\n";
	$header.= sprintf("From: %s <%s>\r\n", $from_name, $from_email);
	return $header;
}
function generate_html_message($subject, $form_data){
	$client_ip = get_client_ip();
	$current_date = get_current_date();
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>'.$subject.'</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body style="margin:0; padding: 0;">
	<table align="center" cellpadding="0" cellspacing="0" width="500" style="border-collapse: collapse; margin: 0 auto; font-family: "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif; border: 1px solid #333;">
	<tr>
	<th style="border: 1px solid #333; background-color: #333; text-align: center; padding: 10px;" colspan="2"><h1 style="color: #fff; font-size: 18px; margin: 0; padding: 0;">'.$subject.'</h1></th>
	</tr>';
	foreach ($form_data as $key => $value) {
		$message .= '<tr><td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">' . $key . '</td>';
    	$message .= '<td style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">'.$value .'</td></tr>';
	}
	
	$message .= '<tr><td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">Дата отправления</td>';
	$message .= '<td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">'.$current_date.'</td></tr>';
	$message .= '<tr><td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">IP отправителя</td>';
	$message .= '<td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">'.$client_ip.'</td></tr>';
	$message .= '</table></body></html>'; 
	return $message;
}


//Add vars
$user_name=$_POST['user_name'];
$user_phone =$_POST['user_phone'];
$user_email =$_POST['user_email'];
$user_text =$_POST['user_text'];

//validate
if(empty($user_name) || !preg_match("/^[а-яёА-Я]+$/msiu", $user_name)){
    print('user_name');
}elseif(empty($user_phone) || !preg_match('/^( +)?((\+?7|8) ?)?((\(\d{3}\))|(\d{3}))?( )?(\d{3}[\- ]?\d{2}[\- ]?\d{2})( +)?$/', $user_phone)){
    print('user_phone');
}
elseif(empty($user_email) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $user_email)){
    print('user_email');
}
else{
	print("1");
	$new_order = array(
		'Имя: ' => $user_name,
		'Телефон: '=> $user_phone,
		'E-mail: '=> $user_email,
		'Сообщение: '=> $user_text,
	);
	$from_name = 'order@'.$_SERVER['HTTP_HOST'];
	$from_email = 'order@'.$_SERVER['HTTP_HOST'];
	$subject = 'Заявка с сайта: '.$_SERVER['HTTP_HOST'];;
	
	$headers = get_html_headers($from_name, $from_email);
	$html_message = generate_html_message($subject, $new_order);
	
	$mail = mail ($mail_to, $subject, $html_message, $headers);
}