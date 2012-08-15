<!DOCTYPE html>
<html lang="en">
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
      }
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
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Math PDF</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Generate PDF File <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="makePDFClassic.php">Classic</a></li>
                  <li><a href="makePDFNew.php">다른방법 준비중</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </li>

              <li><a href="manageCategory.php">Manage Category</a></li>
              <li><a href="#contact">Help</a></li>

            </ul>
            
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class="container">
      
		<div class="alert alert-error" id="topInfo">
			<button class="close" data-dismiss="alert">×</button>
			<h1>다른방법을 준비중입니다</h1>
      <p>1. </p>
			<p>2. </p>
			<p>3. </p>
		</div>
		
		<form name="frmComp" method="post"> 
		  <input type="hidden" name="quests" id="quests">
		</form>
		
		<div class="well form-search">
		<SELECT class="span2" id="qust_type">
			<OPTION VALUE="ALL">전체</OPTION>
			<OPTION VALUE="1">교육청/평가원/수능</OPTION>
			<OPTION VALUE="2">사설</OPTION>
		</SELECT>

		 <button id="makePdf" rel="tooltip" title="pdf 생성" class="btn btn-primary">
      <i class="icon-shopping-cart icon-white"></i> PDF 만들기 2단계
     </button>

		</div>

		<table class="table table-bordered table-condensed" id="table01">
			<thead>
				<tr>
					<th width="">교과과정</th>
					<th width="">단원</th>
					<th width="80px">선택</th>
					<th width="80px">2점</th>
					<th width="80px">3점</th>
					<th width="80px">4점</th>
					<th width="80px">문제수</th>
				</tr>
			</thead>
        <tbody>
       
        </tbody>
		</table>


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
    <script src="makePDFNew.js"></script>

  </body>
</html>
