<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Form Validation</title>

    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#5bc0de">
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png">

	<?php
		include "commoncss.php";
	?>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/lib/Font-Awesome/css/font-awesome.min.css">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="assets/lib/validationengine/css/validationEngine.jquery.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/flick/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    
    <link rel="stylesheet" href="assets/lib/datepicker/css/datepicker.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
      <script src="assets/lib/html5shiv/html5shiv.js"></script>
	      <script src="assets/lib/respond/respond.min.js"></script>
	    <![endif]-->

    <!--Modernizr 3.0-->
  </head>
  <body>
    <div id="wrap">
<?php
	include "header.php";
	include "sidebar.php";
?>
      <div id="content">
        <div class="outer">
          <div class="inner">
            <style>
              .form-control.col-lg-6 {
                width: 50% !important;
              }
            </style>
            <!-- /.row -->
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header>
                    <div class="icons">
                      <i class="fa fa-ok"></i>
                    </div>
                    <h5>Add Log</h5>
                    <div class="toolbar">
                      <ul class="nav">
                        <li>
                          <div class="btn-group">
                            <a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse" href="#collapse3">
                              <i class="fa fa-chevron-up"></i>
                            </a>
                            <button class="btn btn-xs btn-danger close-box">
                              <i class="fa fa-remove"></i>
                            </button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </header>
                  <div id="collapse3" class="accordion-body collapse in body">
                    <form action="addLogForm.php" class="form-horizontal" method="post" id="inline-validate">
<?php
	
define("DB_PATH","./");
include "xmlDB.php";
$id = $_GET["id"];
if(!$id){
    die("id错误");
}
$row = Database::factory("logs",$id,"Logs");
$result = $row->select();
?>
		       <div class="form-group">
                        <label class="control-label col-lg-4">平台</label>
                        <div class="col-lg-8">
                          <select class="form-control col-lg-6" name="platform">
                            <option value="iOS" <?php echo $result->platform=="iOS"?"selected":""; ?> >iOS</option>
                            <option value="Android" <?php echo $result->platform=="Android"?"selected":""; ?> >Android</option>
                            <option value="Windows Phone" <?php echo $result->platform=="Windows Phone"?"selected":""; ?> >Windows Phone</option>
                            <option value="Symbian" <?php echo $result->platform=="Symbian"?"selected":""; ?> >Symbian</option>
                            <option value="Blackberry" <?php echo $result->platform=="Blackberry"?"selected":""; ?> >Blackberry</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-lg-4">版本</label>
                        <div class="col-lg-8">
                          <input type="text" value="<?php echo $result->version; ?>" id="required" name="version" class="form-control col-lg-6">
                        </div>
                      </div>
		      <div class="form-group">
                        <label class="control-label col-lg-4">语言</label>
                        <div class="col-lg-8">
                          <select  name="lang" class="form-control col-lg-6">
                            <option value="en" <?php echo $result->lang=="en"?"selected":""; ?> >en</option>
                            <option value="zh_TW"  <?php echo $result->lang=="zh_TW"?"selected":""; ?>>zh_TW</option>
                          </select>
                        </div>
                      </div>
		      <div class="form-group">
                        <label class="control-label col-lg-4" for="dp1">发布日期</label>
                        <div class="col-lg-3">
                          <input type="text" value="<?php echo $result->date; ?>" class="form-control" name="date"  id="dp1">
                        </div>
                      </div>
			<div class="form-group">
                        <label class="control-label col-lg-4">发布标题</label>
                        <div class="col-lg-8">
                          <input type="text" id="required" value="<?php echo $result->title; ?>" name="title" class="form-control col-lg-6">
                        </div>
                      </div><div class="form-group">
                        <label for="text4" class="control-label col-lg-4">描述</label>
                        <div class="col-lg-8">
                          <textarea id="text4" name="description"  class="form-control col-lg-6"><?php echo $result->description; ?></textarea>
                        </div>
		      </div>
			<div class="form-group">
                        <label for="text4" class="control-label col-lg-4">首页描述</label>
                        <div class="col-lg-8">
                          <textarea id="text4" name="indexDescription"  class="form-control col-lg-6"><?php echo $result->indexDescription; ?></textarea>
                        </div>
                      </div>
<?php
	
foreach ($result->features as $key=>$item){
?>
			<div class="form-group">
                        <label class="control-label col-lg-4">特性</label>
                        <div class="col-lg-8">
                          <input type="text" id="feature1" name="feature[]" value="<?php echo $item; ?>"  class=" form-control col-lg-6">
                          <input  id="spin1" name="featureNum[]" value="<?php echo $result->featuresNum[$key]; ?>" class="spin form-control col-lg-6">
			  <a href = "javascript:;" class="addFeature" >Add</a>
                        </div>
                      </div>
<?php
}
?>
                      <div class="form-actions">
                        <input type="hidden" value="<?php echo $id?>" name="id" class="btn btn-primary">
                        <input type="submit" value="Save" class="btn btn-primary">
                        <input type="reset" value="Cancel" class="btn btn-primary">
                      </div>
                    </form>
                  </div>
                </div>
              </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
          </div>

          <!-- end .inner -->
        </div>

        <!-- end .outer -->
      </div>

      <!-- end #content -->
    </div><!-- /#wrap -->

	<?php
		include "footer.php";
	?>
		<div class="addFeatureTemplate">
			<div class="form-group">
				<label class="control-label col-lg-4">特性</label>
				<div class="col-lg-8">
				  <input type="text" id="required" name="feature[]" class="form-control col-lg-6">
                  <input value="2" id="spin1" name="featureNum[]"class="spin form-control col-lg-6">
				  <a href = "javascript:;" class="addFeature" >Add</a>
				  <a href = "javascript:;" class="deleteFeature" >Delete</a>
				</div>
			      </div>
                      </div>
    <!-- #helpModal -->
    <div id="helpModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
              in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><!-- /#helpModal -->
    <script src="assets/lib/jquery.min.js"></script>
    <script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/lib/jquery-ui.min.js"></script>
    <script src="assets/lib/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="assets/lib/validationengine/js/jquery.validationEngine.js"></script>
    <script src="assets/lib/validationengine/js/languages/jquery.validationEngine-en.js"></script>
    <script src="assets/lib/jquery-validation-1.11.1/dist/jquery.validate.js"></script>
    <script src="assets/lib/jquery-validation-1.11.1/localization/messages_zh.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
      $(function() {
        formValidation();
      });
    </script>
  </body>
</html>

