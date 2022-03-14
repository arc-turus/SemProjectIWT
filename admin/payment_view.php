<?php require_once('header.php'); ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Payment</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                
                <?php
                if(isset($_SESSION['d_msg']))
                {
                    echo '<div class="alert alert-success">'.$_SESSION['d_msg'].'</div>';
                    unset($_SESSION['d_msg']);
                }
                ?>
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Paid Ammount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $q = $pdo->prepare("SELECT * FROM payment ORDER BY p_id ASC");
                        $q->execute();
                        $res = $q->fetchAll();
                        foreach ($res as $row) 
                        {
                            $i++;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td><?php echo $row['cust_name']; ?></td>
                                <td><?php echo $row['cust_email']; ?></td>
                                <td><?php echo $row['payment_date']; ?></td>
                                <td><?php echo $row['payment_method']; ?></td>
                                <td><?php echo $row['paid_amount']; ?></td>
                                <td>
                                
                                    <a href="payment_delete.php?id=<?php echo $row['cust_id']; ?>" class="btn btn-xs btn-danger" onClick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?php require_once('footer.php'); ?>