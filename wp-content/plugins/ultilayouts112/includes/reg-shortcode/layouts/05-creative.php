<?php
switch($creative_style){
	case '0':
		include('html-loop/05-creative/0.php');					
		break;
	case '1':	
		include('html-loop/05-creative/1.php');				
		break;
	case '2':	
		include('html-loop/05-creative/2.php');				
		break;
	/*case '3':	
		include('html-loop/05-creative/3.php');				
		break;
	case '4':	
		include('html-loop/05-creative/4.php');				
		break;*/
	default:
		include('html-loop/05-creative/0.php');						
}