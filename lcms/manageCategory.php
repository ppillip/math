<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
  <head>
    <meta charset="utf-8">
    <title>2xMath</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      };
    </style>
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <div id="progress01" style="position:absolute;top:100px;left:350px;"><img src="/math/images/ajax-loader.gif"/></div>
    <div class="navbar navbar-fixed-top" id="naviMenu">
    </div>
    
    <div class="container">
      
		<div class="alert alert-success" id="topInfo">
			<button class="close" data-dismiss="alert">×</button>
			<h1>Manage Category</h1>
		</div>
		
		<form name="frmComp" method="post"> 
		  <input type="hidden" name="quests" id="quests">
		</form>

        <div class="well-large">
            <div>
                <table class="table table-striped table-bordered table-condensed span5 pull-left" id="table01">
                    <thead>
                    <tr style="height:35px;">
                        <th>교과과정</th>
                        <th>정렬순서</th>
                        <th>단원수</th>
                        <th>ACTION</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr style="height:35px;">
                        <td colspan="3"></td>
                        <td style="text-align: center">
                            <a href="javascript:getList01()" class="btn btn-mini btn-primary"><i class="icon-refresh icon-white"></i></a>
                            <a data-toggle="modal"  rel="tooltip" title="신규로등록"  href="#regCRERModal" class="btn btn-mini btn-primary"><i class="icon-plus icon-white"></i></a>
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div>
                <table class="table table-striped table-bordered table-condensed span6 pull-right" id="table02">
                    <thead>
                    <tr style="height:35px;">
                        <th>교과과정 &gt; 단원</th>
                        <th>정렬순서</th>
                        <th>문제수</th>
                        <th>ACTION</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr style="height:35px;">
                        <td colspan="3"></td>
                        <td style="text-align: center">
                            <a href="javascript:refreshList02()" class="btn btn-mini btn-primary"><i class="icon-refresh icon-white"></i></a>
                            <a data-toggle="modal"  rel="tooltip" title="신규로등록"  href="#regBUNTModal" class="btn btn-mini btn-primary"><i class="icon-plus icon-white"></i></a>
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>



        <!--교과과정 등록모드-->
        <div id="regCRERModal" class="modal hide">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>교과과정 등록</h3>
            </div>
            <div class="modal-body">

                        <div class="control-group form-horizontal">
                            <label class="control-label" for="CRCR_NM">교과과정명</label>
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="CRCR_NM">
                                <p class="help-inline">한글/영어외 모든 특수문자 안되</p>
                            </div>
                            <p></p>
                            <label class="control-label" for="CRCR_SRT">정렬순서</label>
                            <div class="controls">
                                <input type="text" class="input-mini" id="CRCR_SRT">
                                <p class="help-inline">숫자만 입력</p>
                            </div>
                        </div>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" style="width:100px;">Close</button>
                <button class="btn btn-primary" id="createCRCR" style="width:100px;">Save</button>
            </div>
        </div>

        <!--단원 등록모드-->
        <div id="regBUNTModal" class="modal hide">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3>단원 등록</h3>
            </div>
            <div class="modal-body">

                <div class="control-group form-horizontal">
                    <label class="control-label" for="BUNT_NM">단원명</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge" id="BUNT_NM">
                        <p class="help-inline">한글/영어외 모든 특수문자 안되</p>
                    </div>
                    <p></p>
                    <label class="control-label" for="BUNT_SRT">정렬순서</label>
                    <div class="controls">
                        <input type="text" class="input-mini" id="BUNT_SRT">
                        <p class="help-inline">숫자만 입력</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" style="width:100px;">Close</button>
                <button class="btn btn-primary" style="width:100px;" id="createBUNT">Save</button>
            </div>
        </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap-transition.js"></script>
    <script src="/assets/js/bootstrap-alert.js"></script>
    <script src="/assets/js/bootstrap-modal.js"></script>
    <script src="/assets/js/bootstrap-dropdown.js"></script>
    <script src="/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/bootstrap-tab.js"></script>
    <script src="/assets/js/bootstrap-tooltip.js"></script>
    <script src="/assets/js/bootstrap-popover.js"></script>
    <script src="/assets/js/bootstrap-button.js"></script>
    <script src="/assets/js/bootstrap-collapse.js"></script>
    <script src="/assets/js/bootstrap-carousel.js"></script>
    <script src="/assets/js/bootstrap-typeahead.js"></script>
    <script src="manageCategory.js"></script>

  </body>
</html>

