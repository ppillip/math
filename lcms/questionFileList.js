this.imagePreview = function(){
  /* CONFIG */
		
		xOffset = 10;
		yOffset = 30;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	$("a.preview").hover(function(e){
		this.t = this.title;
		this.title = "";	
		var c = (this.t != "") ? "<br/>" + this.t : "";
		$("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");								 
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");						
    },
	function(){
		this.title = this.t;	
		$("#preview").remove();
    });	
	$("a.preview").mousemove(function(e){
		$("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};




$(document).ready(function(){
// starting the script on page load
	imagePreview();



	$("#dbProcess").click(function(){
      $("<div id='tmpxxx'>작업중 지루해도 기다리세요..<br>컴퓨터로 다른 작업을 삼가 하세요..</div>").insertAfter($("#dbProcess"));
      $("#dbProcess").hide();

    	var param = {};
    	param["_method"] = "L001";
    	param["crcr_id"] = _crcr_id;
    	param["bunt_id"] = _bunt_id;

    	jQuery.post("lcms.php",param,function(data){
    	  $("#dbProcess").show();
    	  $("#tmpxxx").remove();
    		if(data.err==false){
    		  alert( data.msg );
    		  window.close();
    		  opener.location.reload();
    		}else{
    			alert("에러 : " + data.msg)
    		}
    	},"json");		

	});
	
});