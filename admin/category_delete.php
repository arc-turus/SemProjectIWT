<?php require_once('header.php'); ?>
<?php
if(!isset($_REQUEST['id']))
{
	header('location: index.php');
	exit;
}
else
{
	if(!is_numeric($_REQUEST['id']))
	{
		header('location: index.php');
		exit;
	}
	else
	{
		$q = $pdo->prepare("SELECT * FROM category WHERE category_id=?");
		$q->execute([$_REQUEST['id']]);
		$total = $q->rowCount();
		if(!$total)
		{
			header('location: index.php');
			exit;
		}
	}
}

$q = $pdo->prepare("DELETE FROM category WHERE category_id=?");
$q->execute([$_REQUEST['id']]);

$q = $pdo->prepare("
			SELECT * 
			FROM post_category 
			WHERE category_id=?
		");
$q->execute([ 
			$_REQUEST['id'] 
		]);
$res = $q->fetchAll();
foreach ($res as $row)
{
	$post_id = $row['post_id'];
	
	$r = $pdo->prepare("SELECT * FROM post WHERE post_id=?");
	$r->execute([$post_id]);
	$res1 = $r->fetchAll();
	foreach ($res1 as $row1) {
		unlink('../uploads/'.$row1['post_photo']);
	}

	$r = $pdo->prepare("DELETE FROM post WHERE post_id=?");
	$r->execute([$post_id]);	
}

$q = $pdo->prepare("DELETE FROM post_category WHERE category_id=?");
$q->execute([$_REQUEST['id']]);


header('location: category_view.php');