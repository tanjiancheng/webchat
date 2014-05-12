<?php
require('init.php');

/**
 * @Content:执行调用方法
 * @Param:array
		$class(UI[类名].Func[方法名])
		$arr_param(传入的参数)
 * @Return:
			-1://没有这个文件(没有这个类文件)
			-2://没有这个类
			-3://没有这个方法
			
 */
class CallBack {

	public function callBackFunc( $class, $arr_param= array() ) {

		if(!isset($class)) {
			return;
		}
		
		list( $s_ClassName , $s_FuncName ) = explode( ".", $class );
		$s_IncludeUI = ACTION."/".$s_ClassName.".php";

		if( !file_exists( $s_IncludeUI ) ) {	//没有这个文件(没有这个类文件)
			@header("location:index.php?func=ErrorAction.ErrorPage");
		}
		include( $s_IncludeUI );
		if( !class_exists( $s_ClassName ) ) {//没有这个类
			@header("location:index.php?func=ErrorAction.ErrorPage");
		}
		$obj_Class = new $s_ClassName();
		if( !method_exists($obj_Class,$s_FuncName) ) {//没有这个方法
			@header("location:index.php?func=ErrorAction.ErrorPage");
		}
		
		return $obj_Class -> $s_FuncName( $arr_param);
	}
}

$arr_Param = array();
$s_Func = @$_GET['func'];
$arr_GET = $_GET;
$arr_POST = $_POST;
foreach( $arr_GET as $key => $values ) {
	$arr_Param[ $key ] = $values;
}
foreach( $arr_POST as $key => $values ) {
	$arr_Param[ $key ] = $values;
}
unset( $arr_Param['func'] );
unset( $_GET );
unset( $_POST );
unset( $arr_GET );
unset( $arr_POST );


$calls = new CallBack();
$calls -> callBackFunc( $s_Func, $arr_Param  );
