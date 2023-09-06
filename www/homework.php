<?php
// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!

session_start();

include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
// это страница на которую переходят в конце
if (isset($_COOKIE['auto']) and isset($_COOKIE['login']) and isset($_COOKIE['password']))
{//если есть необходимые переменные
	if ($_COOKIE['auto'] == 'yes') { // если пользователь желает входить автоматически, то запускаем сессии
		  $_SESSION['password']=strrev(md5($_COOKIE['password']))."b3p6f"; //в куках пароль был не зашифрованный, а в сессиях обычно храним зашифрованный
		  $_SESSION['login']=$_COOKIE['login'];//сессия с логином
		  $_SESSION['name']=$_COOKIE['name'];//сессия с name
		  $_SESSION['id']=$_COOKIE['id'];//идентификатор пользователя
		}	
	}

if (!empty($_SESSION['login']) and !empty($_SESSION['password']))
{
//если существет логин и пароль в сессиях, то проверяем их и извлекаем аватар
$login = $_SESSION['login'];
$name = $_SESSION['name'];
$password = $_SESSION['password'];
$result = mysql_query("SELECT id,avatar FROM users WHERE login='$login' AND password='$password' AND activation='1'",$db); 
$myrow = mysql_fetch_array($result);
//извлекаем нужные данные о пользователе
}
?> <link href="css/reset.css" media="all" rel="stylesheet" type="text/css" />
    <link href="css/front.css" media="all" rel="stylesheet" type="text/css" />
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style type="text/css">
      <? include "front.css" ?>
  </style>
    <title>Smart Diary </title>
    <link rel="icon" type="image/ico" href="favicon.ico" />

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="css/ie.css" />
    <script type="text/javascript" src="js/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('.pngfix'); </script>
    <![endif]--> 
   
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.innerfade.js"></script>
    
    <script type="text/javascript">
       $(document).ready(
                function(){
                    $('#fade').innerfade({
                        animationtype: 'fade',
                        speed: 'slow',
                        timeout: 2500,
                        type: 'sequence',
                        containerheight: '261px',
                        runningclass: 'innerfade'
                    });          
            });
      </script>
</head>
<body class="front">
<div class="top-bar"></div><!--End top-bar -->
<div id="container">


        
  
  
<?php
if (!isset($myrow['avatar']) or $myrow['avatar']=='') {
//проверяем, не извлечены ли данные пользователя из базы. Если нет, то он не вошел, либо пароль в сессии неверный. Выводим окно для входа. Но мы не будем его выводить для вошедших, им оно уже не нужно.
print <<<HERE
   <div id="header">
        <h1 class="site-logo"><a href="index.php" class="pngfix">Smart Diary</a></h1>
       
    </div><!--End header -->
 <center>
    <div id="primary">
<div class="scroller">
                <ul id="fade">
                    <li><img src="files/slider-1.png" alt="First Scroller Image" /></li>
                    <li><img src="files/slider-2.png" alt="Second Scroller Image" /></li> 
                    <li><img src="files/slider-3.png" alt="Third Scroller Image" /></li> 
                </ul>
        </div><!--End scroller-->
		<div class="feature-content">
<form action="testreg.php" method="post">
<!-- testreg.php - это адрес обработчика. То есть, после нажатия на кнопку "Войти", данные из полей отправятся на страничку testreg.php методом "post"  -->
  <h1><a href="#">Авторизация</a></h1>
  <p class="subhead">
    <label>Ваш логин:</label></p>
	<input name="login" type="text" size="15" maxlength="15"
	
HERE;

	
if (isset($_COOKIE['login'])) //есть ли переменная с логином в COOKIE. Должна быть, если пользователь при предыдущем входе нажал на чекбокс "Запомнить меня"
{
//если да, то вставляем в форму ее значение. При этом пользователю отображается, что его логин уже вписан в нужную графу
echo ' value="'.$_COOKIE['login'].'">';
}


print <<<HERE
  </p>
<!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин -->  
  <p>
   <p class="subhead"><label>Ваш пароль:</label></p>
    <input name="password" type="password" size="15" maxlength="15"
	</div>
HERE;

	
if (isset($_COOKIE['password']))//есть ли переменная с паролем в в COOKIE. Должна быть, если пользователь при предыдущем входе нажал на чекбокс "Запомнить меня"
{
//если да, то вставляем в форму ее значение. При этом пользователю отображается, что его пароль уже вписан в нужную графу
echo ' value="'.$_COOKIE['password'].'">';
}
	
print <<<HERE
  </p>
<!-- В поле для паролей (name="password" type="password") пользователь вводит свой пароль -->  
  
<br><input name="save" type="checkbox" value='1'> <font color=#b3b496 face=Tahoma>Запомнить меня.</font><br>
<input name="autovhod" type="checkbox" value='1'> <font color=#b3b496 face=Tahoma>Автоматический вход.</font>


<p>
<br><input type="submit" name="submit" value="Войти">
<!-- Кнопочка (type="submit") отправляет данные на страничку testreg.php  --> 
<br>
<!-- ссылка на регистрацию, ведь как-то же должны гости туда попадать  --> 
<a href="reg.php">Зарегистрироваться</a> 

<br>
<!-- ссылка на восстановление пароля  --> 
<a href="send_pass.php">Забыли пароль?</a> 

</p></form>

<br>
Вы вошли на сайт, как гость<br>
</center>
HERE;

}

else
{

	print <<<HERE

	
	 <div id="header">
	
        <h1 class="site-logo"><a href="index1.php" class="pngfix">Smart Diary</a></h1>
		
            
	<center>
        <div id="navigation">
            <ul>
                
                <li><a href="index.php">
                <img src="u1.png" alt="Home" width="91" height="27" border="0">
                </a></li>
               
               
                <li><a href="ej.php"> 
                <img src="u3.png" alt="EJ" width="91" height="27" border="0">
                </a></li>
               
              
                <li><a href="homework.php">
                <img src="u2.png" alt="Homework" width="91" height="27" border="0">
                </a></li>
				
				
				
		 <li><a href='page.php?id=$_SESSION[id]'>
                <img src="u5.png" alt="Me" left="20" width="91" height="27" border="0" >
                </a></li>
               
               
                <li><a href='all_users.php'> 
                <img src="u6.png" alt="Users" width="91" height="27" border="0">
                </a></li></h1>
               
              
                <li><a href='exit.php'>
                <img src="u7.png" alt="Exit" width="91" height="27" border="0">
                </a></li></h1>
				
				</ul><br>
            
        </div><!--End navigation --> 

			  
       </center>
    </div><!--End header -->
	<center>
	<div id="Schedule">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td />
                    <td class='d0'>
                        <div>
                            Понедельник</div>
                    </td>
                    <td class='d1'>
                        <div>
                            Вторник</div>
                    </td>
                    <td class='d2'>
                        <div>
                            Среда</div>
                    </td>
                    <td class='d3'>
                        <div>
                            Четверг</div>
                    </td>
                    <td class='d4'>
                        <div>
                            Пятница</div>
                    </td>
                    <td class='d5'>
                        <div>
                            Суббота</div>
                    </td>

                </tr>
            </thead>
            <tbody>
                <tr class='h7'>
                    <td>
                        <div>
                            08:35
                        </div>
                    </td>

                    <td class='d0'>
                        <div ><center>
						Химия
                        </center></div>
		                   </td>
                    <td class='d1'>
                        <div>
						<center>
						Труд</center>
                        </div>
                    </td>
                    <td class='d2'>

                        <div>
						<center>
						Изо
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						История
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
Англ.яз
</center>
                        </div>
                    </td>
                    <td class='d5'>
                        <div>
						<center>
						-н-
						</center>
                        </div>
                    </td>

                    </td>
                </tr>
                <tr class='h8'>
                    <td>
                        <div>
                            09:15
                        </div>
                    </td>
                    <td class='d0'>

                        <div>
						<center>
						Ин.язык
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Труд
						</center>
                        </div>
                    </td>
                    <td class='d2'>
                        <div>
<center>
						География
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Биология
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
						Русс.яз.
						</center>
                        </div>

                    </td>
                    <td class='d5'>
                        <div>
<center>
						Русс.яз.
						</center>
                       </div>
                    </td>


                </tr>
                
                
                 <tr class='h9'>
                    <td class=''>
                        <div>
                            10:10
                        </div>

                    </td>
                    <td class='d0'>
                        <div>
						<center>
						Геометрия
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Алгебра
						</center>
                        </div>
                    </td>

                    <td class='d2'>
                        <div>
						<center>
						Физика
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Физ-ра
						</center>
                        </div>
                    </td>
                    <td class='d4'>

                        <div>
						<center>
						Лит-ра
						</center>
                        </div>
                    </td>
                    <td class='d5'>
                        <div>
						<center>
						ИКТ и Инф.
						</center>
                        </div>
                    </td>

                </tr>
                <tr class='h10'>
                    <td>
                        <div>
                            11:05
                        </div>
                    </td>
                    <td class='d0'>

                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d2'>
                        <div>
<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>

                    </td>
                    <td class='d5'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>


                </tr>
                
                
                
                  <tr class='h11'>
                    <td>
                        <div>
                            12:10
                        </div>
                    </td>
                    <td class='d0'>

                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d2'>
                        <div>
<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>

                    </td>
                    <td class='d5'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>


                </tr>
                
                  <tr class='h12'>
                    <td>
                        <div>
                            13:15
                        </div>
                    </td>
                    <td class='d0'>

                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d2'>
                        <div>
<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>

                    </td>
                    <td class='d5'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>


                </tr>
                
                
                  <tr class='h13'>
                    <td>
                        <div>
                            14:15
                        </div>
                    </td>
                    <td class='d0'>

                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d2'>
                        <div>
<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>

                    </td>
                    <td class='d5'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>


                </tr>
                
                
                
                  <tr class='h14'>
                    <td>
                        <div>
                            15:15
                        </div>
                    </td>
                    <td class='d0'>

                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d2'>
                        <div>
<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>

                    </td>
                    <td class='d5'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>


                </tr>
                
                
                
                  <tr class='h15'>
                    <td>
                        <div>
                            16:10
                        </div>
                    </td>
                    <td class='d0'>

                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d1'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d2'>
                        <div>
<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d3'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>
                    <td class='d4'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>

                    </td>
                    <td class='d5'>
                        <div>
						<center>
						Русс.язык
						</center>
                        </div>
                    </td>


                </tr>
                
                
                 

                </tr>
                
              
            </tbody>
        </table>
    </div><!--End feature-content -->
    </div><!--End primary -->
</div> <!--End container -->

HERE;
}

?>


</body>
</html>
