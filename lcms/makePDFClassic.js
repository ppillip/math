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

  $("#topWork1").hide();
  $("input[type=checkbox][name=BUNT]").click(function(){
    if($(this).attr("checked")){
      $(this).parent().parent().css("background","#F5F5F5"); 
      $("select" ,$(this).parent().parent()).show();
    }
    else{
      $(this).parent().parent().css("background","white"); 
      $("select" ,$(this).parent().parent()).hide();
    }
  })
  
  $("button[id=makePdf]")
    .click(function(){
	    $("#topWork1").show();
	    $("#topInfo").hide();  	  	  
      var bunts = "";
      var qust_type = $("#qust_type").val();
  	  $("input[type=checkbox][name=BUNT]").each(function(a,b){
        if($(b).attr("checked")){
          var pObj = $(b).parent().parent();
          var bunt_id = $(b).attr("id");
      	  $("select",pObj).each(function(a1,b1){
            if($(b1).val()!=0){
              bunts = bunts + "#R" +  bunt_id + "#C" + qust_type + "#C" + $(b1).attr("name") + "#C" + $(b1).val();
            };
          });
        };
      });
  	  
  	  param = {};
  	  param["_method"] = "m003";
  	  param["qust_bunts"] = bunts;

      if(bunts==""){
         $("#topWork1").hide();
	       $("#topInfo").show();  	  
         return;
      }

  	  
  	  $("button[id=makePdf]").hide();
      jQuery.post("make2.php",param,function(result,stat){
      	if(!result.err){

      	  $("#topWork1").hide();
      	  $("#topWork2").show();
      	  document.frmComp.action = 'compositionClassic.php';
          document.frmComp.quests.value = result.msg;
          document.frmComp.submit();
        }
    	},"json");
   });

  $("button[id=makePdf2]")
	.click(function(){
	    $("#topWork1").show();
	    $("#topInfo").hide();  	  
      var bunts = "";
      var qust_type = $("#qust_type").val();
  	  $("input[type=checkbox][name=BUNT]").each(function(a,b){
        if($(b).attr("checked")){
          var pObj = $(b).parent().parent();
          var bunt_id = $(b).attr("id");
      	  $("select",pObj).each(function(a1,b1){
            if($(b1).val()!=0){
              bunts = bunts + "#R" +  bunt_id + "#C" + qust_type + "#C" + $(b1).attr("name") + "#C" + $(b1).val();
            };
          });
        };
      });
  	  alert(bunts);
  	  param = {};
  	  param["_method"] = "m004";
  	  param["qust_bunts"] = bunts;
      
      if(bunts==""){
         $("#topWork1").hide();
	       $("#topInfo").show();  	  
         return;
      }

      
	    $("#topWork1").show();
	    $("#topInfo").hide();  	  

  	  $("button[id=makePdf2]").hide();
      jQuery.post("make2.php",param,function(result,stat){
      	if(!!result){
      	  $("#topWork1").hide();
      	  $("#topWork2").show();

      	  localStorage.setItem("result",JSON.stringify( result ));

          document.location.href="compositionClassic.php";
          
        }
    	},"json");
  });   




  
});
