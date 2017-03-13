<?php
switch($grid_style){
	case '0':
		include('html-loop/00-grid/0.php');					
		break;
	case '1':	
		include('html-loop/00-grid/1.php');				
		break;
	case '2':	
		include('html-loop/00-grid/2.php');				
		break;
	case '3':	
		include('html-loop/00-grid/3.php');				
		break;
	case '4':	
		include('html-loop/00-grid/4.php');				
		break;
	case '5':
		include('html-loop/00-grid/5.php');					
		break;
	case '6':	
		include('html-loop/00-grid/6.php');				
		break;	
	default:
		include('html-loop/00-grid/0.php');						
}