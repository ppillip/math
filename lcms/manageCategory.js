$(document).ready(function(){
    $("#naviMenu").load("menu.html",function(){
      $("#topNavigation li[name=cate]").addClass("active");
    });
    
    getList01();
    $("button[name=newCRCR]").click(function(){
    }).tooltip();

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


    $("#createCRCR").click(function(){
        $("#createCRCR").hide();
        var param = {
            "CRCR_NM":$("#CRCR_NM").val()
            ,"CRCR_SRT":$("#CRCR_SRT").val()
            ,"_method" : "m004"
        };

        jQuery.post("manage.php",param,function(result,stat){
            $("#createCRCR").show();
            if(result.err){
                alert(result.msg);
                return;
            }
            $("#regCRERModal").modal('hide');
            $("#CRCR_NM").val("");
            $("#CRCR_SRT").val("");
            getList02("");
            getList01();
            
        },"json");

    });

    $("#createBUNT").click(function(){
        $("#createBUNT").hide();
        if(_crcr_id=="")
        {
            $(this).show();
            alert('교과과정 선택 또는 '+'_crcr_id 확인요망');
            return;
        }

        var param = {
            "BUNT_NM":$("#BUNT_NM").val()
            ,"BUNT_SRT":$("#BUNT_SRT").val()
            ,"BUNT_CRCR_ID":_crcr_id
            ,"_method" : "m005"
        };

        jQuery.post("manage.php",param,function(result,stat){
            $("#createBUNT").show();
            if(result.err){
                alert(result.msg);
                return;
            }
            $("#regBUNTModal").modal('hide');
            $("#BUNT_NM").val("");
            $("#BUNT_SRT").val("");
            refreshList02("");
            getList01();
            
            
        },"json");

    });


})
var __X=0;
var __Y=0;
var _crcr_id = "";

function getList01(callback){
    $("#progress01").show();
    jQuery.post("manage.php",{"_method":"m001"},function(result,stat){
        $("#table01 tbody tr").remove();
        $(result.rows).each(function(idx,obj){
            $("<tr>"
                + "<td>"+obj.CRCR_NM+"</td>"
                + "<td style='text-align: right'><input onkeypress='javascript:updateCRCRSRT(this)' crcr_id='"+obj.CRCR_ID+"' style='width:30px;text-align: right;margin-bottom: 0px;' type=text value='"+obj.CRCR_SRT+"'></td>"
                + "<td style='text-align: right'>"+obj.CNT+"</td>"
                + "<td style='text-align: center'><button onclick='javascript:getList02(\""+obj.CRCR_ID+"\")' class='btn btn-mini'><i class='icon-list'></i></button> " +
                (function(row){
                    if(row.CNT=="0"){
                        return "<button onclick='javascript:removeCRCR(\""+row.CRCR_ID+"\")' class='btn btn-mini btn-warning'><i class='icon-remove icon-white'></i></button>";
                    }else{ return ""; }
                })(obj) +
                "</td>"
                + "</tr>").appendTo("#table01 tbody");
        });
        $("#progress01").hide();
        if(!!callback) callback();
    },"json");
}



function refreshList02(callback){
    $("#progress01").show();
    getList02(_crcr_id,callback);
}
function getList02(CRCR_ID,callback){
    _crcr_id = CRCR_ID;
    $("#progress01").show();
    jQuery.post("manage.php",{"_method":"m003","CRCR_ID":CRCR_ID},function(result,stat){
        $("#table02 tbody tr").remove();
        $("#progress01").show();
        $(result.rows).each(function(idx,obj){
            $("<tr>"
                + "<td>"+obj.CRCR_NM + " &gt; " + obj.BUNT_NM + "</td>"
                + "<td style='text-align: right'><input onkeypress='javascript:updateBUNTSRT(this)' bunt_id='"+obj.BUNT_ID+"' style='width:30px;text-align: right;margin-bottom: 0px;' type=text value='"+obj.BUNT_SRT+"'></td>"
                + "<td style='text-align: right'>"+obj.CNT+"</td>"
                + "<td style='text-align: center'><button onclick='javascript:goQust(\""+obj.BUNT_ID+"\",\""+obj.BUNT_NM+"\")' class='btn btn-mini'><i class='icon-list'></i></button> " +
                (function(row){
                    if(row.CNT=="0"){
                        return "<button onclick='javascript:removeBUNT(\""+row.BUNT_ID+"\")' class='btn btn-mini btn-warning'><i class='icon-remove icon-white'></i></button>";
                    }else{ return ""; }
                })(obj) +
                "</td>"
                + "</tr>").appendTo("#table02 tbody");
        });
        $("#progress01").hide();
        if(!!callback) callback();
    },"json");
}

function goQust(BUNT_ID,BUNT_NM){
    document.location.href="manageCategoryQuestion.php?BUNT_ID="+BUNT_ID+"&BUNT_NM="+BUNT_NM;
}

function removeCRCR(crcr_id){
    jQuery.post("manage.php",{"_method":"m006","CRCR_ID":crcr_id},function(result,stat){
        if(result.err){
            alert(result.msg);
            return;
        }
        getList02("");
        getList01();
    },"json");
}

function removeBUNT(bunt_id){
    jQuery.post("manage.php",{"_method":"m007","BUNT_ID":bunt_id},function(result,stat){
        if(result.err){
            alert(result.msg);
            return;
        }
        refreshList02();
        getList01();
    },"json");
}


function updateCRCRSRT(obj){
    if(event.keyCode!=13){
        return;
    }
    var param = {
        "CRCR_ID":$(obj).attr("crcr_id")
        ,"CRCR_SRT":$(obj).val()
        ,"_method" : "m002"
    };

    jQuery.post("manage.php",param,function(result,stat){
        if(result.err){
            alert(result.msg);
            return;
        }
        getList01();
    },"json");
}

function updateBUNTSRT(obj){
    if(event.keyCode!=13){
        return;
    }
    var param = {
        "BUNT_ID":$(obj).attr("bunt_id")
        ,"BUNT_SRT":$(obj).val()
        ,"_method" : "m0021"
    };

    jQuery.post("manage.php",param,function(result,stat){
        if(result.err){
            alert(result.msg);
            return;
        }
        getList02(_crcr_id);
    },"json");
}