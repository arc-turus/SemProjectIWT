<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;
    $hash = md5(time());
    $cust_name = strip_tags($_POST['cust_name']);
    $cust_phone = strip_tags($_POST['cust_phone']);
    $cust_email = strip_tags($_POST['cust_email']);
    $cust_password = strip_tags($_POST['cust_password']);

    if ($cust_name == '') {
        $valid = 0;
        $error_message = 'Name can not be empty<br>';
    }
    if ($cust_phone == '') {
        $valid = 0;
        $error_message = 'Phone Address can not be empty<br>';
    }
    if ($cust_email == '') {
        $valid = 0;
        $error_message = 'Email Address can not be empty<br>';
    } else {
        if (!filter_var($cust_email, FILTER_VALIDATE_EMAIL)) {
            $valid = 0;
            $error_message = 'Email Address is invalid<br>';
        }
    }

    if ($cust_password == '') {
        $valid = 0;
        $error_message = 'Password can not be empty<br>';
    }
    $q = $pdo->prepare("SELECT count(cust_email) FROM customer WHERE cust_email = ?");
    $q->execute([$cust_email]);
    $res = $q->fetchAll();
    foreach ($res as $row) {
        if ($row['count(cust_email)'] > 0) {
            $valid = 0;
            $error_message = 'Email is already in use!' . '<br>';
            break;
        }
    }


    if ($valid == 1) {
        $q = $pdo->prepare("INSERT INTO customer (
                    cust_name,
                    cust_phone,
                    cust_email,
                    cust_password,
                    cust_hash,
                    cust_active
                ) 
                VALUES (?,?,?,?,?,?)");
        $q->execute([
            $cust_name,
            $cust_phone,
            $cust_email,
            md5($cust_password),
            $hash, 0
        ]);

        $success_message = 'User is added successfully!';
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Add User</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <?php
                        // $error_message = '';
                        if ($error_message) {
                            echo '<div class="alert alert-danger">' . $error_message . '</div>';
                        } else if ($success_message) {
                            echo '<div class="alert alert-success">' . $success_message . '</div>';
                        }
                        $error_message = '';
                        $success_message = '';
                        ?>

                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label"> Name *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cust_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Phone Number *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cust_phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Email *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cust_email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Password *</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cust_password">
                                </div>
                            </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" name="form1">Submit</button>
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

<?php require_once('footer.php'); ?>