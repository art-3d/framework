<div class="container">

    <?php if (!isset($errors)) {
        $errors = [];
    } ?>

    <form class="form-register" role="form" method="post" action="<?php echo $getRoute('registration')?>">
        <h2 class="form-register-heading">Please register</h2>
        <?php foreach ($errors as $error) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php } ?>
        <input type="email" class="form-control" placeholder="Email address" required autofocus name="email">
        <input type="password" class="form-control" placeholder="Password" required name="password">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
        <?php $generateToken()?>
    </form>

</div>
