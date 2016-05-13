<?php
Class File{

	public function getFile($idUser)
	{
		$db = new PDO("dbtype:host=localhost;dbname=surveillance;charset=utf8","root","")
		$db->query("SELECT id, path FROM file WHERE user_id=".$idUser);
		$db->execute();

		$result = array();
		if($db->fetch() != null)
		{
			for($i=0; $row = $db->fetch(); $i++)
			{
	        	 $result = $row['path']." - ".$row['id'];
	      	}
		}

		return $result;
	}

	public function updateFile($id,$size)
	{
		$db = new PDO("dbtype:host=localhost;dbname=surveillance;charset=utf8","root","")
		$db->query("UPDATE file SET size = '".$size."' WHERE id=".$id);
		$db->execute();
	}

	public function createFolder($login)
	{
		if (!file_exists('surveillance/ftp/'.$login)) 
		{
			mkdir('surveillance/ftp/'.$login, 0777, true);
		}
	}
}

?>