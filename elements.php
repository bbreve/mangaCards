<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
  
  <title>Techie - Bootstrap 3 modern skin</title>
  
  <link href='https://fonts.googleapis.com/css?family=Lato:400,300,400italic,700,900' rel='stylesheet' type='text/css'>

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="Techie Bootstrap 3 skin">
  <meta name="keywords" content="bootstrap 3, skin, flat">
  <meta name="author" content="bootstraptaste">
  
  <!-- Bootstrap css -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/bootstrap.techie.css" rel="stylesheet">

<!-- =======================================================
    Theme Name: Techie
    Theme URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
======================================================= -->

  <!-- Docs Custom styles -->
  <style>
body,html{overflow-x:hidden}body{padding:60px 20px 0}footer{border-top:1px solid #ddd;padding:30px;margin-top:50px}.row>[class*=col-]{margin-bottom:40px}.navbar-container{position:relative;min-height:100px}.navbar.navbar-fixed-bottom,.navbar.navbar-fixed-top{position:absolute;top:50px;z-index:0}.navbar.navbar-fixed-bottom .container,.navbar.navbar-fixed-top .container{max-width:90%}.btn-group{margin-bottom:10px}.form-inline input[type=password],.form-inline input[type=text],.form-inline select{width:180px}.input-group{margin-bottom:10px}.pagination{margin-top:0}.navbar-inverse{margin:110px 0}
  </style>
  
</head>

<body>

  <div class="container">
  
 <div class="jumbotron">
  <h1>Techie Bootstrap 3 Skin</h1>
  <p>Download this free Bootstrap 3 skin only from <a href="http://bootstraptaste.com">Bootstraptaste</a></p>
  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
</div>

    <!-- Buttons -->
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        
        <h2>Buttons</h2>
          <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Button</th>
                  <th>Large Button</th>
                  <th>Small Button</th>
                  <th>Disabled Button</th>
                  <th>Button with Icon</th>
                  <th>Block Button</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a class="btn btn-default" href="#">Default</a></td>
                  <td><a class="btn btn-lg btn-default" href="#">Default</a></td>
                  <td><a class="btn btn-sm btn-default" href="#">Default</a></td>
                  <td><a class="btn disabled btn-default" href="#">Default</a></td>
                  <td><a class="btn btn-default" href="#"><i class="fa fa-cog"></i> Default</a></td>
                  <td><a class="btn btn-block btn-default" href="#">Default</a></td>
                </tr>
                <tr>
                  <td><a class="btn btn-primary" href="#">Primary</a></td>
                  <td><a class="btn btn-primary btn-lg" href="#">Primary</a></td>
                  <td><a class="btn btn-primary btn-sm" href="#">Primary</a></td>
                  <td><a class="btn btn-primary disabled" href="#">Primary</a></td>
                  <td><a class="btn btn-primary" href="#"><i class="fa fa-shopping-cart fa-fw"></i> Primary</a></td>
                  <td><a class="btn btn-primary btn-block" href="#">Primary</a></td>
                </tr>
                <tr>
                  <td><a class="btn btn-success" href="#">Success</a></td>
                  <td><a class="btn btn-success btn-lg" href="#">Success</a></td>
                  <td><a class="btn btn-success btn-sm" href="#">Success</a></td>
                  <td><a class="btn btn-success disabled" href="#">Success</a></td>
                  <td><a class="btn btn-success" href="#"><i class="fa fa-check fa-fw"></i> Success</a></td>
                  <td><a class="btn btn-success btn-block" href="#">Success</a></td>
                </tr>
                <tr>
                  <td><a class="btn btn-info" href="#">Info</a></td>
                  <td><a class="btn btn-info btn-lg" href="#">Info</a></td>
                  <td><a class="btn btn-info btn-sm" href="#">Info</a></td>
                  <td><a class="btn btn-info disabled" href="#">Info</a></td>
                  <td><a class="btn btn-info" href="#"><i class="fa fa-exclamation fa-fw"></i> Info</a></td>
                  <td><a class="btn btn-info btn-block" href="#">Info</a></td>
                </tr>

                <tr>
                  <td><a class="btn btn-warning" href="#">Warning</a></td>
                  <td><a class="btn btn-warning btn-lg" href="#">Warning</a></td>
                  <td><a class="btn btn-warning btn-sm" href="#">Warning</a></td>
                  <td><a class="btn btn-warning disabled" href="#">Warning</a></td>
                  <td><a class="btn btn-warning" href="#"><i class="fa fa-warning fa-fw"></i> Warning</a></td>
                  <td><a class="btn btn-warning btn-block" href="#">Warning</a></td>
                </tr>
                <tr>
                  <td><a class="btn btn-danger" href="#">Danger</a></td>
                  <td><a class="btn btn-danger btn-lg" href="#">Danger</a></td>
                  <td><a class="btn btn-danger btn-sm" href="#">Danger</a></td>
                  <td><a class="btn btn-danger disabled" href="#">Danger</a></td>
                  <td><a class="btn btn-danger" href="#"><i class="fa fa-times fa-fw "></i> Danger</a></td>
                  <td><a class="btn btn-danger btn-block" href="#">Danger</a></td>
                </tr>
              </tbody>
          </table>
        <p class="lead text-muted">Labeled buttons</p>
        <div class="row">
          <div class="col-sm-12">
            <!-- Standard button with label -->
            <button type="button" class="btn btn-labeled btn-default">
              <span class="btn-label">
                <i class="fa fa-arrow-left"></i>
              </span>
              Left
            </button>

            <!-- Standard button with label on the right side -->
            <button type="button" class="btn btn-labeled btn-default">
              Right
              <span class="btn-label btn-label-right">
                <i class="fa fa-arrow-right"></i>
              </span>
            </button>

            <!-- Success button with label -->
            <button type="button" class="btn btn-labeled btn-success">
              <span class="btn-label">
                <i class="fa fa-check"></i>
              </span>
              Success
            </button>

            <!-- Danger button with label -->
            <button type="button" class="btn btn-labeled btn-danger">
              <span class="btn-label">
                <i class="fa fa-times"></i>
              </span>
              Danger
            </button>

            <!-- Danger button with label -->
            <button type="button" class="btn btn-labeled btn-warning">
              <span class="btn-label">
                <i class="fa fa-warning"></i>
              </span>
              Warning
            </button>

            <!-- Danger button with label -->
            <button type="button" class="btn btn-labeled btn-info">
              <span class="btn-label">
                <i class="fa fa-exclamation"></i>
              </span>
              Heads up!
            </button>

          </div>
        </div>

        <div class="row">
          <div class="col-sm-12 col-lg-4">
            <p class="lead text-muted">Groups</p>
            <div class="row">
              <div class="col-sm-8 col-lg-8">
                <div class="btn-group">
                    <button class="btn btn-default">Left</button>
                    <button class="btn btn-default">Middle</button>
                    <button class="btn btn-default">Right</button>
                </div>
                <div class="btn-group">
                   <button class="btn btn-default">1</button>
                   <button class="btn btn-default">2</button>
                   <button class="btn btn-default">3</button>
                   <button class="btn btn-default">4</button>
                </div>
                <div class="btn-group">
                   <button type="button" class="btn btn-default"><i class="fa fa-fw fa-envelope"></i></button>
                   <button type="button" class="btn btn-default"><i class="fa fa-fw fa-adjust"></i></button>
                   <button type="button" class="btn btn-default"><i class="fa fa-fw fa-heart"></i></button>
                   <button type="button" class="btn btn-default"><i class="fa fa-fw fa-camera"></i></button>
                </div>                    
              </div>
              <div class="col-sm-4 col-lg-4">
                 <div class="btn-group btn-group-vertical">
                     <button type="button" class="btn btn-default"><i class="fa fa-align-left"></i></button>
                     <button type="button" class="btn btn-default"><i class="fa fa-align-center"></i></button>
                     <button type="button" class="btn btn-default"><i class="fa fa-align-right"></i></button>
                     <button type="button" class="btn btn-default"><i class="fa fa-align-justify"></i></button>
                    </div>
                    <div class="btn-group btn-group-vertical">
                     <button type="button" class="btn btn-default"><i class="fa fa-fw fa-envelope"></i></button>
                     <button type="button" class="btn btn-default"><i class="fa fa-fw fa-adjust"></i></button>
                     <button type="button" class="btn btn-default"><i class="fa fa-fw fa-heart"></i></button>
                     <button type="button" class="btn btn-default"><i class="fa fa-fw fa-camera"></i></button>
                    </div>                    
               </div>
             </div>
           </div>
           <div class="col-sm-12 col-lg-8">
            <p class="lead text-muted">Button dropdowns</p>
            <div class="btn-toolbar" style="margin: 0;">
                <div class="btn-group">
                  <button class="btn dropdown-toggle btn-default" data-toggle="dropdown">Action <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Danger <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Warning <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Success <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">Info <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
              </div>          
            <div class="btn-toolbar" style="margin: 0;">
                <div class="btn-group">
                  <button class="btn btn-default">Action</button>
                  <button class="btn dropdown-toggle btn-default" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-primary">Action</button>
                  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-danger">Danger</button>
                  <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-warning">Warning</button>
                  <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-success">Success</button>
                  <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
                <div class="btn-group">
                  <button class="btn btn-info">Info</button>
                  <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
              </div>          
            <div class="row">
              <div class="col-sm-6 col-lg-6">
                  <div class="btn-toolbar">
                    <div class="btn-group">
                      <button class="btn btn-lg btn-default">Large action</button>
                      <button class="btn btn-lg dropdown-toggle btn-default" data-toggle="dropdown"><span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                  </div>
                <div class="btn-toolbar">
                    <div class="btn-group">
                      <button class="btn btn-sm btn-default">Small action</button>
                      <button class="btn btn-sm dropdown-toggle btn-default" data-toggle="dropdown"><span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                  </div>
                <div class="btn-toolbar">
                    <div class="btn-group">
                      <button class="btn btn-default btn-xs">X Small action</button>
                      <button class="btn dropdown-toggle btn-default btn-xs" data-toggle="dropdown"><span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                  </div>
              </div>
              <div class="col-sm-6 col-lg-6">
                <div class="btn-toolbar" style="margin: 0;">
                  <div class="btn-group dropup">
                    <button class="btn btn-default">Dropup</button>
                    <button class="btn dropdown-toggle btn-default" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Separated link</a></li>
                    </ul>
                  </div><!-- /btn-group -->
                  <div class="btn-group dropup">
                    <button class="btn primary btn-default">Right dropup</button>
                    <button class="btn primary dropdown-toggle btn-default" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu pull-right">
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="divider"></li>
                      <li><a href="#">Separated link</a></li>
                    </ul>
                  </div><!-- /btn-group -->
                </div>
              </div>
            </div>
          </div>          
        </div>
      </div>
    </div>

    <!-- Tables -->

    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <h2>Tables</h2>
        <div class="row">
          <div class="col-sm-6 col-lg-6">
            <p class="lead text-muted">Striped</p>
            <table class="table table-striped" data-effect="fade">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Larry</td>
                  <td>the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>          
          </div>
          <div class="col-sm-6 col-lg-6">
            <p class="lead text-muted">Bordered</p>
            <table class="table table-bordered" data-effect="fade">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowspan="2">1</td>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
                <tr>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@TwBootstrap</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Jacob</td>
                  <td>Thornton</td>
                  <td>@fat</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td colspan="2">Larry the Bird</td>
                  <td>@twitter</td>
                </tr>
              </tbody>
            </table>            
          </div>
        </div>
      </div>
    </div>



    <!-- Forms -->

    <div class="row"  >

      <div class="col-sm-12 col-lg-12">
        <h2>Forms</h2>
        <div class="row">
          <div class="col-sm-6 col-lg-6" data-effect="slide-left">
            <p class="lead text-muted">Inline</p>
            <form class="form-inline">
              <input type="text" class="form-control" placeholder="Email">
              <input type="password" class="form-control" placeholder="Password">
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Remember me
                </label>
              </div>
              <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
          </div>
          <div class="col-sm-6 col-lg-6" data-effect="slide-right">
            <p class="lead text-muted">Horizontal</p>
            <form class="form-horizontal">
              <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                  <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-10">
                  <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox"> Remember me
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                  <button type="submit" class="btn btn-default">Sign in</button>
                </div>
              </div>
            </form>          
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <h2>Form states</h2>
        <div class="row">
          <div class="col-sm-6">
            <p class="lead text-muted">Validation states</p>
            <div class="form-group has-success">
              <label class="control-label" for="inputSuccess1">Input with success</label>
              <input type="text" class="form-control" id="inputSuccess1">
            </div>
            <div class="form-group has-warning">
              <label class="control-label" for="inputWarning1">Input with warning</label>
              <input type="text" class="form-control" id="inputWarning1">
            </div>
            <div class="form-group has-error">
              <label class="control-label" for="inputError1">Input with error</label>
              <input type="text" class="form-control" id="inputError1">
            </div>
          </div>
          <div class="col-sm-6">
            <p class="lead text-muted">Optional icon</p>
            <div class="form-group has-success has-feedback">
              <label class="control-label" for="inputSuccess2">Input with success</label>
              <input type="text" class="form-control" id="inputSuccess2">
              <span class="fa fa-check form-control-feedback"></span>
            </div>
            <div class="form-group has-warning has-feedback">
              <label class="control-label" for="inputWarning2">Input with warning</label>
              <input type="text" class="form-control" id="inputWarning2">
              <span class="fa fa-warning form-control-feedback"></span>
            </div>
            <div class="form-group has-error has-feedback">
              <label class="control-label" for="inputError2">Input with error</label>
              <input type="text" class="form-control" id="inputError2">
              <span class="fa fa-times form-control-feedback"></span>
            </div>            
          </div>
        </div>
      </div>
      <!-- Controls -->
      <div class="col-sm-12 col-lg-12">
        <h2>Form Controls</h2>
        <div class="row">
          <div class="col-sm-4 col-lg-3">
            <p class="lead text-muted">Inputs</p>
            <input type="text" class="form-control" placeholder="Text input">
            <br>
            <textarea class="form-control" rows="3"></textarea>
          </div>
          <div class="col-sm-4 col-lg-2">
            <p class="lead text-muted">Checkbox</p>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="" checked="">
                Checked
              </label>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="">
                Unchecked
              </label>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="" disabled="">
                Disabled
              </label>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="" disabled="" checked="">
                Disabled Checked
              </label>
            </div>
            <br>
            <label class="checkbox-inline">
              <input type="checkbox" id="inlineCheckbox1" value="option1"> 1
            </label>
            <label class="checkbox-inline">
              <input type="checkbox" id="inlineCheckbox2" value="option2"> 2
            </label>
            <label class="checkbox-inline">
              <input type="checkbox" id="inlineCheckbox3" value="option3"> 3
            </label>           
          </div>
          <div class="col-sm-4 col-lg-2">
            <p class="lead text-muted">Radio</p>
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                Checked 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                Unchecked 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled="">
                Disabled 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="optionsRadios2" id="optionsRadios4" value="option4" disabled="" checked="">
                Disabled Checked 
              </label>
            </div>
          </div>
          <div class="clearfix visible-sm visible-md"></div>
          <div class="col-sm-6 col-lg-2">
            <p class="lead text-muted">Select</p>
            <select class="form-control">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
          <div class="col-sm-6 col-lg-3">
            <p class="lead text-muted">Multiple Select</p>
            <select multiple class="form-control">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
        </div>
      </div>
      <!-- Extended -->
      <div class="col-sm-12 col-lg-12">
        <h2>Form Controls Extended</h2>
        <div class="row">
          <div class="col-sm-4 col-lg-4">
            <p class="lead text-muted">Prepend / Append</p>
            <div class="input-group">
              <span class="input-group-addon">@</span>
              <input type="text" class="form-control" placeholder="Username">
            </div>
            <div class="input-group">
              <input type="text" class="form-control">
              <span class="input-group-addon">.00</span>
            </div>
            <div class="input-group">
              <span class="input-group-addon">$</span>
              <input type="text" class="form-control">
              <span class="input-group-addon">.00</span>
            </div>
          </div>

          <div class="col-sm-4 col-lg-4">
            <p class="lead text-muted">Buttons</p>

            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
              <input type="text" class="form-control">
            </div><!-- /input-group -->

            <div class="input-group">
              <input type="text" class="form-control">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div><!-- /input-group -->

            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </div><!-- /btn-group -->
              <input type="text" class="form-control">
            </div><!-- /input-group -->


          </div>
          <div class="col-sm-4 col-lg-4">
            <p class="lead text-muted">Checkboxes and radio</p>
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox">
              </span>
              <input type="text" class="form-control">
            </div><!-- /input-group -->
            <div class="input-group">
              <span class="input-group-addon">
                <input type="radio">
              </span>
              <input type="text" class="form-control">
            </div><!-- /input-group -->
          </div>
        </div>
      </div>
    </div>


    <!-- COMPONENTS =========================================================== -->
    
    <!-- Navs -->
    
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <h2>Navs</h2>
        <div class="row">
          <div class="col-sm-4 col-lg-4">
            <p class="lead text-muted">Stacked Tabs</p>
            <ul class="nav nav-tabs nav-stacked">
              <li><a href="#">Home</a></li>
              <li><a href="#">Profile</a></li>
              <li><a href="#">Messages</a></li>
            </ul>
          </div>
          <div class="col-sm-4 col-lg-4">
            <p class="lead text-muted">Stacked Pills</p>
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">Profile</a></li>
              <li><a href="#">Messages</a></li>
            </ul>            
          </div>
          <div class="col-sm-4 col-lg-4">
            <p class="lead text-muted">Nav List</p>
            <div class="well" style="max-width: 340px; padding: 8px 0;">
              <ul class="nav nav-list">
                <li class="nav-header">List header</li>
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Library</a></li>
                <li><a href="#">Applications</a></li>
                <li class="divider"></li>
                <li><a href="#">Help</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-lg-6">
            <p class="lead text-muted">Tabs</p>
            <div class="tabbable">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab11" data-toggle="tab">Section 1</a></li>
                <li><a href="#tab12" data-toggle="tab">Section 2</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab11">
                  <p>I'm in Section 1. Donec vulputate tristique elit ut molestie. Suspendisse faucibus bibendum ipsum. </p>
                </div>
                <div class="tab-pane" id="tab12">
                  <p>Howdy, I'm in Section 2.Morbi vel nibh et arcu pretium adipiscing. Ut vestibulum est eget justo facilisis ullamcorper.  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-6">
            <p class="lead text-muted">Left Tabs</p>
            <div class="tabbable tabs-left">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab21" data-toggle="tab">Section 1</a></li>
                <li><a href="#tab22" data-toggle="tab">Section 2</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab21">
                  <p>I'm in Section 1. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc vel eleifend nisl. Nulla eget erat ac massa suscipit suscipit.</p>
                </div>
                <div class="tab-pane" id="tab22">
                  <p>Howdy, I'm in Section 2. Aenean tempor luctus sem quis euismod. Praesent nec metus eu urna tempor varius id quis mauris. Quisque interdum sollicitudin sollicitudin. </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-lg-6" data-effect="slide-left">
            <p class="lead text-muted">Right Tabs</p>
            <div class="tabbable tabs-right">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab31" data-toggle="tab">Section 1</a></li>
                <li><a href="#tab32" data-toggle="tab">Section 2</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab31">
                  <p>I'm in Section 1. Praesent sit amet augue in orci laoreet adipiscing vel vitae urna. Pellentesque eget quam dui, sit amet eleifend mauris. </p>
                </div>
                <div class="tab-pane" id="tab32">
                  <p>Howdy, I'm in Section 2. Quisque pharetra, arcu a consectetur aliquet, mi enim porta enim, quis sodales nisl justo et justo. Morbi non quam in eros varius molestie. </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-6" data-effect="slide-right">
            <p class="lead text-muted">Bottom Tabs</p>
            <div class="tabbable tabs-below">
              <div class="tab-content">
                <div class="tab-pane active" id="tab41">
                  <p>I'm in Section 1. Mauris id augue id elit convallis accumsan. Nullam quis mauris lacus. </p>
                </div>
                <div class="tab-pane" id="tab42">
                  <p>Howdy, I'm in Section 2. Praesent a rhoncus magna. Maecenas tellus mauris, vestibulum nec sagittis dignissim, malesuada at ante. </p>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab41" data-toggle="tab">Section 1</a></li>
                <li><a href="#tab42" data-toggle="tab">Section 2</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- Navbar -->  
      <div class="col-sm-12 col-lg-12">
        <h2>Navbar</h2>
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <p class="lead text-muted">Default</p>

              <nav class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Brand</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Dropdown header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                  <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search">
                    </div>
                  </form>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li><a href="#">Separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </nav>

          </div>
          <div class="col-sm-12 col-lg-12">
            <p class="lead text-muted">Inverted</p>


              <nav class="navbar navbar-inverse" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex2-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Brand</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex2-collapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Dropdown header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                      </ul>
                    </li>
                  </ul>
                  <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search">
                    </div>
                  </form>
                </div><!-- /.navbar-collapse -->
              </nav>

          </div>

          <div class="col-sm-12 col-lg-12 navbar-container">
            <p class="lead text-muted">Fixed Top</p>

              <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex3-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">Brand</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex3-collapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                      </ul>
                    </li>
                  </ul>
                  <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search">
                    </div>
                  </form>
                </div><!-- /.navbar-collapse -->
              </nav>

          </div>  
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Breadcrumbs -->
      <div class="col-sm-6 col-lg-4">
        <h2>Breadcrumbs</h2>
        <ul class="breadcrumb">
          <li class="active">Home</li>
        </ul>
        <ul class="breadcrumb">
          <li><a href="#">Home</a> </li>
          <li class="active">Library</li>
        </ul>
        <ul class="breadcrumb breadcrumb-light breadcrumb-divider-middot">
          <li><a href="#">Home</a> </li>
          <li><a href="#">Library</a> </li>
          <li class="active">Data</li>
        </ul>
      </div>
      <!-- Pagination -->
      <div class="col-sm-6 col-lg-4">
        <h2>Pagination</h2>
        <!-- Pagination Large -->
        <ul class="pagination pagination-lg">
          <li><a href="#">«</a></li>
          <li class="active"><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li class="disabled"><a href="#">»</a></li>
        </ul>
      
        <!-- Pagination Normal -->
        <ul class="pagination">
          <li><a href="#">«</a></li>
          <li class="active"><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li class="disabled"><a href="#">»</a></li>
        </ul>
      
        <!-- Pagination Small -->
        <ul class="pagination pagination-sm">
          <li><a href="#">«</a></li>
          <li class="active"><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li class="disabled"><a href="#">»</a></li>
        </ul>
      
        <ul class="pager">
          <li class="previous">
            <a href="#">← Older</a>
          </li>
          <li class="next">
            <a href="#">Newer →</a>
          </li>
        </ul>
      </div>
      <!-- Labels / Budgets -->
      <div class="col-sm-12 col-lg-4">
        <h2>Labels</h2>
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Label</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                Default
              </td>
              <td class="cleafix">
                  <span class="label label-default pull-left" data-effect="pop">Default</span>
              </td>
            </tr>
            <tr>
              <td>
                Success
              </td>
              <td class="cleafix">
                  <span class="label label-success pull-left" data-effect="pop">Success</span>
              </td>
            </tr>
            <tr>
              <td>
                Warning
              </td>
              <td class="cleafix">
                  <span class="label label-warning pull-left" data-effect="pop">Warning</span>
              </td>
            </tr>
            <tr>
              <td>
                Info
              </td>
              <td class="cleafix">
                  <span class="label label-info pull-left" data-effect="pop">Info</span>
              </td>
            </tr>
            <tr>
              <td>
                Danger
              </td>
              <td class="cleafix">
                  <span class="label label-danger pull-left" data-effect="pop">Danger</span>                
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Thumbnails -->
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <h2>Thumbnails</h2>
        <div class="row">
          <div class="col-sm-12 col-lg-6 " data-effect="slide-bottom">
            <p class="lead text-muted">Default</p>
            <!-- thumbnails container -->
            <div class="row">
              <div class="col-lg-6 col-sm-6 ">
                <a href="#" class="thumbnail">
                  <img src="assets/img/image-placeholder.png" alt="">
                </a>
              </div>
              <div class="col-lg-6 col-sm-6 ">
                <a href="#" class="thumbnail">
                  <img src="assets/img/image-placeholder.png" alt="">
                </a>
              </div>
              <div class="col-lg-6 col-sm-6 ">
                <a href="#" class="thumbnail">
                  <img src="assets/img/image-placeholder.png" alt="">
                </a>
              </div>
              <div class="col-lg-6 col-sm-6 ">
                <a href="#" class="thumbnail">
                  <img src="assets/img/image-placeholder.png" alt="">
                </a>
              </div>
            </div>
            <!-- /Thumbnails container -->
          </div>
          <div class="col-sm-12 col-lg-6 " data-effect="slide-bottom">
            <p class="lead text-muted">With Captions</p>
            <!-- Thumbnails container -->
            <div class="row">
              <div class="col-lg-6 col-sm-6 ">
                <div class="thumbnail">
                  <img src="assets/img/image-placeholder.png" alt="">
                  <div class="caption">
                    <h3>Thumbnail label</h3>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn btn-default">Action</a></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6 ">
                <div class="thumbnail">
                  <img src="assets/img/image-placeholder.png" alt="">
                  <div class="caption">
                    <h3>Thumbnail label</h3>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn btn-danger">Action</a></p>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Thumbnails container -->
          </div>
        </div>
      </div>
    </div>

    <!-- Alerts -->
    <div class="row">
      <div class="col-sm-4 col-lg-4" data-effect="slide-left">
        <h2>Alerts</h2>
        <div class="alert alert-warning">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>Warning!</strong> Best check yo self, you're not looking too good.
        </div>
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>Oh snap!</strong> Change a few things up and try submitting again.
        </div>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>Well done!</strong> You successfully read this important alert message.
        </div>
        <div class="alert alert-info">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
        </div>
      </div>
      <div class="col-sm-4 col-lg-4" data-effect="slide-top">
        <h2>Progress Bar</h2>
        <div class="progress ">
          <div class="progress-bar" style="width: 20%"><span>default</span></div>
        </div>
        <div class="progress ">
          <div class="progress-bar progress-bar-info" style="width: 40%"><span>.info</span></div>
        </div>
        <div class="progress ">
          <div class="progress-bar progress-bar-success" style="width: 60%"><span>.success</span></div>
        </div>
        <div class="progress ">
          <div class="progress-bar progress-bar-warning" style="width: 75%"><span>.warning</span></div>
        </div>
        <div class="progress ">
          <div class="progress-bar progress-bar-danger" style="width: 90%"><span>.danger</span></div>
        </div>
        <div class="progress progress-striped">
          <div class="progress-bar progress-bar-success" style="width: 40%"></div>
        </div>
      </div>
      <div class="col-sm-4 col-lg-4" data-effect="slide-right">
        <h2>Media List</h2>
          <ul class="media-list">
            <li class="media">
              <a class="pull-left" href="#" style="width: 74px; height: 74px;">
                <img class="media-object img-thumbnail" data-src="holder.js/64x64" alt="64x64" src="assets/img/image-placeholder-64x64.png">
              </a>
              <div class="media-body">
                <h5 class="media-heading"><a href="#">Media heading</a></h5>
                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. </p>
              </div>
            </li>
            <li class="media">
              <a class="pull-left" href="#" style="width: 74px; height: 74px;">
                <img class="media-object img-thumbnail"  alt="64x64" src="assets/img/image-placeholder-64x64.png">
              </a>
              <div class="media-body">
                <h5 class="media-heading"><a href="#">Media heading</a></h5>
                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. </p>
              </div>
            </li>
            <li class="media">
              <a class="pull-left" href="#" style="width: 74px; height: 74px;">
                <img class="media-object img-thumbnail" data-src="holder.js/64x64" alt="64x64" src="assets/img/image-placeholder-64x64.png">
              </a>
              <div class="media-body">
                <h5 class="media-heading"><a href="#">Media heading</a></h5>
                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. </p>
              </div>
            </li>
          </ul>
      </div>
    </div>


    <!-- Wells -->
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <h2>Wells</h2>
        <div class="well">
          Look, I'm in a well!
        </div>
      </div>
    </div>


    <!-- JAVASCRIPT =========================================================== -->

    <div class="row">
      <!-- Tooltips -->
      <div class="col-sm-5 col-lg-5">
        <h2>Tooltip</h2>
        <br>
        <br>
        <ul class="list-inline">
          <li><a href="#" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Tooltip on top</a></li>
          <li><a href="#" data-toggle="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</a></li>
          <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">Tooltip on bottom</a></li>
          <li><a href="#" data-toggle="tooltip" data-placement="left" title="Tooltip on left">Tooltip on left</a></li>
        </ul>
      </div>
      <!-- Popovers -->
      <div class="col-sm-7 col-lg-7">
        <h2>Popover</h2>
        <br>
        <br>

        <ul class="list-inline">
          <li><a href="#" class="btn btn-default" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="Popover on top">Popover on top</a></li>
          <li><a href="#" class="btn btn-default" data-toggle="popover" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="Popover on right">Popover on right</a></li>
          <li><a href="#" class="btn btn-default" data-toggle="popover" data-placement="bottom" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="Popover on bottom">Popover on bottom</a></li>
          <li><a href="#" class="btn btn-default" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="Popover on left">Popover on left</a></li>
        </ul>
      </div>
    </div>

    <!-- Buttons toggls -->
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <h2>JavaScript Button</h2>
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <p class="lead text-muted">Stateful</p>
            <button type="button" id="fat-btn" class="btn btn-primary" data-loading-text="Loading..." data-effect="fall">Loading state</button>
          </div>
          <div class="col-sm-6 col-lg-3">
            <p class="lead text-muted">Single toggle</p>
            <button type="button" class="btn btn-primary" data-toggle="button" data-effect="fall">Single Toggle</button>
          </div>
          <div class="col-sm-6 col-lg-3">
            <p class="lead text-muted">Checkbox</p>
            <div class="btn-group" data-toggle="buttons" data-effect="fall">
              <label class="btn btn-primary">
                <input type="checkbox"> Option 1
              </label>
              <label class="btn btn-primary">
                <input type="checkbox"> Option 2
              </label>
              <label class="btn btn-primary">
                <input type="checkbox"> Option 3
              </label>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <p class="lead text-muted">Radio</p>
            <div class="btn-group" data-toggle="buttons" data-effect="fall">
              <label class="btn btn-primary">
                <input type="radio" name="options" id="option1"> Option 1
              </label>
              <label class="btn btn-primary">
                <input type="radio" name="options" id="option2"> Option 2
              </label>
              <label class="btn btn-primary">
                <input type="radio" name="options" id="option3"> Option 3
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <!-- Accordion -->
      <div class="col-sm-6 col-lg-6">
        <h2>Accordion</h2>
        <div class="accordion" id="accordion2">
          <div class="accordion-group">
            <div class="accordion-heading">

              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                <em class="fa fa-minus fa-fw"></em>Collapsible Group Item #1
              </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse in">
              <div class="accordion-inner">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                <em class="fa fa-plus fa-fw"></em>Collapsible Group Item #2
              </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse">
              <div class="accordion-inner">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                <em class="fa fa-plus fa-fw"></em>Collapsible Group Item #3
              </a>
            </div>
            <div id="collapseThree" class="accordion-body collapse">
              <div class="accordion-inner">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Toggle -->
      <!-- Toogle are the same as accordion by without data-parent attribute. It allows to have all boxes opened at the same time. -->
      <div class="col-sm-6 col-lg-6">
        <h2>Toggle</h2>
        <div class="accordion" id="accordion3">
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#toggleOne">
                <em class="fa fa-minus fa-fw"></em>Toggle Box Item #1
              </a>
            </div>
            <div id="toggleOne" class="accordion-body collapse in">
              <div class="accordion-inner">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#toggleTwo">
                <em class="fa fa-minus fa-fw"></em>Toggle Box Item #2
              </a>
            </div>
            <div id="toggleTwo" class="accordion-body collapse in">
              <div class="accordion-inner">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#toggleThree">
                <em class="fa fa-plus fa-fw"></em>Toggle Box Item #3
              </a>
            </div>
            <div id="toggleThree" class="accordion-body collapse">
              <div class="accordion-inner">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-6 col-lg-6">
        <h3>Collapsible Panels</h3>
        <div class="panel-group" id="accordion-panel">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#collapseOnePanel">
                  Collapsible Group Item #1
                </a>
              </h4>
            </div>
            <div id="collapseOnePanel" class="panel-collapse collapse in">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#collapseTwoPanel">
                  Collapsible Group Item #2
                </a>
              </h4>
            </div>
            <div id="collapseTwoPanel" class="panel-collapse collapse">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#collapseThreePanel">
                  Collapsible Group Item #3
                </a>
              </h4>
            </div>
            <div id="collapseThreePanel" class="panel-collapse collapse">
              <div class="panel-body">
                Aliquam facilisis, orci in vulputate posuere, sapien dolor dapibus orci, vitae venenatis dui elit vitae lorem. Sed porta fermentum felis in molestie. Sed porta fermentum felis in molestie. Sed porta fermentum felis in molestie. 
              </div>
            </div>
          </div>
        </div>        
      </div>
      <div class="col-sm-6 col-lg-6">
        <h3>With panel styles </h3>
        <div class="panel-group" id="accordion-panel2">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel2" href="#collapseOnePanel2">
                  Collapsible Group Item #1
                </a>
              </h4>
            </div>
            <div id="collapseOnePanel2" class="panel-collapse collapse in">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
          <div class="panel panel-success">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel2" href="#collapseTwoPanel2">
                  Collapsible Group Item #2
                </a>
              </h4>
            </div>
            <div id="collapseTwoPanel2" class="panel-collapse collapse">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
          <div class="panel panel-success">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel2" href="#collapseThreePanel2">
                  Collapsible Group Item #3
                </a>
              </h4>
            </div>
            <div id="collapseThreePanel2" class="panel-collapse collapse">
              <div class="panel-body">
                Aliquam facilisis, orci in vulputate posuere, sapien dolor dapibus orci, vitae venenatis dui elit vitae lorem. Sed porta fermentum felis in molestie. Sed porta fermentum felis in molestie. Sed porta fermentum felis in molestie. 
              </div>
            </div>
          </div>
        </div>           
      </div>
    </div>


    <div class="row">
      <!-- Slider -->
      <div class="col-sm-6 col-lg-6">
        <h2>Carousel</h2>
        <div id="myCarousel" class="carousel slide">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="item active">
              <img src="assets/img/bootstrap-mdo-sfmoma-01.jpg" alt="">
              <div class="carousel-caption caption-right">
                <h4>Title 1</h4>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <br>
                <a href="#" class="btn btn-info btn-sm">Read more</a>
              </div>
            </div>
            <!-- Slide 2 -->
            <div class="item">
              <img src="assets/img/bootstrap-mdo-sfmoma-02.jpg" alt="">
              <div class="carousel-caption caption-left">
                <h4>Title 2</h4>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <br>
                <a href="#" class="btn btn-danger btn-sm">Read more</a>
              </div>
            </div>
            <!-- Slide 3 -->
            <div class="item">
              <img src="assets/img/bootstrap-mdo-sfmoma-03.jpg" alt="">
              <div class="carousel-caption">
                <h4>A very long thumbnail title here to fill the space</h4>
                <br>
              </div>
            </div>
          </div>
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="fa fa-chevron-left icon-prev"></span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="fa fa-chevron-right icon-next"></span>  
          </a>
        </div>        
      </div>

      <!-- Thumbnail Slider -->
      <div class="col-lg-offset-1 col-lg-4 offset-sm-1 col-sm-5">
        <h3>Thumbnail Fade Carousel</h3>
        <div id="myCarouselV" class="carousel thumbnail fade">
          <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="item active">
              
                <img src="assets/img/bootstrap-mdo-sfmoma-01.jpg" alt="">
                <div class="carousel-caption">
                  <h4>Title 1</h4>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies.</p>
                  <a href="#" class="btn btn-info btn-sm">Read more</a>
                </div>
              
            </div>
            <!-- Slide 2 -->
            <div class="item">
              <img src="assets/img/bootstrap-mdo-sfmoma-02.jpg" alt="">
              <div class="carousel-caption">
                <h4>Title 2</h4>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies.</p>
                <a href="#" class="btn btn-danger btn-sm">Read more</a>
              </div>
            </div>
            <!-- Slide 3 -->
            <div class="item">
              <img src="assets/img/bootstrap-mdo-sfmoma-03.jpg" alt="">
              <div class="carousel-caption">
                <h4>Title 3</h4>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies.</p>
                <a href="#" class="btn btn-warning btn-sm">Read more</a>
              </div>
            </div>
          </div>
          <a class="left carousel-control" href="#myCarouselV" data-slide="prev">
            <span class="fa fa-chevron-right icon-prev"></span>  
          </a>
          <a class="right carousel-control" href="#myCarouselV" data-slide="next">
          <span class="fa fa-chevron-right icon-next"></span>  
          </a>
        </div>        
      </div>      
    </div>


    <div class="row">
      <!-- Modal -->
      <div class="col-sm-8 col-lg-8">
        <h2>Modal</h2>
        <div class="row">
          <div class="col-sm-4 col-lg-4">
            <a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg">Launch modal</a>
          </div>
          <div class="col-sm-8 col-lg-8">

            <div class="modal" style="position: relative; display: block; overflow: auto">
              <div class="modal-dialog" style="padding-top: 0; width: auto">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Modal title</h4>
                  </div>
                  <div class="modal-body">
                    <p>One fine body…</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>

             <!-- sample modal content -->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                  </div>
                  <div class="modal-body">
                    <h4>Text in a modal</h4>
                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>

                    <h4>Popover in a modal</h4>
                    <p>This <a href="#" role="button" class="btn btn-default" data-toggle="popover" title="A Title" data-content="And here's some amazing content. It's very engaging. right?">button</a> should trigger a popover on click.</p>

                    <h4>Tooltips in a modal</h4>
                    <p><a href="#" data-toggle="tooltip" title="Tooltip">This link</a> and <a href="#" data-toggle="tooltip" title="Tooltip">that link</a> should have tooltips on hover.</p>

                    <hr>

                    <h4>Overflowing text to show scroll behavior</h4>
                    <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                    <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                    <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                    <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                    <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                    <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>

                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </div>
        </div>
      </div>
      <!-- Typeahead -->
      <div class="col-sm-4 col-lg-4">
        <h2>Typeahead</h2>
        <input type="text" class="form-control" data-provide="typeahead">
      </div>      
    </div>
    <h1>Typography <small>A small text</small></h1>
    <hr>
      <!-- Headings & Paragraph Copy -->
      <div class="row">
        <div class="col-sm-6 col-lg-3" data-effect="slide-left">
            <h1>h1. Heading 1</h1>
            <h2>h2. Heading 2</h2>
            <h3>h3. Heading 3</h3>
            <h4>h4. Heading 4</h4>
            <h5>h5. Heading 5</h5>
            <h6>h6. Heading 6</h6>
        </div>
        <div class="col-sm-6 col-lg-5" data-effect="slide-bottom">
          <h3>Paragraph</h3>
          <p>Lorem ipsum dolor sit amet, <mark>a mark here</mark> adipisicing elit. Atque, iusto, minus sequi natus nesciunt rerum tenetur corrupti autem officiis fugiat expedita laudantium ea aspernatur</p>
          <p><b>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam, velit, facere eos molestias rerum nesciunt consequatur voluptate minus quod</b></p>
          <p><i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio, vitae, dolore, ratione, neque deleniti officia atque dignissimos porro.</i></p>
          <p><strong class="text-success">Consectetur adipisicing elit</strong>. Corrupti, aliquam, voluptates, nulla, blanditiis totam voluptatem <strong class="text-danger">voluptatum quod ipsa debitis non</strong> ab odio natus.</p>
        </div>
        <div class="col-sm-12 col-lg-4" data-effect="slide-right">
          <h3>Lead text</h3>
          <p class="lead">Quisquam, dolorum, iusto iste voluptates rerum ea quas expedita. </p>
          <h3>Small text</h3>
          <p><small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et ullam libero repellendus voluptatibus obcaecati magni id nulla dolores nesciunt. Quasi quisquam facilis nobis ullam rem deleniti vero consectetur earum.</small></p>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-6 col-lg-6" data-effect="slide-left">
          <blockquote>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
          </blockquote>
        </div>
        <div class="col-sm-6 col-lg-6">
          <blockquote class="pull-right" data-effect="slide-right">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
          </blockquote>
        </div>
      </div>
    
      <!-- Panels -->

      <h2>Panels</h2>
      <div class="row">
        <div class="col-sm-6 col-lg-3">
          <div class="panel panel-primary" id="panels" data-effect="helix">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">
              <p>This is a panel paragraph</p>
              <p>This is a panel paragraph</p>
            </div>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="panel panel-info" data-effect="helix">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">
              <p>This is a panel paragraph</p>
              <p>This is a panel paragraph</p>
            </div>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="panel panel-danger" data-effect="helix">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">
              <p>This is a panel paragraph</p>
              <p>This is a panel paragraph</p>
            </div>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="panel panel-warning" data-effect="helix">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">
              <p>This is a panel paragraph</p>
              <p>This is a panel paragraph</p>
            </div>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
      </div>  

      <!-- List Groups -->
    
      <h2>List Groups</h2>
      <div class="row">
        <div class="col-sm-6 col-lg-4">
            <ul class="list-group">
              <li class="list-group-item">Cras justo odio</li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Morbi leo risus</li>
              <li class="list-group-item">Porta ac consectetur ac</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="list-group">
              <a href="#" class="list-group-item active"> <span class="badge">100</span> Cras justo odio</a>
              <a href="#" class="list-group-item"><span class="badge">21</span>Dapibus ac facilisis in</a>
              <a href="#" class="list-group-item"><span class="badge">22</span>Morbi leo risus</a>
              <a href="#" class="list-group-item"><span class="badge">51</span>Porta ac consectetur ac</a>
              <a href="#" class="list-group-item"><span class="badge">99</span>Vestibulum at eros</a>
            </div>
        </div>
        <div class="clearfix visible-md visible-sm"></div>
        <div class="col-sm-12 col-lg-4">
            <div class="list-group">
              <a href="#" class="list-group-item active">
                <h4 class="list-group-item-heading">List group item heading</h4>
                <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
              </a>
              <a href="#" class="list-group-item">
                <h4 class="list-group-item-heading">List group item heading</h4>
                <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
              </a>
              <a href="#" class="list-group-item">
                <h4 class="list-group-item-heading">List group item heading</h4>
                <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
              </a>
            </div>
        </div>
      </div>

    
  </div> <!-- /container -->

  <footer class="text-center">
    <p>&copy; Techie Skin</p>
    <div class="credits">
        <!-- 
            All the links in the footer should remain intact. 
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=Techie
        -->
        <a href="https://bootstrapmade.com/">Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer>

  <!-- Main Scripts-->
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  
    <!-- Bootstrap 3 has typeahead optionally -->
    <script src="assets/js/typeahead.min.js"></script>
    

</body>
</html>