<?php
if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //������� ��������� ������������� ����� � ���������� $login, ���� �� ������, �� ���������� ����������

if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } //������� ��������� ������������� e-mail, ���� �� ������, �� ���������� ����������

if (isset($login) and isset($email)) {//���� ���������� ����������� ����������  
	
	include ("bd.php");// ���� bd.php ������ ���� � ��� �� �����, ��� � ��� ���������, ���� ��� �� ���, �� ������ �������� ���� 
	
	$result = mysql_query("SELECT id FROM users WHERE login='$login' AND email='$email' AND activation='1'",$db);//����� �� � ������������ �-����
	$myrow = mysql_fetch_array($result);
	if (empty($myrow['id']) or $myrow['id']=='') {
		//���� ��������������� ������������ � ����� ������� � �-mail ������� ���
		exit ("������������ � ����� e-mail ������� �� ���������� �� � ����� ���� ��� :) <a href='index.php'>������� ��������</a>");
		}
	//���� ������������ � ����� ������� � �-������ ������, �� ���������� ������������� ��� ���� ��������� ������, �������� ��� � ���� � ��������� �� �-����
	$datenow = date('YmdHis');//��������� ���� 
	$new_password = md5($datenow);// ������� ����
	$new_password = substr($new_password, 2, 6);	//��������� �� ����� 6 �������� ������� �� �������. ��� � ����� ��� ��������� ������. ����� ������� ��� � ����, ���������� ����� ��� ��, ��� � ������.
	
$new_password_sh = strrev(md5($new_password))."b3p6f";//�����������
mysql_query("UPDATE users SET password='$new_password_sh' WHERE login='$login'",$db);// �������� � ����
	//��������� ���������
	
	$message = "������������, ".$login."! �� ��������������� ��� ��� ������, ������ �� ������� ����� �� ���� smartdiary.ru, ��������� ���. ����� ����� ���������� ��� �������. ������:\n".$new_password;//����� ���������
	mail($email, "�������������� ������", $message, "Content-type:text/plane; Charset=windows-1251\r\n");//���������� ���������
	
	echo "<html><head><meta http-equiv='Refresh' content='5; URL=index.php'></head><body>�� ��� e-mail ���������� ������ � �������. �� ������ ���������� ����� 5 ���. ���� �� ������ �����, �� <a href='index.php'>������� ����.</a></body></html>";//�������������� ������������
	}


else {//���� ������ ��� �� �������
echo '
<html>
<head>
<title>Smart Diary | ������ ������?</title>
<link rel="icon" type="image/ico" href="favicon.ico" />
 <link href="css/reset.css" media="all" rel="stylesheet" type="text/css" />
    <link href="css/front.css" media="all" rel="stylesheet" type="text/css" />

</head>
<body class="front">
<div class="top-bar"></div><!--End top-bar -->
<div id="container">

    <div id="header">
        <h1 class="site-logo"><a href="index.php" class="pngfix">Smart Diary</a></h1>
       
    </div><!--End header -->
 <center>

 <div id="primary">
 <div class="feature-contentli">
<h1><a href="#">������ ������?</a></h1>
<form action="#" method="post">
 <label><p class="subhead">������� ��� �����:<br> <input type="text" name="login"><br></label>
 <label><p class="subhead">������� ��� E-mail: <br><input type="text" name="email"><br></p></label>
<input type="submit" name="submit" value="���������">
</form>
</center>
</body>
</html>';
}

?>