<!DOCTYPE html>
<html>
    <head>
        <title>MinimAlis</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <link rel="icon" type="image/png" href="assets/ico/html5.png" />
        
        <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body>
        <div role="navigation" class="navbar navbar-inverse navbar-static-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand">
                        <span class="fa fa-html5"></span>
                        MinimAlis
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="toggle">
                            <a id="toggle-navbar-side"><span class="fa fa-th-large"></span></a>
                        </li>

                        <li class="active">
                            <a href="#">Dashboard</a>
                        </li>
                        
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Forms <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="forms/basics.php">Basic Forms</a></li>
                                <li><a href="#">Extended Forms</a></li>
                                <li><a href="#">Validation</a></li>
                                <li><a href="#">Wizard</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Components <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Timeline</a></li>
                                <li><a href="#">Page Statistics</a></li>
                                <li><a href="#">Sidebar Widgets</a></li>
                                <li><a href="#">Messages & Chat</a></li>
                                <li><a href="#">Gallery & Thumbs</a></li>
                                <li><a href="#">Tiles</a></li>
                                <li><a href="#">Icons & Buttons</a></li>
                                <li><a href="#">UI Elements</a></li>
                                <li><a href="#">Typography</a></li>
                                <li><a href="#">Bootstrap Elements</a></li>
                                <li><a href="#">Grid</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Tables <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Basic Tables</a></li>
                                <li><a href="#">Dinamic Tables</a></li>
                                <li><a href="#">Large Tables</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Plugins <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Charts</a></li>
                                <li><a href="#">Calendar</a></li>
                                <li><a href="#">File Manager</a></li>
                                <li><a href="#">File Trees</a></li>
                                <li><a href="#">Editable Elements</a></li>
                                <li><a href="#">Maps</a></li>
                                <li><a href="#">Drag & Drop Widgets</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Pages <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">satu</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Layouts <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">satu</a></li>
                            </ul>
                        </li>
                    </ul>
      
                    <!--form role="search" class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" placeholder="Search" class="form-control">
                        </div>
                        
                        <button class="btn btn-default" type="submit">Submit</button>
                    </form-->
      
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="glyphicon glyphicon-user glyphicon-left"></span>
                                <?php echo $_SERVER['REMOTE_ADDR']; ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </div>
        
        <div class="container-fluid page-content">
            <div class="navbar-side">
                <ul class="nav bs-sidenav">
                    <li class="active">
                        <a class="" href="http://localhost:235/master_data/handler">Handler</a>
                    </li>
                    <li class="">
                        <a class="" href="http://localhost:235/master_data/module">Message Module</a>
                    </li>
                    <li class="">
                        <a class="" href="http://localhost:235/master_data/charging">Charging</a>
                    </li>
                    <li class="">
                        <a class="" href="http://localhost:235/master_data/operator">Operator</a>
                    </li>
                    <li class="">
                        <a class="" href="http://localhost:235/master_data/adn">ADN</a>
                    </li>
                    <li class="">
                        <a class="" href="http://localhost:235/master_data/test_number">Test Number</a>
                    </li>
                    <li class="">
                        <a class="" href="http://localhost:235/master_data/message_reply_charging">Message Reply/Charging</a>
                    </li>
                </ul>
            </div>

            <div class="container-fluid content">