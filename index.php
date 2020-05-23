<?php
    include 'functions.php';
    include 'LoginSystem.class.php';
  
  if(isset($_POST['Submit']))
  {
    if((!$_POST['Username']) || (!$_POST['Password']))
    {
      // display error message
      header('location: index.php?msg=1');// show error
      exit;
    }
    
    $loginSystem = new LoginSystem();
    if($loginSystem->doLogin($_POST['Username'],$_POST['Password']))
    {      
        redirect("home.php");
    }
    else
    {
      redirect("index.php?msg=2");
      exit;
    }    
  }
?>

<!DOCTYPE html> 
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]--> 
<html class="no-js" lang="en" > 
<head> 
  <meta charset="utf-8"> 
  <!-- If you delete this meta tag World War Z will become a reality --> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Web Mala</title> 
  <!-- If you are using the CSS version, only link these 2 files, you may add app.css to use for your overrides if you like --> 
  <link rel="stylesheet" href="css/normalize.css"> 
  <link rel="stylesheet" href="css/foundation.css"> 

  <script src="js/vendor/modernizr.js"></script> 
</head> 
<body> 
    <?php include_once 'cabeca.php'; ?>
  
    
      <div class="panel">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        
        <div class="row">
          <div class="medium-1 columns">
            <label>Usuario</label>
          </div>
          <div class="medium-11 columns">
            <input type="text" placeholder="Usuario" name="Username" autofocus/>
          </div>
        </div>


        <div class="row">
          <div class="medium-1 columns">
            <label>Senha</label>
          </div>
          <div class="medium-9 columns">
            <input type="password" placeholder="Senha" name="Password"/>
          </div>
          <div class="medium-2 columns">
            <input name="Submit" type="submit" class="button tiny round" value="Login"/>
          </div>
        </div>
      </form>
        <div class="row">
          <div class="small-1 columns">&nbsp</div>
          <div class="small-11 columns">
            <?php
            if(isset($_GET['msg']))
            {
              switch($_GET['msg'])
              {        
                case 1: echo "<span class='secondary round label'>Por favor preencha os dois campos.</span>";
                break;

                case 2: echo "<span class='alert round label'>Usuario ou Senha Incorreto</span>";
                break;
              }
            }
            ?>
          </div>    
          <!-- <div class="small-6 columns">&nbsp</div> -->
        </div>
      </div>
    
 

  <script src="js/vendor/jquery.js"></script> 
  <script src="js/foundation.min.js"></script> 
  <script> $(document).foundation(); </script> 
</body> 
</html>