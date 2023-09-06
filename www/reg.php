<html>
<head>
<title>Smart Diary | Регистрация</title>
    <link rel="icon" type="image/ico" href="favicon.ico" />
 <link href="css/reset.css" media="all" rel="stylesheet" type="text/css" />
    <link href="css/front.css" media="all" rel="stylesheet" type="text/css" />
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
                        timeout: 2000,
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

    <div id="header">
        <h1 class="site-logo"><a href="index.php" class="pngfix">Smart Diary</a></h1>
       
    </div><!--End header -->
 <center>

 <div id="primary">
 <div class="feature-contentli">
<h1><a href="#">Регистрация</a></h1>
<form action="save_user.php" method="post" enctype="multipart/form-data">
<!-- save_user.php - это адрес обработчика. То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей отправятся на страничку save_user.php методом "post" -->
<p>
    <label><p class="subhead">Ваш уникальный код <font color=red>*</font>:<br></p></label>
    <input name="udid" type="text" size="20" maxlength="20">
  </p>
  <p>
    <label><p class="subhead">Ваше имя (ФИ) <font color=red>*</font>:<br></p></label>
    <input name="name" type="text" size="20" maxlength="20">
  </p>
<!-- В текстовое поле (name="name" type="text") пользователь вводит свое имя-->  
  <p>
  <p>
    <label><p class="subhead">Ваш логин <font color=red>*</font>:<br></p></label>
    <input name="login" type="text" size="20" maxlength="20">
  </p>
  <!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин --> 
 
    <label><p class="subhead">Ваш пароль <font color=red>*</font>:<br></p></label>
    <input name="password" type="password" size="20" maxlength="30">
  </p>
<!-- В поле для паролей (name="password" type="password") пользователь вводит свой пароль -->  
  <p>
    <label><p class="subhead">Ваш E-mail <font color=red>*</font>:<br></p></label>
    <input name="email" type="text" size="20" maxlength="100">
  </p>
<!-- Вводим е-майл -->  
  
  <p>
    <label><h3>Выберите аватар. Изображение должно быть формата jpg, gif или png:</h3></label>
    <input type="FILE" name="fupload">
  </p>
<!-- В переменную fupload отправится изображение, которое выбрал пользователь. --> 
<p><h3>Введите код с картинки *:<br></h3>

<p><img src="code/my_codegen.php"></p>
<p><input type="text" name="code"></p>
<!-- В code/my_codegen.php генерируется код и рисуется изображение --> 

<p>
<input type="submit" name="submit" value="Зарегистрироваться">
<!-- Кнопочка (type="submit") отправляет данные на страничку save_user.php  -->  
</p></form>
<p class="subhead">Звездочками <font color=red>(*)</font> обозначены поля, обязательные для заполнения.</p>
</div>
</div>
</body>
</html>
