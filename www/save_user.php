<?php

if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //������� ��������� ������������� ����� � ���������� $login, ���� �� ������, �� ���������� ����������
if (isset($_POST['name'])) { $name = $_POST['name']; if ($name == '') { unset($name);} } //������� ��������� ������������� name � ���������� $name, ���� �� ������, �� ���������� ����������
if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
//������� ��������� ������������� ������ � ���������� $password, ���� �� ������, �� ���������� ����������
if (isset($_POST['code'])) { $code = $_POST['code']; if ($code == '') { unset($code);} } //������� ��������� ������������� �������� ��� � ���������� $code, ���� �� ������, �� ���������� ����������

if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } //������� ��������� ������������� e-mail, ���� �� ������, �� ���������� ����������


if (empty($login) or empty($name) or empty($password) or empty($code) or empty($email)) //���� ������������ �� ���� ����� ��� ������, �� ������ ������ � ������������� ������
{
exit ("�� ����� �� ��� ����������, ��������� ����� � ��������� ��� ����!"); //������������� ���������� ���������

}
if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $email)) //�������� �-mail ������ ����������� ����������� �� ������������
{exit ("������� ������ �-mail!");}


function generate_code() //��������� �������, ������������ ���
{
                
    $hours = date("H"); // ���       
    $minuts = substr(date("H"), 0 , 1);// ������ 
    $mouns = date("m");    // �����             
    $year_day = date("z"); // ���� � ����

    $str = $hours . $minuts . $mouns . $year_day; //������� ������
    $str = md5(md5($str)); //������ ������� � md5
	$str = strrev($str);// ������ ������
	$str = substr($str, 3, 6); // ��������� 6 ��������, ������� � 3
	// ��� ������� �� ����� ��������� ������ ��������, ��� ���, ���� ��������� ������, ����� ������ �������� ��� ��� ������������, �� � ������ �� ����� ������.
	

    $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
    srand ((float)microtime()*1000000);
    shuffle ($array_mix);
	//��������� ������������, ����, ����� �� �����!!!
    return implode("", $array_mix);
}

function chec_code($code) //��������� ���
{
    $code = trim($code);//������� �������

    $array_mix = preg_split ('//', generate_code(), -1, PREG_SPLIT_NO_EMPTY);
    $m_code = preg_split ('//', $code, -1, PREG_SPLIT_NO_EMPTY);

    $result = array_intersect ($array_mix, $m_code);
if (strlen(generate_code())!=strlen($code))
{
    return FALSE;
}
if (sizeof($result) == sizeof($array_mix))
{
    return TRUE;
}
else
{
    return FALSE;
}
}

// ����� ��������� ���������, ������� �� ������������ ������ ���, �� ������ ������, � ���������� ������
if (!chec_code($_POST['code']))
{
exit ("�� ����� ������� ��� � ��������."); //������������� ���������� ���������
}


//���� ����� � ������,name �������,�� ������������ ��, ����� ���� � ������� �� ��������, ���� �� ��� ���� ����� ������
$login = stripslashes($login);
$login = htmlspecialchars($login);

$password = stripslashes($password);
$password = htmlspecialchars($password);

$name = stripslashes($name);
$name = htmlspecialchars($name);
//������� ������ �������
$login = trim($login);
$password = trim($password);
$name = trim($name);

// ���������� �����********************************************

//��������� �������� �� ����� ������ � ������
if (strlen($login) < 3 or strlen($login) > 15) {

exit ("����� ������ �������� �� ����� ��� �� 3 �������� � �� ����� ��� �� 15."); //������������� ���������� ���������

}
if (strlen($password) < 6 or strlen($password) > 15) {

exit ("������ ������ �������� �� ����� ��� �� 6 �������� � �� ����� ��� �� 15."); //������������� ���������� ���������

}

if (empty($_FILES['fupload']['name']))
{
//���� ���������� �� ���������� (������������ �� �������� �����������),�� ����������� ��� ������� �������������� �������� � �������� "��� �������"
$avatar = "avatars/net-avatara.jpg"; //������ ���������� net-avatara.jpg ��� ����� � ����������
}

else 
{
//����� - ��������� ����������� ������������
$path_to_90_directory = 'avatars/';//�����, ���� ����� ����������� ��������� �������� � �� ������ �����

	
if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//�������� ������� ��������� �����������
	 {	
	 	 	
		$filename = $_FILES['fupload']['name'];
		$source = $_FILES['fupload']['tmp_name'];	
		$target = $path_to_90_directory . $filename;
		move_uploaded_file($source, $target);//�������� ��������� � ����� $path_to_90_directory

	if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
	$im = imagecreatefromgif($path_to_90_directory.$filename) ; //���� �������� ��� � ������� gif, �� ������� ����������� � ���� �� �������. ���������� ��� ������������ ������
	}
	if(preg_match('/[.](PNG)|(png)$/', $filename)) {
	$im = imagecreatefrompng($path_to_90_directory.$filename) ;//���� �������� ��� � ������� png, �� ������� ����������� � ���� �� �������. ���������� ��� ������������ ������
	}
	
	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
		$im = imagecreatefromjpeg($path_to_90_directory.$filename); //���� �������� ��� � ������� jpg, �� ������� ����������� � ���� �� �������. ���������� ��� ������������ ������
	}
	
//�������� ����������� ����������� � ��� ����������� ������ ����� � ����� www.codenet.ru

// �������� �������� 90x90
// dest - �������������� ����������� 
// w - ������ ����������� 
// ratio - ����������� ������������������ 

$w = 90;  // ���������� 90x90. ����� ��������� � ������ ������.

// ������ �������� ����������� �� ������ 
// ��������� ����� � ���������� ��� ������� 
$w_src = imagesx($im); //��������� ������
$h_src = imagesy($im); //��������� ������ �����������

         // ������ ������ ���������� �������� 
         // ����� ������ truecolor!, ����� ����� ����� 8-������ ��������� 
         $dest = imagecreatetruecolor($w,$w); 

         // �������� ���������� ��������� �� x, ���� ���� �������������� 
         if ($w_src>$h_src) 
         imagecopyresampled($dest, $im, 0, 0,
                          round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                          0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 

         // �������� ���������� �������� �� y, 
         // ���� ���� ������������ (���� ����� ���� ���������) 
         if ($w_src<$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,
                          min($w_src,$h_src), min($w_src,$h_src)); 

         // ���������� �������� �������������� ��� ������� 
         if ($w_src==$h_src) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 
		 

$date=time(); //��������� ����� � ��������� ������.
imagejpeg($dest, $path_to_90_directory.$date.".jpg");//��������� ����������� ������� jpg � ������ �����, ������ ����� ������� �����. �������, ����� � �������� �� ���� ���������� ����.

//������ ������ jpg? �� �������� ����� ���� ����� + ������������ ������������ gif �����������, ������� ��������� ������������. �� ����� ������� ������ ��� �����������, ����� ����� ����� ��������� �����-�� ��������.

$avatar = $path_to_90_directory.$date.".jpg";//������� � ���������� ���� �� �������.

$delfull = $path_to_90_directory.$filename; 
unlink ($delfull);//������� �������� ������������ �����������, �� ��� ������ �� �����. ������� ���� - �������� ���������.
}
else 
         {
		 //� ������ �������������� �������, ������ ��������������� ���������
         
exit ("������ ������ ���� � ������� <strong>JPG,GIF ��� PNG</strong>"); //������������� ���������� ���������

	     }
//����� �������� �������� � ���������� ���������� $avatar ������ ����������� ���
}

$password = md5($password);//������� ������

$password = strrev($password);// ��� ���������� ������� ������

$password = $password."b3p6f";
//����� �������� ��������� ����� �������� �� �����, ��������, ������ "b3p6f". ���� ���� ������ ����� ���������� ������� ������� � ���� �� ������� ���� �� md5,�� ���� ������ �������� �� ������. �� ������� ������� ������ �������, ����� � ������ ������ ��� � ��������.

//��� ���� ���������� ��������� ����� ���� password � ����. ������������� ������ ����� ��������� ������� �������� �������.


// �������� �����********************************************

// ����� ���� ��� �� ������ ����� ������,�� ���������� �������� ��������� � ������ � ����. 

// ������������ � ����
include ("bd.php");// ���� bd.php ������ ���� � ��� �� �����, ��� � ��� ���������, ���� ��� �� ���, �� ������ �������� ���� 

// �������� �� ������������� ������������ � ����� �� �������
$result = mysql_query("SELECT id FROM users WHERE login='$login'",$db);
$myrow = mysql_fetch_array($result);
if (!empty($myrow['id'])) {

exit ("��������, �������� ���� ����� ��� ���������������. ������� ������ �����."); //������������� ���������� ���������

}

// ���� ������ ���, �� ��������� ������
$result2 = mysql_query ("INSERT INTO users (login,name,password,avatar,email,date) VALUES('$login','$name','$password','$avatar','$email',NOW())");
// ���������, ���� �� ������
if ($result2=='TRUE')
{

$result3 = mysql_query ("SELECT id FROM users WHERE login='$login'",$db);//��������� ������������� ������������. ��������� ��� � ��� � ����� ���������� ��� ���������, ���� ���� ���������� ��������������� ���� �� �����.
$myrow3 = mysql_fetch_array($result3);
$activation = md5($myrow3['id']).md5($login);//��� ��������� ��������. ��������� ����� ������� md5 ������������� � �����. ����� ��������� ������������ ���� �� ������ ��������� ������� ����� �������� ������.

$subject = "������������� �����������";//���� ���������
$message = "������������! ������� �� ����������� �� smartdiary.ru\n��� �����: ".$login."\n
��������� �� ������, ����� ������������ ��� �������:\n http://localhost/test3/activation.php?login=".$login."&code=".$activation."\n� ���������,\n
������������� smartdiary.ru";//���������� ���������
mail($email, $subject, $message, "Content-type:text/plane; Charset=windows-1251\r\n");//���������� ���������
	
echo "��� �� E-mail ������� ������ � c������, ��� ������������� �����������. ��������! ������ ������������� 1 ���. <a href='index.php'>������� ��������</a>"; //������� � ������������ ������ ������������
}

else {
exit ("������! �� �� ����������������."); //������������� ���������� ���������

     }
?>