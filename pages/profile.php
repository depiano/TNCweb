<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en" CF="<?php echo $_SESSION['CF']; ?>">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TNC app</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                url: "../script_tncweb/get_profile.php",
                type: "POST",
                data: {
                    'CF': $('html').attr('CF')
                },
                dataType: "JSON",
                success: function (jsonStr) {

                    if (jsonStr['ERROR'] == 'none') {
                        //alert(JSON.stringify(jsonStr['RESULT']));
                        $("#cf").val(jsonStr['RESULT'].CF);
                        $("#phone").val(jsonStr['RESULT'].PHONE);
                        $("#fullname").val(jsonStr['RESULT'].FULLNAME);
                        $("#email").val(jsonStr['RESULT'].EMAIL);
                    }
                    else {
                        $("#message").text(jsonStr['ERROR']);
                    }
                }
            });

            $("#modifica").click(function () {
                $.ajax({
                    url: "../script_tncweb/update_profile.php",
                    type: "POST",
                    data: {
                        'PHONE': $("#phone").val(),
                        'PASSWORD': $("#password").val(),
                        'CF': $('html').attr('CF')
                    },
                    dataType: "JSON",
                    success: function (jsonStr) {
                        if (jsonStr['ERROR'] == 'none') {
                            $("#message").text("Congratulazione! I campi sono stati aggiornati.");
                        }
                        else {
                            $("#message").text("Attenzione! Si è verificato un errore.");
                        }
                    }
                });
            });

            $("#annulla").click(function () {
                window.location.href = "./index.php";
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
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">TNC app</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> Profilo</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Mappa Roccapiemonte</a>
                    </li>
                    <li>
                        <a href="index.php"><i class="fa fa-table fa-fw"></i> Censimenti</a>
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
                    <h4 class="page-header">Profilo utente</h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <div style="text-align:center;">
            <img src="../images/avatar.png" style="width:150px; height:150px;">
        </div>
        <p><br/></br7></p>
        <div class="panel-body">
            <div class="row" >
                <form role="form">
                <div class="col-md-4 col-md-offset-4">
                    <div class="form-group">
                        <label>Fullname</label>
                        <input class="form-control" placeholder="Fullname" id="fullname" readonly />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" placeholder="Email" id="email" readonly />
                    </div>
                    <div class="form-group">
                        <label>Codice Fiscale</label>
                        <input class="form-control" placeholder="Codice Fiscale" id="cf" readonly />
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control" placeholder="Phone" id="phone">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" placeholder="Password" id="password">
                    </div>
                    <div class="form-group">
                        <label id="message" style="color:blue;"></label>
                    </div>
                    <div style="text-align:center;">
                    <button type="button" class="btn btn-outline btn-primary" id="annulla" >Annulla</button>
                    <button type="button" class="btn btn-outline btn-success" id="modifica" >Modifica</button>
                </div>
                </div>
                </form>
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
