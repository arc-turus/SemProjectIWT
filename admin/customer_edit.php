<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {

    $q = $pdo->prepare("UPDATE customer SET 
                cust_name=?,
                cust_phone=?,
                cust_email=?
                WHERE cust_id=?
            ");
    $q->execute([ 
                $_POST['cust_name'],
                $_POST['cust_phone'],
                $_POST['cust_email'],
                $_REQUEST['id']
            ]);

    $success_message = 'Customer Information is updated successfully!';
}
?>

<?php
$q = $pdo->prepare("SELECT * FROM customer WHERE cust_id=?");
$q->execute([$_REQUEST['id']]);
$res = $q->fetchAll();
foreach ($res as $row) {
    $cust_name = $row['cust_name'];
    $cust_phone = $row['cust_phone'];
    $cust_email = $row['cust_email'];
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit Customer_info</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                
                <?php
                if($error_message)
                {
                    echo '<div class="alert alert-danger">'.$error_message.'</div>';
                }
                if($success_message)
                {
                    echo '<div class="alert alert-success">'.$success_message.'</div>';
                }
                ?>

                <form class="form-horizontal" action="" method="post">
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Customer Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="cust_name" value="<?php echo $cust_name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Customer Phone</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="cust_phone" value="<?php echo $cust_phone; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Customer Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="cust_email" value="<?php echo $cust_email; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" name="form1">Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>