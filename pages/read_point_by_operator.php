<?php
session_start();
//Controllo che si è loggato!
if(!(isset($_SESSION['CF']) && isset($_SESSION['FULLNAME'])))
    header('Location: ./notfound.html');
include("../script_tncweb/function.php");
$con=connect();
$operator=$_GET['operator'];
$query="select * from user where FULLNAME='".$operator."'";
$ris=run_query($query,$con);
$row = mysql_fetch_array($ris);
$cf_operator=$row['CF'];
$query="select * from rilievo where CF_USER='".$cf_operator."' AND STATO is not null";
$ris=run_query($query,$con);

$er=array();

$censimenti=array();

if(mysql_num_rows($ris)>0)
{
    $er['ERROR']='none';
    //header('Location: ../pages/index.html');

    while ($row = mysql_fetch_array($ris)) {
        $censimento = array();
        $censimento['DENOMINAZIONE'] = $row['DENOMINAZIONE'];
        $censimento['LATITUDINE'] = $row['LATITUDINE'];
        $censimento['LONGITUDINE'] = $row['LONGITUDINE'];
        $censimento['CIVICO'] = $row['CIVICO'];
        $censimento['DUG'] = $row['DUG'];
        $censimento['ESPONENTE'] = $row['ESPONENTE'];
        $censimento['PATHFOTOCIVICO'] = $row['PATHFOTOCIVICO'];
        $censimento['PATHFOTOABITAZIONE'] = $row['PATHFOTOABITAZIONE'];
        $censimento['CF_USER'] = $row['CF_USER'];
        $censimento['DATA'] = $row['DATA'];
        $censimento['STATO']=$row['STATO'];
        $censimento['NOMECOMUNE'] = $row['NOMECOMUNE'];
        $censimento['CODISTAT'] = $row['CODISTAT'];
        $censimento['CF_SUPERUSER'] = $row['CF_SUPERUSER'];
        array_push($censimenti, $censimento);
    }
    $er['RESULT']=$censimenti;

}
else
    $er['ERROR']='yes';
close_connection($ris,$con);
?>
<!DOCTYPE html>
<html lang="en" CF="<?php echo $_SESSION['CF']; ?>" FULLNAME="<?php echo $_SESSION['FULLNAME']; ?>">

<!DOCTYPE html>
<html lang="en">

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
    <script type="text/javascript">
        var map;
        var marker;

        $(document).ready(function() {

            $("#fullname_user").text($('html').attr('FULLNAME')+" ");

            var jsonStr = <?php echo json_encode($er); ?>;

            if (jsonStr['ERROR'] == 'none') {
                // $("#message").text(jsonStr['RESULT']);
                for (var i = 0; i < jsonStr['RESULT'].length; i++) {
                    var counter = jsonStr['RESULT'][i];
                    console.log(counter['DENOMINAZIONE'] + " - LONGITUDINE:"
                        + counter['LONGITUDINE'] + " LATITUDINE:" + counter['LATITUDINE']);

                    var myLatLng = {lat: parseFloat(counter['LATITUDINE']), lng: parseFloat(counter['LONGITUDINE'])};

                    if(counter['STATO']=="VALIDATO")
                    {

                        marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            title: counter['DENOMINAZIONE'],
                            icon: 'http://maps.google.com/mapfiles/ms/micons/green-dot.png'
                        });
                    }
                    else if (counter['STATO']=="NON VALIDATO")
                    {
                        marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            title: counter['DENOMINAZIONE']
                        });
                    }
                    else if(counter['STATO']=="IN ATTESA")
                    {

                        marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            title: counter['DENOMINAZIONE'],
                            icon: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
                        });
                    }

                    var esponente = "";
                    if (counter['ESPONENTE'] != "NON DISPONIBILE")
                        esponente = counter['ESPONENTE'];

                    var contentString = '<div id="content">' +
                        '<div id="siteNotice">' +
                        '</div>' +
                        '<h3 id="firstHeading" class="firstHeading">' + counter['DUG'] + " " + counter['DENOMINAZIONE'] +
                        " " + esponente + " " + counter['CIVICO'] + '</h3>' +
                        '<div id="bodyContent">' +
                        '<p><b>Data rilievo: </b>' + counter['DATA'] + '<br/>' +
                        'Longitudine: ' + counter['LONGITUDINE'] + '<br/>' +
                        'Latitudine: ' + counter['LATITUDINE'] + '<br/>' +
                        'Codistat: ' + counter['CODISTAT'] + '<br/>' +
                        'Nome comune: ' + counter['NOMECOMUNE'] + '<br/>' +
                        'Foto abitazione: <a href="' + counter['PATHFOTOABITAZIONE'] + '">Clicca qui</a><br/>' +
                        'Foto civico: <a href="' + counter['PATHFOTOCIVICO'] + '">Clicca qui</a><br/><br/>' +
                        'Per maggiori dettagli <a href="dettaglio_rilievo.php?lat=' + counter['LATITUDINE'] +
                        '&long=' + counter['LONGITUDINE'] + '">fai click qui...</a><br/>' +
                        '</div>' +
                        '</div>';

                    /*)
                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });


                    marker.addListener('click', function () {
                        infowindow.open(map, marker);
                    });
                */

                    var infowindow = new google.maps.InfoWindow()

                    google.maps.event.addListener(marker,'click', (function(marker,contentString,infowindow){
                        return function() {
                            infowindow.setContent(contentString);
                            infowindow.open(map,marker);
                        };
                    })(marker,contentString,infowindow));




                }
            }
        });


        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: {lat: 40.7731935, lng: 14.796560799999952}
            });


            // Define the LatLng coordinates for the polygon's path.
            /*
            var Roccapiemonte = [
                {lat:40.7657981158734, lng:14.6961246283405},
                {lat:40.7684736939535, lng:14.6943572742833},
                {lat:40.7670027105486, lng:14.6866980378971},
                {lat:40.766536663893,  lng:14.6776360781577},
                {lat:40.7667244623426, lng:14.6771141307328},
                {lat:40.7670457828174, lng:14.6756193683446},
                {lat:40.7679981277934, lng:14.6594882874894},
                {lat:40.7670438885875, lng:14.6563774577233},
                {lat:40.76596586391381,lng:14.657247397652},
                {lat:40.7659766396426, lng:14.6582180709581},
                {lat:40.7650346156357, lng:14.6620864938814},
                {lat:40.7648484274642, lng:14.6626685492568},
                {lat:40.763009152601,  lng:14.6656516027216},
                {lat:40.7624713193261, lng:14.6665188912293},
                {lat:40.76139466943971,lng:14.6675422542161},
                {lat:40.7608076765326, lng:14.6678540619316},
                {lat:40.7601071958191, lng:14.6680940382282},
                {lat:40.759269436998,  lng:14.6682882741261},
                {lat:40.75837850500201,lng:14.6686481545231},
                {lat:40.7576128717951, lng:14.6691141535224},
                {lat:40.75686864124351,lng:14.6698764453449},
                {lat:40.7536782308659, lng:14.6755189449492},
                {lat:40.75370127201741,lng:14.6803410889426},
                {lat:40.7537269738605, lng:14.6857275535856},
                {lat:40.7536372067753, lng:14.6883297091426},
                {lat:40.7535472374918, lng:14.6904698736429},
                {lat:40.7527319858736, lng:14.6960288748174},
                {lat:40.74724325291361,lng:14.7039725070869},
                {lat:40.74521620003811,lng:14.705733761767},
                {lat:40.7517985984509, lng:14.7138506743964},
                {lat:40.7542385364511, lng:14.7100354301736},
                {lat:40.7657981158734, lng:14.6961246283405}
            ];
            */

            var Fisciano = [
                {lat:40.7569672387864, lng:14.8469033932164},
                {lat:40.7548932018406, lng:14.8440531838236},
                {lat:40.75460309534711,lng: 14.8434735532348},
                {lat:40.7543970452326, lng:14.8424796062293},
                {lat:40.7572502249888, lng:14.8358376567619},
                {lat:40.7644690742173, lng:14.8205711954808},
                {lat:40.7753523414929, lng:14.8144276698351},
                {lat:40.7759696457375, lng:14.8185965360347},
                {lat:40.7768306464178, lng:14.8215938018657},
                {lat:40.7770860903149, lng: 14.8221490467869},
                {lat:40.7777808228682, lng:14.822917450509},
                {lat:40.7811907444461, lng:14.825350828816},
                {lat:40.7835873101809, lng:14.826552773831},
                {lat:40.7844887991609, lng:14.8268820128328},
                {lat:40.79021181605331,lng:14.8286098577924},
                {lat:40.7910419063102, lng: 14.8285716610082},
                {lat:40.7917264052915, lng: 14.8284755328428},
                {lat:40.7925348771965, lng:14.8283310610717},
                {lat:40.7932809556526, lng:14.8279967833361},
                {lat:40.7936785296411, lng:14.8277007653922},
                {lat:40.7940855168954, lng:14.8270413503017},
                {lat:40.7941551990348, lng:14.8264656000153},
                {lat:40.7944147946612, lng:14.8256947852795},
                {lat:40.7948817770413, lng:14.8248281484863},
                {lat:40.8003093304545, lng:14.8173691141031},
                {lat:40.8031436620117, lng:14.8146344225689},
                {lat:40.8039196602481, lng:14.8138857252676},
                {lat:40.8045291122828, lng: 14.8127811023978},
                {lat:40.8047199934392, lng:14.8118712880723},
                {lat:40.80480779512491,lng:14.8114527776093},
                {lat:40.8051418080726, lng: 14.8082271656103},
                {lat:40.8050412347875, lng:14.8076341827317},
                {lat:40.8026580916892, lng:14.7994732522797},
                {lat:40.8019108009578, lng:14.7992976650185},
                {lat:40.799482953517,  lng:14.7913867218854},
                {lat:40.8011219421419, lng: 14.7860391630079},
                {lat:40.8017048252549, lng:14.7810419768125},
                {lat:40.8054401952143, lng: 14.7743309989603},
                {lat:40.80465885183041,lng:14.7650898745179},
                {lat:40.8042049422059, lng:14.7652321183009},
                {lat:40.8036291889534, lng:14.7653514864993},
                {lat:40.8030301579324, lng: 14.7654239995213},
                {lat:40.8023561724852, lng:14.7654686138214},
                {lat:40.7927464198528, lng:14.7656150610603},
                {lat:40.7920295681202, lng:14.7656269676265},
                {lat:40.7917210545204, lng:14.7656233598447},
                {lat:40.791310885349,  lng: 14.7656154165859},
                {lat:40.7907116811508, lng:14.7656034456002},
                {lat:40.78939808508691,lng:14.7654228596773},
                {lat:40.7891134235096, lng:14.7653838260127},
                {lat:40.7887724198636, lng:14.7651879401476},
                {lat:40.7885793221815, lng:14.7650708599837},
                {lat:40.7880666086997, lng: 14.7647599920637},
                {lat:40.7878029041954, lng:14.7646001050772},
                {lat:40.7874671622524, lng:14.7643619763465},
                {lat:40.786364844574,  lng:14.7633664000576},
                {lat:40.7861550557345, lng:14.7631471864249},
                {lat:40.7855943062338, lng:14.7625612540961},
                {lat:40.7854407123894, lng: 14.762400764736},
                {lat:40.7853175963032, lng:14.7622721221207},
                {lat:40.7835511882686, lng:14.7600824887407},
                {lat:40.7829558182788, lng:14.759343276363},
                {lat:40.7823692811849, lng:14.7585665082948},
                {lat:40.7801534381833, lng:14.7580818824421},
                {lat:40.77992521812191,lng: 14.758054962062},
                {lat:40.7780294733186, lng:14.7580426703552},
                {lat:40.77777983606111,lng: 14.7580529596206},
                {lat:40.7776053941879, lng: 14.7580723597328},
                {lat:40.77582884547091,lng: 14.75897988865},
                {lat:40.7756018901326, lng: 14.7591727815223},
                {lat:40.7753681482864, lng:14.7593714406809},
                {lat:40.7732237490459, lng:14.7636334041767},
                {lat:40.77284582531431,lng:14.7646182129894},
                {lat:40.7695769156715, lng:14.7737056091006},
                {lat:40.7611526492431, lng:14.7678464150925},
                {lat:40.760494131727,  lng: 14.7683227783251},
                {lat:40.7601086726543, lng:14.7687392100911},
                {lat:40.7576282219195, lng:14.7723366776105},
                {lat:40.757332711264,  lng:14.7732025861987},
                {lat:40.7571975543347, lng:14.7738517948284},
                {lat:40.7571547826214, lng:14.7740572389496},
                {lat:40.7570653575591, lng:14.7744945866005},
                {lat:40.7578134203366, lng: 14.7778811842591},
                {lat:40.7568237167358, lng:14.789328354844},
                {lat:40.7561373437229, lng: 14.7932165252023},
                {lat:40.752990316128,  lng:14.7970758425662},
                {lat:40.7453311302895, lng:14.8054384586028},
                {lat:40.7382618875071, lng: 14.811734590122},
                {lat:40.7370282663681, lng:14.8123657659526},
                {lat:40.7359449376189, lng:14.8129619716392},
                {lat:40.7352194446652, lng:14.8139584899271},
                {lat:40.7313710039602, lng:14.8199257972324},
                {lat:40.7327523066259, lng:14.8202906419241},
                {lat:40.7332217443562, lng:14.8207976414578},
                {lat:40.7361844881657, lng:14.8257527048592},
                {lat:40.7373657191739, lng:14.8283783077788},
                {lat:40.7379436809474, lng:14.8294074886308},
                {lat:40.7411497798517, lng: 14.8331064632597},
                {lat:40.7420154828927, lng:14.8338747137511},
                {lat:40.7451327494351, lng:14.8361283178519},
                {lat:40.7481806338386, lng: 14.8380631402456},
                {lat:40.7488314478887, lng:14.8386307012894},
                {lat:40.7505363154513, lng:14.8410426329012},
                {lat:40.7522535981954, lng:14.8440949805267},
                {lat:40.7525406710424, lng:14.8447342502695},
                {lat:40.752722700825, lng:14.8456690980671},
                {lat:40.7531148046686, lng:14.8478719739021},
                {lat:40.7569672387864, lng:14.8469033932164},
            ];



            var comuneFisciano = new google.maps.Polygon({
                paths: Fisciano,
                strokeColor: '#1439ff',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#1439ff',
                fillOpacity: 0.10
            });
            comuneFisciano.setMap(map);
            /*

            var myLatLng = {lat: 40.7777896012147, lng: 14.7583025077829};

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!'
            });
            */
        }

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

        <div id="map"></div>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmHJRiCR5sZ2jTMxkTIqZDQa6GV4hMzYg&callback=initMap&callback=initMap">
        </script>


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
