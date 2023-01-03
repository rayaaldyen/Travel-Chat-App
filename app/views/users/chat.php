<?php 
  // session_start();
  if(!isset($_SESSION['id'])){
    header("location: http://localhost/proakhir/public/user/login");
  }
?>
<!DOCTYPE html>
<html lang="en";>
    <head>
        <meta charset="UTF-8">
        <meta name="view" content="width=device-width, initial-scale=1.0"> 
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Instant Tour Chat</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/proakhir/public/css/style1.css" />
       
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    </head>
<body>

       
        
  <div class="layer">
    <section class="chat-place">
      <header>
        <?php 
        ?>
        <a href="http://localhost/proakhir/public/user/back" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="http://localhost/proakhir/public/img/<?php echo $data['foto']; ?>" alt="">
        <div class="info">
          <span><?php echo $data['namdep']. " " . $data['nambel'] ?></span>
          <p><?php echo $data['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="tulis-pesan">
        <input type="text" class="pesanMasuk_id" name="pesanMasuk_id" value="<?php echo $data['id']; ?>" hidden>
        <input type="text" name="pesan" class="input-field" placeholder="Tulis pesan..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>
  <script src="http://localhost/proakhir/public/js/chat.js"></script>

</body>
</html>
