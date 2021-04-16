  <!-- Aqui empieza la notificación -->
  <?php 
    if (isset($_SESSION['message']) and $_SESSION['message']!="") {
        $msg=$_SESSION['content'];
        $a=$_SESSION['message'];
        if ($_SESSION['message']==='success'){
            echo '<script>
                alertify.success("'.$msg.'");
            </script>';
        }else{
            echo '<script>
                alertify.error("'.$msg.'");
            </script>';
        }
 $_SESSION['message']=''; } ?>
 <!-- Aqui termina la notificación -->