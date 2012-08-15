$(document).ready(function(){
    $("#naviMenu").load("menu.html",function(){
      $("#topNavigation li[name=gen]").addClass("active");
    });
    
  $(document).mousemove(function(e){
     __X = e.pageX;
     __Y = e.pageY;
  
  });  

  $("#progress01").ajaxStart(function(){
     $(this).css({position:"absolute",top:(__Y-50)+"px",left:(__X-50)+"px"});
     $(this).show();
  }).ajaxSuccess(function(){
          $(this).hide();
  });  
  
  $("button[name=removeImage]").click(function(){
    
    $(this).parent().parent().parent().remove();
    
  });  
  $("button[name=changeImage]").click(function(){

    var QObj = $("img[name=qust]",$(this).parent().parent().parent());
    var SObj = $("img[name=sol]",$(this).parent().parent().parent());
    var _url = QObj.attr("src");
    
    var quests = "";
    $("img[name=qust]").each(function(a,b){
      var deli = ",";
      if(a==0) deli="";
      quests = quests + deli + $(b).attr("id");
    });
    
	  param = {};
	  param["_method"]      = "m002";
	  param["qust_id"]      = QObj.attr('id');
	  param["crcr_id"]      = QObj.attr('crcr_id');
	  param["bunt_id"]      = QObj.attr('bunt_id');
    param["qust_surc_cd"] = QObj.attr('qust_surc_cd');
    param["qust_point"]   = QObj.attr('qust_point');
	  param["qusts"]        = quests;
	  
    jQuery.post("make.php",param,function(result,stat){
      
      var limg = result.rows[0].QUST_FILE_PATH + "/" + result.rows[0].QUST_Q_FILE;
      var rimg = result.rows[0].QUST_FILE_PATH + "/" + result.rows[0].QUST_A_FILE;

      QObj.attr('id',result.rows[0].QUST_ID);
      QObj.attr('crcr_id',result.rows[0].CRCR_ID);
      QObj.attr('bunt_id',result.rows[0].BUNT_ID);
      QObj.attr('qust_surc_cd',result.rows[0].QUST_SURC_CD);
      QObj.attr('qust_point',result.rows[0].QUST_POINT);


      var imgQ = new Image();
      imgQ.onload = function(){
         QObj.attr("src",limg)
         .attr("width",imgQ.width*(500/880))
         .attr("height",imgQ.height*(500/880));
      };
      imgQ.src = limg;

      var imgS = new Image();
      imgS.onload = function(){
         SObj.attr("src",rimg)
         .attr("width",imgS.width*(500/880))
         .attr("height",imgS.height*(500/880));
      };
      imgS.src = rimg;


/*      
      QObj.attr("src",limg).attr("width",400);
      SObj.attr("src",rimg).attr("width",400);
*/      
  	},"json");
  });

    $("button[name=makePdf]").click(function(){

    var QObj = $("img[name=qust]",$(this).parent().parent().parent());
    var SObj = $("img[name=sol]",$(this).parent().parent().parent());
    var _url = QObj.attr("src");
    
    var quests = "";
    $("img[name=qust]").each(function(a,b){

      var deli = ",";
      if(a==0) deli="";
      quests = quests + deli + $(b).attr("id");

    });

    var turl = 
           "&title01="+$("input[name=buf_title01]").val()
          +"&title02="+$("input[name=buf_title02]").val()
          +"&psize="  +$("select[name=buf_psize]").val();

 //get 방식
 
          window.open('helper.php?ptype=qust&quests='+quests+turl,"","top=0, left=0, status=no, scrollbars=yes, resizable=yes, width=800, height=700");
          window.open('helper.php?quests='+quests+turl,"","top=100, left=200, status=no, scrollbars=yes, resizable=yes, width=800, height=700");
 


 //post 방식 
 /*
          window.open("about:blank","popQuestion","top=0, left=0, status=no, scrollbars=yes, resiable=yes, width=1000, height=700");
          document.frmPDF.action = 'helper.php';
          document.frmPDF.target = "popQuestion"; 
          document.frmPDF.quests.value  = quests;
          document.frmPDF.title01.value = $("input[name=buf_title01]").val();
          document.frmPDF.title02.value = $("input[name=buf_title02]").val();
          document.frmPDF.psize.value   = $("select[name=buf_psize]").val();
          document.frmPDF.ptype.value   = 'qust'
          document.frmPDF.submit();

          
          
          
          window.open("about:blank","popSolustion","top=100, left=200, status=no, scrollbars=yes, resiable=yes, width=1000, height=700");
          sleep(10);
          document.frmPDF.action = 'helper.php';
          document.frmPDF.target = "popSolustion"; 
          document.frmPDF.ptype.value   = ''
          document.frmPDF.submit();
*/


  });


});
