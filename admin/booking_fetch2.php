<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "hotel");
$columns = array('room_id','qty','checkout_date');

$query = "SELECT * FROM payment_detail WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'checkout_date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (room_id LIKE "%'.$_POST["search"]["value"].'%"  
   )
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY room_id ASC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();
$total_order = 0;

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["room_id"];
 $sub_array[] = $row["qty"];
 $sub_array[] = $row["checkout_date"];
 $total_order = $total_order + floatval($row["qty"]);
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM payment_detail";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  get_all_data($connect),
    "recordsFiltered" => $number_filter_row,
    "data"    => $data,
    'total' => number_format($total_order,2)
   );

echo json_encode($output);

?>