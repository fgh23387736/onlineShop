<?PHP 
function https($num) { 
	$http = array ( 
	200 => "HTTP/1.1 200 OK", 
	201 => "HTTP/1.1 201 CREATED", 
	202 => "HTTP/1.1 202 Accepted", 
	204 => "HTTP/1.1 204 NO CONTENT", 
	400 => "HTTP/1.1 400 INVALID REQUEST", 
	401 => "HTTP/1.1 401 Unauthorized", 
	403 => "HTTP/1.1 403 Forbidden", 
	404 => "HTTP/1.1 404 NOT FOUND", 
	406 => "HTTP/1.1 406 Not Acceptable", 
	410 => "HTTP/1.1 410 Gone", 
	422 => "HTTP/1.1 422 Unprocesable entity", 
	500 => "HTTP/1.1 500 INTERNAL SERVER ERROR"
	); 
	header($http[$num]); 
} 
?>