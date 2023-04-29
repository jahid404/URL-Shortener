<?php 
  include 'php/config.php';
  $new_url = "";
  if(isset($_GET)){
    foreach($_GET as $key=>$val){
      $u = mysqli_real_escape_string($conn, $key);
      $new_url = str_replace('/', '', $u);
    }
      $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
      if(mysqli_num_rows($sql) > 0){
        $sql2 = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
        if($sql2){
            $full_url = mysqli_fetch_assoc($sql);
            header("Location:".$full_url['full_url']);
          }
      }
  }
  
  $sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
  $res = mysqli_fetch_assoc($sql3);
  
  $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
  $total = 0;
  while($count = mysqli_fetch_assoc($sql4)){
    $total = $count['clicks'] + $total;
  }
  
  $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" >
  <title>AiToolsCollection | URL Shortener</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
</head>
<body>
  <div class="wrapper">
    <form action="#" autocomplete="off">
      <input type="text" spellcheck="false" name="full_url" placeholder="Enter url here..." required>
      <i class="url-icon uil uil-link"></i>
      <button>Shorten</button>
    </form>
    <?php if(mysqli_num_rows($sql2) > 0){;?>
          <div class="statistics">
            <span>Total Links: <span><?php echo end($res) ?></span> & Total Clicks: <span><?php echo $total ?></span></span>
            <a href="php/delete.php?delete=all"><span class="delURL" >Clear All</span></a>
        </div>
          <?php while($row = mysqli_fetch_assoc($sql2)){?>
                <div class="data">
                <ul>
	                <li><span class="title">Shorten URL:</span>
	                  <a href="<?php echo $domain.$row['shorten_url'] ?>" target="_blank">
	                  <?php if($domain.strlen($row['shorten_url'])>50){echo $domain.substr($row['shorten_url'], 0, 50) . '...';}else{echo $domain.$row['shorten_url'];}?>
	                  </a>
	                </li> 
	                <li><span class="title">Original URL:</span>
	                  <?php if(strlen($row['full_url'])>60){echo substr($row['full_url'], 0, 60) . '...';}else{echo $row['full_url'];}?>
	                </li> 
	              </li>
	                <li><span class="title">Clicks:</span><?php echo $row['clicks'] ?></li>
	                <li><a href="php/delete.php?id=<?php echo $row['shorten_url'] ?>"><span class="delURL">Delete</span></a></li>
              	</ul>
              </div>
              <?php }?>
      </div>
        <?php }?>
  </div>

  <div class="blur-effect"></div>
  <div class="popup-box">
  <div class="info-box">Your short link is ready.</div>
  <form action="#" autocomplete="off">
    <label>Edit your shorten url</label>
    <input type="text" class="shorten-url" spellcheck="false" required>
    <i class="copy-icon uil uil-copy-alt"></i>
    <button>Save</button>
  </form>
  </div>

  <script src="script.js"></script>

</body>
</html>