<?php
header('Content-Type: text/html; charset=UTF-8');

$master_link = null;
$slave_link  = null;

try{
	$master_link	= mysqli_connect( 'localhost', 'hiroshi', 'hiroshi', 'auth', 3306 );
	$slave_link		= mysqli_connect( 'localhost', 'hiroshi', 'hiroshi', 'auth', 3306 );

	$master_link->set_charset( 'UTF-8' );
	$slave_link->set_charset( 'UTF-8' );

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
catch(Excption $ex)
{
	error_log( $ex->getMessage() );
	return FALSE;
}

try
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
catch( Exception $ex )
{
	error_log( $ex->getMessage() );
	return FALSE;
}

$select_result = $slave_link->query( 'select id, name, coin from user_info;' );
if (!$select_result)
{
    $sql_error = $slave_link->error;
    error_log( $sql_error );
    die( $sql_error );
}
else
{
	//˜A‘z”z—ñ‚ÅŽæ“¾
	while($row = $select_result->fetch_array(MYSQLI_ASSOC)){
		$rows[] = $row;
	}

	foreach( $rows as $row )
	{
		printf( "%s,%s<br />", $row['id'], $row['name'] );
	}

    unset($row);
}

mysqli_close( $master_link );
mysqli_close( $slave_link );
