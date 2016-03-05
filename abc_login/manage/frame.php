<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>主控台</title>
    <link type="text/css" href="menu.css" rel="stylesheet" />
    <!--放在js資料裡的檔案叫jquery跟menu，jquery可能要改-->
    <script type="text/javascript" src="./jquery.js"></script>
</head>
<body>

<style type="text/css">
* { margin:0;
    padding:0;
}               
html { 

}   /*最外層背景的顏色*/
body {
    margin:40px auto; /*沒auto的話，區塊會跑到左邊，但還不曉得為啥*/
    background:none;  /*body是黑色那塊*/   
    overflow:hidden;  /*隱藏溢出範圍的內容*/
} 
/*用div包起iframe那塊的css，為了放統一背景*/
div#iframe {
    position: relative; top:20px; left:250px; /*移動iframe區塊*/
    width:1000px; height:1000px;
    background:transparent; /*這行目前好像沒必要，但還是留著*/
}
</style>

 <div id="iframe">
    <iframe 
      name="show" src="../control/timeset.php" allowtransparency="true"
      scrolling="auto" width="100%" height="100%" border="0" frameborder="0">
    </iframe>
</div>

</body>
</html>