<?php
namespace App\Controllers;
class Response {
	public static function json($data=array(),$statuscode = 200,$message = 'Everything OK'){
		header("HTTP/ ".$statuscode." ".$message);
		header('Content-type: application/json; charset=utf-8');
		$response = array('status'=>$statuscode,'message' =>$message,'data'=>$data);
		echo json_encode($response);
	}
}