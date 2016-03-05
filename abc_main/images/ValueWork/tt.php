<html> 
<head> 
</head> 
<body> 
<form name="f1"> 
  <p><input type="checkbox" name="C1" value="111">111</p> 
  <p><input type="checkbox" name="C1" value="222">222</p> 
  <p><input type="checkbox" name="C1" value="333">333</p> 
  <p><input type="button" value="按鈕" name="B1" onClick="getValue();"></p> 
</form> 
</body> 
</html> 
<script> 
function getValue() { 
   var str=""; 
   for (var i=0;i<=document.f1.C1.length-1;i++) 
      if (document.f1.C1[i].checked) 
         str=str+document.f1.C1[i].value+" "; 
   alert(str); 
   }    
</script>