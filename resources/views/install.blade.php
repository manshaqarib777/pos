<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Next Advance Point Of Sale</title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link rel="icon" href="" type="image/x-icon"/>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link  rel="stylesheet" href="css/bootstrap.min.css">
        <link  rel="stylesheet" href="css/azzara.min.css">
        <link  rel="stylesheet" href="css/font-awesome.css">
        <link  rel="stylesheet" href="css/custom.css">
    </head>
    <body>
        <div class="wrapper pl-5 pr-5 pt-2">
            <div class="content">
                <div id="app">
                    <div class="card bg-default">
                        <div class="card-header p-2 text-center">
                            <h4 class="card-title text-white">
                            <i class="fa fa-star" aria-hidden="true"></i> Installation : Next Advance Point Of Sale <small>Version 1.88 </small> </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 p-1">
                                    <div class="card card-default">
                                        <div class="card-body">
                                            <h2></h2>
                                            <h3 class="text-danger"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            Attention:</strong> Use below login credentials & Don't forget to change login credentials once logged in after successful installation. </h3>
                                            <strong>Use built-in User with Permission dereference to login and Save or Copy Default Login credentials before installation,:</strong>
                                            <ul class="pt-2">
                                                <li><strong>For Owner:</strong> owner@pos.codehas.com </li>
                                                <li><strong>For Admin :</strong> admin@pos.codehas.com </li>
                                                <li><strong>For Manager:</strong> manager@pos.codehas.com </li>
                                                <li><strong>For Purchaser :</strong> purchaser@pos.codehas.com </li>
                                                <li><strong>For Salesman :</strong> seller@pos.codehas.com </li>
                                            </ul>
                                            <h2>
                                            <strong><i class="fa fa-key" aria-hidden="true"></i>
                                            Password for all: 12345678</strong>
                                            </h2>
                                            <p>
                                                <strong>Note:</strong>
                                                Every User has attached Permission group according to his role.it can may be proficient or not but obviously could be modify/change/remove or create new as you need,our basic concept make our clients ready to get started as quickly without doing minimum efforts.Owner account has full permissions to control every step.System does not allow to modify Or change Permission group for Owner account but rest of all could be modified as per required.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-white p-1">
                                    <h1 class="text-success"> Pre-Install Checklist:</h1><hr>
                                    @if(phpversion() < "5.3")
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> Your PHP version is {{phpversion()}}! PHP 5.3 or higher required!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> You are running PHP {{phpversion()}}</div>
                                    @endif
                                    @if(!extension_loaded('mcrypt'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> Mcrypt PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> Mcrypt PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('mysqli'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> Mysqli PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> Mysqli PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('mbstring'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> MBString PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> MBString PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('gd'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> GD PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> GD PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('curl'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> CURL PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> CURL PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('openssl'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> OPENSSL PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> OPENSSL PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('pdo'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> PDO PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> PDO PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('tokenizer'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> TOKENIZER PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> TOKENIZER PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('xml'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> XML PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> XML PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('Ctype'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> Ctype PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> Ctype PHP extension loaded!</div>
                                    @endif
                                    @if(!extension_loaded('json'))
                                    <?php $error = true?>
                                    <div class='p-1 m-1 bg-danger'>
                                    <i class="fa fa-times" aria-hidden="true"></i> JSON PHP extension missing!</div>
                                    @else
                                    <div class='p-1 m-1 bg-success'>
                                    <i class='fa fa-check' aria-hidden="true"></i> JSON PHP extension loaded!</div>
                                    @endif
                                </div>
                                <div class="p-1 col-md-4 text-left">
                                    <form  class="form-horizontal" id="formInstall">
                                        <div id="div_database_host" class="form-group required">
                                            <label for="database_host"  required class="text-white control-label  requiredField">
                                                Database Hostname <span class="asteriskField">*</span>
                                            </label>
                                            <div class="controls">
                                                <input class="textinput textInput form-control" id="database_host"  name="database_host" placeholder="Hostname" type="text" value="127.0.0.1" />
                                            </div>
                                        </div>
                                        <div id="div_database_port" class="form-group required">
                                            <label for="database_port"  required class="text-white control-label  requiredField">
                                                Database Port <span class="asteriskField">*</span>
                                            </label>
                                            <div class="controls">
                                                <input class=" textinput textInput form-control" id="database_port"  name="database_port" placeholder="Database Port" type="number" value="3306" />
                                            </div>
                                        </div>
                                        <div id="div_database_name" class="form-group required">
                                            <label for="database_name"  required class="text-white control-label  requiredField">
                                                Database Name <span class="asteriskField">*</span>
                                            </label>
                                            <div class="controls">
                                                <input class=" textinput textInput form-control" id="database_name"  name="database_name" placeholder="Database Name" type="text" value="next-pos" />
                                            </div>
                                        </div>
                                        <div id="div_database_user" class="form-group required">
                                            <label for="database_user"  required class="text-white control-label  requiredField">
                                                DB User<span class="asteriskField">*</span>
                                            </label>
                                            <div class="controls">
                                                <input class=" textinput textInput form-control" id="database_user"  name="database_user" placeholder="Database user" type="text" value="root" />
                                            </div>
                                        </div>
                                        <div id="div_database_password" class="form-group required">
                                            <label for="database_password"  required class="text-white control-label  requiredField">
                                                DB Password<span class="asteriskField">*</span>
                                            </label>
                                            <div class="controls">
                                                <input class=" textinput textInput form-control" id="database_password"  name="database_password" placeholder="Database Password" type="password" value="" />
                                            </div>
                                        </div>
                                        @if(!isset($error))
                                        <div class="form-group">
                                            <div class="controls col-md-offset-4">
                                                <input required class="checkboxinput" id="id_terms" name="terms" type="checkbox" />
                                                <strong class="text-white"> Agree to install</strong>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="controls "></div>
                                            <div class="controls">
                                                <input type="button" data-loading-text="Installing.."  value="Begin Install" class="btn btn-sm btn-block btn-info" id="submit-install" />
                                            </div>
                                        </div>
                                        @else
                                        <p class="text-danger">Error: Pre-Install Checklist</p>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="msg" class="form-group"></div>
                                                <div class="progress">
                                                    <div class="progress-bar bar-zero" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <script src="js/app.js"></script>
        <!-- jQuery UI -->
        <script src="js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script src="js/font-awesome.js"></script>
        <script src="js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
        <!-- jQuery Scrollbar -->
        <script src="js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <script src="/js/plugin/installer/jquery.validate.min.js"></script>
        <script src="/js/plugin/installer/process.js"></script>
    </body>
</html>
