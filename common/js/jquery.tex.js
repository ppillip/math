$.extend({
						texEditor:{
							
							/*에디터의 유일값을 설정 한다.*/
							_getEditorID     : function(Handle){
								return "cmTexEditor_"+Handle;
							},
							_getEditorByHandle: function(Handle){
								return $.texEditor._getEditor( $.texEditor._getEditorID(Handle) );
							},							
							_hideEdit : function(edtid){
								$("div[id="+edtid+"]").hide();
								$.texEditor._clearEditor(edtid);
							},
							_showEdit : function(Handle,_x,_y,_time){
								$("div[id^=cmTexEditor]").hide();
								$("div[id=cmTexEditor_"+Handle+"]").fadeIn(_time).css({left:_x,top:_y});
							},
							_getEditor : function(edtid){
								return $("div[id="+edtid+"]");
							},
							_getEditorBox : function(edtid){ //에디터의 full id 
								return $("input[id=cmLatexCD]", $.texEditor._getEditor(edtid));
							},
							_getEditorTex : function(edtid){ //에디터의 full id 
								return $("input[id=cmLatexCD]", $.texEditor._getEditor(edtid)).val();
							},
							_getEditorImgPath : function(edtid){ //에디터의 full id 
								return $("input[id=cmImgUrl]", $.texEditor._getEditor(edtid)).val();
							},
							_clearEditor : function(edtid){ //에디터의 full id
							  $("input[id=cmLatexCD]"  , $.texEditor._getEditor(edtid)).val("");
								$("input[id=cmImgUrl]"   , $.texEditor._getEditor(edtid)).val("");
								$("div[id=cmSampleView]" , $.texEditor._getEditor(edtid)).html("");		
							},							
							_getLcmsTexShortCut : function (edtid,grp_id,callback){
								var param = {} ;
								param["_method"] = "q001";
								param["grp"] = grp_id;
                //TO DO "/mast/admin/shortcut.php" 를 lcms 추가 개발
								$.post("/mast/admin/shortcut.php",param,function(result){
								   $(result.rows).each(function(idx,obj){
								   	row=obj;
								    $("<td width='40px' align=center>"+htmlspecialchars_decode(row.SHKT_HTM,'ENT_QUOTES')+"</td>")
										.data("SHKT_ID",row.SHKT_ID)
										.data("SHKT_LTX",row.SHKT_LTX)
										.data("SHKT_SRT",row.SHKT_SRT)
										.data("SHKT_HTM",row.SHKT_HTM)
										.data("SHKT_SCHWORD",row.SHKT_SCHWORD)
										.data("SHKT_EDT_LTX",row.SHKT_EDT_LTX)
										.data("SHKT_GRP",row.SHKT_GRP)
								    .appendTo($("div[id=cmTexLCMS] tr[id=texgrp0"+grp_id+"]",$.texEditor._getEditor(edtid)))
								    .click(function(){
								    	$.texEditor._putTex(edtid, $(this).data("SHKT_LTX") ,"latexcd" );
								    })
								    .css("cursor","hand");
								   });
								   
								   if(typeof(callback)=='function'){callback();}
								},"json");
							},//_getLcmsTexShortCut
							/*단축키가 텍스트 박스에 밀어 넣기*/
							//TODO : 텍스트 seletrange 잡아서 하기
							_putTex : function (edtid,t_code,t_type){
								$_txt = $.texEditor._getEditorBox(edtid);
								$_txt.val($_txt.val() + t_code);
							},
							_showTex : function(edtid,setparam,callback){
								var param = {};
								param["latexcd"] = $("div[id="+edtid+"] input[id=cmLatexCD]").val();
								param["t_id"] = setparam.t_id;
								param["q_id"] = setparam.q_id;
								param["r_type"] = setparam.r_type;
								param["c_mode"] = setparam.c_mode;
								//$("div[id="+edtid+"] div[id=cmSampleView]").html("....");
								$.post("/mast/svc/Tex.php",param,function(result){
								  //alert(result.image);
									$("div[id="+edtid+"] div[id=cmSampleView]").html(result.tag);
									$("div[id="+edtid+"] input[id=cmImgUrl]").val("").val(result.image);
									if(typeof(callback)==="function")
									{
										callback();
									}
									
								},"json");
							}//_showTex
							
						} //texEditor
});//$.extend

$.fn.attatchTexEditor = function (o) {
		defaults = {
			c_mode : "Q",
			r_type : "json",
			handle : "_x_",
			t_id : "13",
			q_id : "1",
			edit_type  : "Question",
			call_back : function(){
			 alert('기본콜백');
			},
			c_call_back : function(){
			 alert('캔슬');
			}			
		};
	var settings = $.extend(defaults, o);
	return this.each(function(){

		var edtid = "";
    var this_rs = {};
		if(settings.handle == '_x_'){
			edtid = $.texEditor._getEditorID($(this).attr("id"));
		}else{
			edtid = $.texEditor._getEditorID(settings.handle);
		}
		
		var pos=$(this).offset();
		var popup_x=parseInt(pos.left);//+(parseInt($(this).width()/2));
		var popup_y=parseInt(pos.top)+parseInt($(this).height());
		$('<div id="'+edtid+'" style="position:absolute;"></div>')
		.appendTo(document.body)
		.load("/mast/common/js/cmTexEditor.php",null,function(){
			if(settings.edit_type=='LCMS'){
				
			  $("div[id=cmTexLMS]",$.texEditor._getEditor(edtid)).hide();

				$.texEditor._getLcmsTexShortCut(edtid,1,function(){
					
						//현재 에디터 pEdt
						pEdt = $.texEditor._getEditor(edtid);
						
						/*2X2추가**********************************/
						$("<td width='40px' align=center>2x2</td>")
						.appendTo($("tr[id=texgrp01]"),pEdt)
						.css("cursor","hand").click(function(){
						 	 $("#cmTbt01",pEdt).css("top",$(this).position()["top"] + ($(this).height()/2))
						                .css("left",$(this).position()["left"] + ($(this).width()/2))
						                .toggle();
						});
						/*3X3추가**********************************/
						$("<td width='40px' align=center>3x3</td>")
						.appendTo($("tr[id=texgrp01]"),pEdt)
						.css("cursor","hand").click(function(){
						 	 $("#cmTbt02",pEdt).css("top",$(this).position()["top"] + ($(this).height()/2))
						                .css("left",$(this).position()["left"] + ($(this).width()/2))
						                .toggle();
						});
						
						/*2X2, 3X3핸들러*/
						$("div[id=cmTbt01] span[id=close]",pEdt).click(function(){
						
							$("div[id^=cmTbt] input[id^=t]",pEdt).val("");
							$("div[id=cmTbt01]").hide();
						}).css("cursor","hand");
						$("div[id=cmTbt02] span[id=close]",pEdt).click(function(){
							
							$("div[id^=cmTbt] input[id^=t]",pEdt).val("");
							$("div[id=cmTbt02]",pEdt).hide();
						}).css("cursor","hand");
					
						$("div[id=cmTbt01] span[id=ok]",pEdt).click(function(){

							$.texEditor._showTex(pEdt.attr("id"),settings);
							
							//$("div[id=cmTbt01] input[id=t01]",pEdt).val();
							var txval = "\\left(\\begin{array}{xx}"
							                                      + 	  $("div[id=cmTbt01] input[id=t01]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt01] input[id=t02]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt01] input[id=t03]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt01] input[id=t04]",pEdt).val()
							                                      +"\\end{array} \\right)";
						    $.texEditor._putTex( pEdt.attr("id"),txval, "latexcd" );
					
							$("div[id^=cmTbt] input[id^=t]",pEdt).val("");
							$("div[id=cmTbt01]",pEdt).hide();
						}).css("cursor","hand");
						$("div[id=cmTbt02] span[id=ok]",pEdt).click(function(){
							$.texEditor._showTex(pEdt.attr("id"),settings);
														
							var txval = "\\left(\\begin{array}{xxx}"
							                                      + 	  $("div[id=cmTbt02] input[id=t01]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t02]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t03]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t04]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t05]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t06]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t07]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t08]",pEdt).val()
							                                      + "&" + $("div[id=cmTbt02] input[id=t09]",pEdt).val()
							                                      +"\\end{array} \\right)";
					
							$.texEditor._putTex( pEdt.attr("id"),txval, "latexcd" );
					
							$("div[id^=cmTbt] input[id^=t]",pEdt).val("");
							$("div[id=cmTbt02]",pEdt).hide();
						}).css("cursor","hand");								

				});

				$.texEditor._getLcmsTexShortCut(edtid,2,function(){});
				$.texEditor._getLcmsTexShortCut(edtid,3,function(){});
				$.texEditor._getLcmsTexShortCut(edtid,4,function(){});
				
			}else if(settings.edit_type=='Question'){
				$("div[id=cmTexLCMS]",$.texEditor._getEditor(edtid)).hide();
			}
			//$("div[id="+edtid+"] #cmLatexCD").val(edtid); --> 안댐 
			//$("div[id="+edtid+"] input[id=cmLatexCD]").val(edtid); // --> 됨
  		/*[미리보기]*/
  		$("div[id="+edtid+"] input[id=cmPreView]").live('click',function(){
					$.texEditor._showTex(edtid,settings);
  		});

  		$( "input[id=cmLatexCD]",$.texEditor._getEditor(edtid) ).live('keydown',function(event){
  				
  				$.texEditor._showTex(edtid,settings);
  				if(event.keyCode=="40"){ //아래화살표는 미리보기 기능
            //alert( $("div[id="+edtid+"] input[id=cmLatexCD]").val() );
						$.texEditor._showTex(edtid,settings);
					}
  				if(event.keyCode=="13"){ //엔터치면 입력 후 닫기 
  				  $.texEditor._showTex(edtid,settings,function(){
  				  	settings.call_back(this_rs);
  				  	$.texEditor._hideEdit(edtid);
  				  });
					}					
					
  		});

			/*[삽입]*/
  		$("div[id="+edtid+"] input[id=cmTexDo]").live('click',function(){
        settings.call_back(this_rs);
        $.texEditor._hideEdit(edtid);
  		});
	
  		/*[닫기]*/
  		$("div[id="+edtid+"] input[id=cmClose]").live('click',function(){
				$.texEditor._hideEdit(edtid);
				settings.c_call_back();
  		});

		})
		.css({left:popup_x,top:popup_y})
		.hide();
/*	
		$(this).click(function(){
			$("div[id^=cmTexEditor]").hide();
			$.texEditor._getEditor(edtid).show();
		});
*/
		
	});
};
