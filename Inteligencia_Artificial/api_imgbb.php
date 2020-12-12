<?php
class Api_imgbb{
    private $json;

    private $imagen;
    private $nombre;

    public function construct(){
        $this->nombre = null;
    }

    public function isImg($imagen){
        if(isset($imagen) and (strpos($imagen['type'], "png") or strpos($imagen['type'], "jpg") or strpos($imagen['type'], "jpeg"))){
            $this->imagen = $imagen;
            return true;
        }else{
            return false;
        }
    }

    public function upload(){
        if(isset($this->imagen)){
            $key = "06d1b0390a59a13d31f2431a45da80bf";

            if($this->nombre == null){
                $arrayName = explode(".", $this->imagen['name']);
                $nombre = $arrayName[0];
            }else{
                $nombre = $this->nombre;
            }

            $bin = file_get_contents($this->imagen["tmp_name"]);
            $base64 = base64_encode($bin);

            $post = "key=".$key."&name=".$nombre."&image=".urlencode($base64);

            $ch =   curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.imgbb.com/1/upload");
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resultado = curl_exec($ch);

            $this->json = json_decode($resultado, true);
        }
    }

    public function setName($nombre){
        $this->nombre = $nombre;
    }

    public function getJson(){
        return $this->json;
    }

    public function getUrl(){
        return $this->json['data']['url'];
    }
}