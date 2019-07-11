<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!-- no additional media querie or css is required -->
<div class="container">
        <div class="row justify-content-center align-items-center" style="height:100vh">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form action="checklogin.php" method="POST" autocomplete="off">
                            <div class="form-group">
                                <img src="images/pp.jpg" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="login">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="pass">
                            </div>
                            <button type="submit" id="sendlogin" class="btn btn-primary">Login</button>
				<a href="f_bands.php" class="btn btn-primary">Cadastrar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
