<?php
header('Content-Type: text/html; charset=UTF-8');

$master_link	= mysqli_connect( 'localhost', 'hiroshi', 'hiroshi', 'auth', 3306 );
$slave_link		= mysqli_connect( 'localhost', 'hiroshi', 'hiroshi', 'auth', 3306 );

{
	if ($master_link->connect_error)
	{
	    $sql_error = $master_link->connect_error;
	    error_log($sql_error);
	    die($sql_error);
	}

	if ($slave_link->connect_error)
	{
	    $sql_error = $slave_link->connect_error;
	    error_log($sql_error);
	    die($sql_error);
	}
}

$master_link->set_charset( 'UTF-8' );
$slave_link->set_charset( 'UTF-8' );

{
	$insert_result = $master_link->query('INSERT INTO user_info(name,coin,update_time) values( "saitou", 200, now() )');
	if ( !$insert_result )
	{
		$sql_error = $maste_link->error;
		var_dump($sql_error);
		error_log( $sql_error );
		die( $sql_error );
	}
}

$select_result = $slave_link->query( 'select id, name, coin from user_info;' );
if (!$select_result)
{
    $sql_error = $slave_link->error;
	$sql_error = $maste_link->error;
    error_log( $sql_error );
    die( $sql_error );
}
else
{
	$line="";

    while($obj = $select_result->fetch_object())
    { 
		$line.=$obj->id; 
		$line.=" ";
		$line.=$obj->name; 
		$line.=" ";
		$line.=$obj->coin; 
		$line.="<br />";

		$update_result = $master_link->query( 'UPDATE user_info SET coin = coin * 1.1 WHERE id = '. $obj->id . ' and coin < 2147483647' );
		if ( !$update_result )
		{
			$sql_error = $maste_link->error;
			error_log( $sql_error );
			die( $sql_error );
		}
    } 

	printf( "%s<br />", $line );

    unset($obj);
}

mysqli_close( $master_link );
mysqli_close( $slave_link );
