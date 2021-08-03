$(document).ready(function(e){
                $("#Chat").on('submit', function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'inc/chat/send.php',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success:function(data){
                        $('#Success').html(data); 
                     }
                    });
                }); 

                //file type validation
                $("#img").change(function() {
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match= ["image/jpeg","image/png","image/jpg","image/Gif"];
                    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
                        alert('(JPEG/JPG/PNG/Gif) من فضلك ادخل نوع ملف مدعوم ');
                        $("#img").val('');
                        return false;
                    }
                });
            });
/*
 setInterval(function(){
     $('#notification').load('inc/notification/count.php?id=<?php echo $_SESSION['id']; ?>');
    },2000);  