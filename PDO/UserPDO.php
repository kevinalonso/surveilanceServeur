<?php
Class PDOUser
{
    function connectUser($login, $password){
        $ok = false;
        
        //$login = $obj['Login'];
        //$pass = $obj['Password'];
        
        try{
            $con = new PDO('mysql:host=localhost;dbname=surveillance', 'root', '');
                
            $stmt = $con->prepare('SELECT login, password
                FROM user
                WHERE Login ="'.$login.'"
                AND Password="'.$pass.'"');
                
            $stmt->execute();
            $res = $stmt->fetchAll();//(PDO::FETCH_BOTH);
                
            if($stmt->rowCount() > 0)
            {
                $ok = true;
            }

        } catch (PDOException $e)
        {
            print "Error !: " . $e->getMessage() . "<br/>";
            die();
        }
        return $ok;
    }
}