<?php
	function register($nama_user, $password)
	{
		$kon = mysqli_connect("localhost","root","","testmed");
		$sql = "INSERT INTO users(nama_user, password) VALUES('$nama_user', '$password')";
		$s = mysqli_query($kon, $sql);
	}
	
	function login($nama_user, $password)
	{
		$kon = mysqli_connect("localhost","root","","testmed");
		$sql = "SELECT id_user, nama_user,password FROM users WHERE nama_user = '$nama_user'";
		$s = mysqli_query($kon, $sql);
		
		$data = mysqli_fetch_row($s);
		$password = $data[2];
		$id = $data[0];
		$password = md5($password);
		
		if ($password == $password)
		{
			return $id;
		}else
		{return "false";}
	}
	
	function feeds()
	{
		$kon = mysqli_connect("localhost","root","","testmed");

		$sql = "SELECT u.nama, f.media, f.caption FROM user u, feeds f WHERE u.id = f.id_user ORDER BY f.id_feed DESC";
		$d = mysqli_query($kon, $sql);
		while ($data = mysqli_fetch_row($d))
		{
			echo("<table width='70%' border='0'>
			<tr>
			  <td>$data[0]</td>
			</tr>
			<tr>
			  <td><img src='$data[1]' width='300px'></td>
			</tr>
			<tr>
			  <td>$data[2]</td>
			</tr>
		  </table>");
		}

	}

	function savePost($id, $media, $keterangan)
	{
		$kon = mysqli_connect("localhost","root","","testmed");
		$sql = "INSERT INTO feeds(id_user, media, caption) VALUES($id, '$media', '$keterangan')";
		$s = mysqli_query($kon, $sql);
	}
	
	
	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
/>

</head>



<body>
</body>
</html>

