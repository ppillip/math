<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
  <head>
    <meta charset="utf-8">
    <title>2xMath</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;
      };
    </style>
    <link href="../../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <div id="progress01" style="position:absolute;top:100px;left:350px;"><img src="../../math/images/ajax-loader.gif"/></div>
    <div class="navbar navbar-fixed-top" id="naviMenu">
    </div>
    
    <div class="container">

      <div class="alert alert-error" id="topInfo">
        <button class="close" data-dismiss="alert">×</button>
        <h1>문제만들기 2단계</h1>
        <p>1. 문제를 선택한다. (임시저장소에 있는상태임)</p>
        <p>2. 점수와 출제자를 선택한다</p>
        <p>3. 삭제 -> 표좌측 / 단원반영 -> 표우측 이동 버튼 클릭(단원에 포함 되어 출력 가능한 상태임)</p>
      </div>
      <br>

        <div class='well'>
      		<button name="deleteAll" class="btn btn-danger pull-left"><i class="icon-trash"></i></button>

            <div class="pull-right hide" name="movePanel">
            <button name="moveOk" class="btn btn-primary pull-right"><i class="icon-ok"></i></button>
            <select class="pull-right" style="margin-left:10px;"></select>
            </div>

            <button name="moveSelected" class="btn btn-primary pull-right" style="margin-left:10px;"><i class="icon-road"></i> 이동</button>
            <button name="cancelSelect" class="btn pull-right" style="margin-left:10px;"><i class="icon-remove"></i> 취소</button>
            <button name="selectAll" class="btn pull-right" style="margin-left:10px;"><i class="icon-ok"></i> 전체선택</button>
        </div>
		      
    <table class="table table-bordered table-condensed" id="table01">
    <thead>
    <tr>
    	<th>No.</th>
        <th>문제 지문</th>
        <th>설명 및 정답</th>
    </tr>
    </thead>
    <tbody></tbody>
    </table>

        <div class='well'>
            <button name="deleteAll" class="btn btn-danger pull-left"><i class="icon-trash"></i></button>

            <div class="pull-right hide" name="movePanel">
                <button name="moveOk" class="btn btn-primary pull-right"><i class="icon-ok"></i></button>
                <select class="pull-right" style="margin-left:10px;"></select>
            </div>

            <button name="moveSelected" class="btn btn-primary pull-right" style="margin-left:10px;"><i class="icon-road"></i> 이동</button>
            <button name="cancelSelect" class="btn pull-right" style="margin-left:10px;"><i class="icon-remove"></i> 취소</button>
            <button name="selectAll" class="btn pull-right" style="margin-left:10px;"><i class="icon-ok"></i> 전체선택</button>
        </div>

    <div id='questions'>

    </div>



    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap-transition.js"></script>
    <script src="../../assets/js/bootstrap-alert.js"></script>
    <script src="../../assets/js/bootstrap-modal.js"></script>
    <script src="../../assets/js/bootstrap-dropdown.js"></script>
    <script src="../../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../../assets/js/bootstrap-tab.js"></script>
    <script src="../../assets/js/bootstrap-tooltip.js"></script>
    <script src="../../assets/js/bootstrap-popover.js"></script>
    <script src="../../assets/js/bootstrap-button.js"></script>
    <script src="../../assets/js/bootstrap-collapse.js"></script>
    <script src="../../assets/js/bootstrap-carousel.js"></script>
    <script src="../../assets/js/bootstrap-typeahead.js"></script>
    <script src="../../assets/js/angular-1.0.1.js"></script>
    
    <script src="manageQuestions.js"></script>

  </body>
</html>

