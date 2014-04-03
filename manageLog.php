<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Table</title>

<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <link rel="stylesheet" href="assets/lib/datatables/css/demo_page.css">
    <link rel="stylesheet" href="assets/lib/datatables/css/DT_bootstrap.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
      <script src="assets/lib/html5shiv/html5shiv.js"></script>
	      <script src="assets/lib/respond/respond.min.js"></script>
	    <![endif]-->

    <!--Modernizr 3.0-->
    <script src="assets/lib/modernizr-build.min.js"></script>
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

            <!--Begin Datatables-->
            <div class="row">
              <div class="col-lg-12">
                <div class="box">
                  <header>
                    <div class="icons">
                      <i class="fa fa-table"></i>
                    </div>
                    <h5>Dynamic Table</h5>
<a href="javascript:;" class="refresh">Refresh</a>
                  </header>
                  <div id="collapse4" class="body">
                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                      <thead>
                        <tr>
                          <th>date</th>
                          <th>platform</th>
                          <th>version</th>
                          <th>lang</th>
                          <th>title</th>
                          <th>Operation</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
	
define("DB_PATH","./");
include "xmlDB.php";
$row = Database::factory("logs",NULL,"Logs");
$result = $row->select()->find_all();
foreach ($result as $item){
?>
                        <tr>
                          <td> <?php echo $item->date; ?> </td>
                          <td> <?php echo $item->platform; ?> </td>
                          <td> <?php echo $item->version; ?> </td>
                          <td> <?php echo $item->lang; ?> </td>
                          <td> <?php echo $item->title; ?> </td>
                          <td><a href="javascript:;" data-id=" <?php echo $item->id; ?> " class="delete">Delete</a><a href="editLog.php?id=<?php echo $item->id; ?>" data-id=" <?php echo $item->id; ?> " class="edit">Edit</a></td>
                        </tr>
<?php
}
?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- /.row -->

            <!--End Datatables-->
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
    <script type="text/javascript" src="assets/js/style-switcher.js"></script>
    <script src="assets/lib/jquery-ui.min.js"></script>
    <script src="assets/lib/datatables/jquery.dataTables.js"></script>
    <script src="assets/lib/datatables/DT_bootstrap.js"></script>
    <script src="assets/lib/tablesorter/js/jquery.tablesorter.min.js"></script>
    <script src="assets/lib/touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script>
      $(function() {
	    $(".refresh").on("click",function(){
            var url = "index.php?v="+(new Date().getTime()); // the script where you handle the form input.  
            $.ajax({
               type: "get",
               url: url,
               datatype:"text",
               success: function(data)
               {
                   if(data){
                       console.log(data);
                   }
               }
             });
	    });
	    $(".delete").on("click",function(){
            if(!confirm("确定删除吗?")){
                return; 
            }
		var id = $(this).data("id");

	    var url = "deletelogform.php"; // the script where you handle the form input.  
	    $.ajax({
		   type: "post",
		   url: url,
		   data: {"id":id}, // serializes the form's elements.
		    datatype:"json",
		   success: function(data)
		   {
               if(data.result){
                    location.reload(true);
               }
		   }
		 });
	    });
        metisTable();
        metisSortable();
      });
    </script>
  </body>
</html>
