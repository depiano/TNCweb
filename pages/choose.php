<?php
session_start();
//Controllo che si è loggato!
if(!(isset($_SESSION['CF']) && isset($_SESSION['FULLNAME'])))
    header('Location: ../pages/notfound.html');
?>
<!DOCTYPE html>
<html lang="en" CF="<?php echo $_SESSION['CF']; ?>" FULLNAME="<?php echo $_SESSION['FULLNAME']; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TNCapp</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="../js/dropzone.js"></script>

    <![endif]-->
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
    <script type="text/javascript">

        $(document).ready(function() {
            $("#button_date").click(function () {

                if($("#date").val()=="")
                {

                    $('#date').css('border-color', 'red');

                    setTimeout(function(){
                        $('#date').css({"border-color" : ""});
                    }, 1000);
                }
                else
                {
                    $(window.location).attr('href', 'read_point_by_date.php?date='+ $("#date").val());
                }

            });

            $("#button_operator").click(function () {

                if($("#operator").val()=="")
                {

                    $('#operator').css('border-color', 'red');

                    setTimeout(function(){
                        $('#operator').css({"border-color" : ""});
                    }, 1000);
                }
                else
                {
                    $(window.location).attr('href', 'read_point_by_operator.php?operator='+ $("#operator").val());
                }

            });

            $("#fullname_user").text($('html').attr('FULLNAME')+" ");

            $("#button_marker").click(function () {
                    $(window.location).attr('href', 'draw_polygon.php?');
                                });
        });

    </script>
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">TNCapp</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <label id="fullname_user"></label><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> Profilo</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="../script_tncweb/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Mappa Fisciano</a>
                    </li>
                    <li>
                        <a href="censimenti.php"><i class="fa fa-table fa-fw"></i> Censimenti da analizzare</a>
                    </li>
                    <li>
                        <a href="choose.php"><i class="fa fa-wrench fa-fw"></i> Ricerca Censimenti</a>
                    </li>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Comune di Fisciano (SA)</h4>
                    <label id="message" style="color:blue;"></label>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>

        <!-- <div id="map"></div> -->
        <div class="row">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="../images/data_search.jpg" alt="...">
                        <div class="caption">
                            <p><input type="text" class="form-control" id="date" placeholder="Data"></p>
                            <p style="text-align:center;"><button type="button" class="btn btn-primary" id="button_date">Search...</button></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="../images/operator.png" alt="...">
                        <div class="caption">
                            <p><input type="text" class="form-control" id="operator" placeholder="Fullname dell'operatore"></p>
                            <p style="text-align:center;"><button type="button" class="btn btn-primary"  id="button_operator">Search...</button></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="../images/search_by_marker.png" alt="...">
                        <div class="caption">
                            <p><input type="text" class="form-control" style="visibility:hidden;"></p>
                            <p style="text-align:center;"><button type="button" class="btn btn-primary"  id="button_marker">Accedi...</button></p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <img src="../images/upload.png" alt="...">
                            <div class="caption">
                                <p style="text-align:center;">
                                    <input name="myFile" type="file" class="btn btn-primary" >
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
