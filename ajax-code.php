<script>
function insertLike() {
       var xmlhttp;
       if(window.XMLHttpRequest) {
         xmlhttp = new XMLHttpRequest();
       } else {  
         xmlhttp = new ActiveXobject("Microsoft.XMLHTTP");
       } 
         
       xmlhttp.onreadystatechange = function() { 
         
         if(this.readyState == 4 & this.status == 200) { 
           document.getElementById("ajax").innerHTML = this.responseText;
         }
       } 
       xmlhttp.open("GET",'inc/post/like.php',true);
       xmlhttp.send();
     } 
                               
</script>