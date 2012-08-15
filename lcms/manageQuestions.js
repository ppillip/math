var INITPARAM = {};
var QUSTLIST = {};
var __X = 200;
var __Y = 200;
var currentPageNo = 1;
var endFile = false;
$(document).ready(function(){
    $("#progress01").ajaxStart(function(){
        $(this).css({position:"absolute",top:(__Y-50)+"px",left:(__X-50)+"px"});
        $(this).show();
    }).ajaxStop(function(){
            $(this).hide();
    });

    $(document).mousemove(function(e){
        __X = e.pageX;
        __Y = e.pageY;

    });

    $("#naviMenu").load("menu.html",function(){
        $("#topNavigation li[name=qust]").addClass("active");
        getTempImageList();
    });

//    $("img").live("click",function(e){
//    	$(this).toggleClass("imgSelected");
//    	$("span", $(this).parent()).toggleClass("hide");
//    })

	$("button[name=cancelSelect]").click(function(){
	    $("img").removeClass("imgSelected");
	    $("span", $("img").parent()).addClass("hide");

      $("div[name=movePanel]").hide();
	});

	$("button[name=selectAll]").click(function(){
	    $("img").trigger("click");
	});
    
    
    
    
    $("button[name=deleteAll]").click(function(){
        var param = {
            _method : "qt01"
            ,QUST_IDS : (function(){
                return $(".imgSelected").map(function(){
                    return $(this).attr("name");
                }).get().join(",");
            })()
        };
        if(param.questions==""){
            alert('문제를 선택하세요');
            return;
        }
        jQuery.post("question.php",param,function(result,stat){
            if(result.err){
                alert(result.msg);
            }
            alert(result.msg);
            getTempImageList();
        },"json");
    });

    $("button[name=moveSelected]").click(function(){

        var $s = $("div[name=movePanel] select");

        if($s.html()==""){
            jQuery.post("manage.php",{"_method":"m008"},function(result,stat){
                $(result.rows).each(function(idx,row){
                    $("<option value='"+row.BUNT_ID+"'>"+row.FULL_NM+"</option>").appendTo($s);
                });
                $("div[name=movePanel]").fadeIn(1500);
            },"json");
        }else{
            $("div[name=movePanel]").fadeIn(1500);
        }
        var values = $(".imgSelected").map(function(){
            return $(this).attr("name");
        })
        .get()
        .join(",") ;
    });

    $("button[name=moveOk]").click(function(){
        var param = {
             _method : "mk01"
            ,BUNT_ID : $("div[name=movePanel] select").val()
            ,QUST_IDS : (function(){
                return $(".imgSelected").map(function(){

                    return $(this).attr("name") 
                            + "#" + $("span:nth-child(1) .active", $(this).parent()).attr('name')
                            + "#" + $("span:nth-child(2) .active", $(this).parent()).attr('name');
                }).get().join(",");
            })()
        };
        if(param.questions==""){
            alert('문제를 선택하세요');
            return;
        }

        jQuery.post("question.php",param,function(result,stat){
            alert(result.msg);
            getTempImageList();
        },"json");


    });
});




function getTempImageList(){
    $("#table01 tbody tr").remove();
    jQuery.post("question.php",{"_method":"t01"},function(result,stat){
        $(result.rows).each(function(idx,row){
            (function (IDX, QUST){
                if(typeof(QUST)=="undefined"){ return;}
                _qim = $("<img name='"+QUST.QUST_ID+"'/>")
                    .click(function(){
                        $(this).toggleClass("imgSelected");
                        $("span", $(this).parent()).toggleClass("hide");
                    }).hide();
                _aim = $("<img>").hide();
                _qim.bind("load",function(){
                    $(this).fadeIn(2000);
                });
                _aim.bind("load",function(){
                    $(this).fadeIn(2000);
                });

                $('body div #questions').append(_qim);
                $('body div #questions').append(_aim);

                _qim.attr('src',QUST.QFILE_PATH).attr('width',0.5*QUST.QWIDTH);
                _aim.attr('src',QUST.AFILE_PATH).attr('width',0.5*QUST.AWIDTH);

                $btnGrp =
                    "<p>&nbsp;</p><p>"
                    +" <span class='btn-group hide' data-toggle='buttons-radio' name='point'> "
                    +"    <button class='btn' name='2'>2점</button>"
                    +"    <button class='btn' name='3'>3점</button>"
                    +"    <button class='btn' name='4'>4점</button></span>"
                    +"  <span class='btn-group hide' data-toggle='buttons-radio' name='surc'>"
                    +"    <button class='btn' name='1'  style='margin-left:10px'>교육청/평가원/수능</button>"
                    +"    <button class='btn' name='2'>사설</button></span>"
                    +"</p><p>&nbsp;</p><p>&nbsp;</p>";

                _tr = $("<tr/>").append("<td>"+(IDX+1)+"</td>");
                _td01 = $("<td  style='vertical-align: top;'/>").append(_qim);
                _td01.append($btnGrp);
                _td02 = $("<td  style='vertical-align: top;'/>").append(_aim);
                _tr.append(_td01).append(_td02).appendTo("#table01 tbody");
            })(idx,row) ;
        });
    },"json");

}
