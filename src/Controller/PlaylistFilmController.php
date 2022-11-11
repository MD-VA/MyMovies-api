<?php

namespace src\Controller;

class PlaylistFilmController{
  
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createPlaylist($name, $public, $idUser){
        try{
            if($public = "public"){
                $public = 1;
            }else{
                $public = 0;
            }
            $stmt = $this->db->prepare("CALL createPlaylist(?)");
            $stmt->bindParam($name, $public, $idUser);
            $rs = $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            header("HTTP/1.1 500 Playlist Created");
            exit();
        }catch(\Exception $e){
            print($e->getMessage());
        }
    }

    public function addFilmToPlaylist($idPlaylist, $idFilm){
        try{
            $stmt = $this->db->prepare("CALL createFilmPlaylist(?)");
            $stmt->bindParam($idPlaylist, $idFilm);
            $rs = $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            header("HTTP/1.1 500 Film added to playlist");
            exit();
        }catch(\Exception $e){
            print($e->getMessage());
        }
    }

}

?>