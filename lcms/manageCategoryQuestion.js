function getParams() {
    // 파라미터가 담길 배열
    var param = new Array();

    // 현재 페이지의 url
    var url = decodeURIComponent(location.href);
    // url이 encodeURIComponent 로 인코딩 되었을때는 다시 디코딩 해준다.
    url = decodeURIComponent(url);

    var params;
    // url에서 '?' 문자 이후의 파라미터 문자열까지 자르기
    params = url.substring( url.indexOf('?')+1, url.length );
    // 파라미터 구분자("&") 로 분리
    params = params.split("&");

    // params 배열을 다시 "=" 구분자로 분리하여 param 배열에 key = value 로 담는다.
    var size = params.length;
    var key, value;
    for(var i=0 ; i < size ; i++) {
        key = params[i].split("=")[0];
        value = params[i].split("=")[1];

        param[key] = value;
    }
   return param;
}

var INITPARAM = {};
var QUSTLIST = {};
var __X = 200;
var __Y = 200;
var currentPageNo = 1;
var endFile = false;
$(document).ready(function(){
    
    $(window).scroll(function(e){ //page is the ID of the div im scrolling
      if(endFile) return;
      console.log(document.body.scrollHeight +"-"+ $(window).scrollTop()  +"<="+ $(window).height() );
          if (document.body.scrollHeight - $(window).scrollTop()  <= ($(window).height() + 100))
          {
             appendPage(currentPageNo);
          }   
    });
    
    $(document).mousemove(function(e){
        __X = e.pageX;
        __Y = e.pageY;

    });

    window.INITPARAM = getParams();
    $("#naviMenu").load("menu.html",function(){
        $("#topNavigation li[name=cate]").addClass("active");
        $("span[name=bunt_nm]").html(INITPARAM.BUNT_NM);
        jQuery.post("question.php",{"_method":"q01","bunt_id":INITPARAM.BUNT_ID},function(result,stat){
            window.QUSTLIST = result.rows;

            $("#progress01").ajaxStart(function(){
                $(this).css({position:"absolute",top:(__Y-50)+"px",left:(__X-50)+"px"});
                $(this).show();
            }).ajaxStop(function(){
                    $(this).hide();
            });
            appendPage(currentPageNo);
        },"json");

    });
    
    $("img").live("click",function(e){
    	$(this).toggleClass("imgSelected");
    })

	$("button[name=cancelSelect]").click(function(){
	    $("img").removeClass("imgSelected");
        $("div[name=movePanel]").hide();
	});
    
    $("button[name=deleteAll]").click(function(){

        var param = {
            _method : "q03"
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
        console.log(param);

        jQuery.post("question.php",param,function(result,stat){
            if(result.err){
                alert(result.msg);
            }

            alert(result.msg);
            window.location.reload(true);

        },"json");



    });

    $("button[name=moveSelected]").click(function(){

        var $s = $("div[name=movePanel] select");

        if($s.html()==""){
            jQuery.post("manage.php",{"_method":"m008"},function(result,stat){
                $(result.rows).each(function(idx,row){
                    $("<option value='"+row.BUNT_ID+"'>"+row.FULL_NM+"</option>").appendTo($s);
                });
                $("div[name=movePanel]").fadeIn(3000);
            },"json");
        }else{
            $("div[name=movePanel]").fadeIn(3000);
        }
        var values = $(".imgSelected").map(function(){
            return $(this).attr("name");
        })
        .get()
        .join(",") ;
    });

    $("button[name=moveOk]").click(function(){
        var param = {
             _method : "q02"
            ,BUNT_ID : $("div[name=movePanel] select").val()
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
        console.log(param);

        jQuery.post("question.php",param,function(result,stat){
            alert(result.msg);
            window.location.reload(true);
            //$("div[name=movePanel]").hide();
        },"json");


    });




});


function appendPage(Num) {

    console.log(QUSTLIST);

    if(typeof(QUSTLIST)=="undefined"){return;}

	if(endFile){
		console.log("끝장임");
		return;
	}

    currentPageNo++;

    /*20 개씩 뿌리기*/
    var n = new Number(Num);
    var s = 2*(n-1)*10;
    var e = s + 19;

    for(i=s ; i<=e ; i++){
        (function (QUST){
            if(typeof(QUST)=="undefined"){ return;}
            _qim = $("<img name='"+QUST.QUST_ID+"'/>").hide();
            _aim = $("<img>").hide();

            _qim.bind("load",function(){
                $(this).fadeIn(2000);
            });
            _aim.bind("load",function(){
                $(this).fadeIn(2000);
            });

            $('body div #questions').append(_qim);
            $('body div #questions').append(_aim);

            _qim.attr('src',QUST.QUST_FILE_PATH + "/" + QUST.QUST_Q_FILE).attr('width',0.5*QUST.QWIDTH);
            _aim.attr('src',QUST.QUST_FILE_PATH + "/" + QUST.QUST_A_FILE).attr('width',0.5*QUST.AWIDTH);

            _tr = $("<tr/>").append("<td>"+(QUST.IDX+1)+"</td>");
            _td01 = $("<td  style='vertical-align: top;'/>").append(_qim);
            _td02 = $("<td  style='vertical-align: top;'/>").append(_aim);

            _tr.append(_td01).append(_td02).appendTo("#table01 tbody");
            
            if(QUSTLIST.length == (QUST.IDX+1)) 
            {
              endFile = true;
            }
            
        })(QUSTLIST[i]) ;

    }

}
