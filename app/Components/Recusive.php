<?php
namespace App\Components;

/**
 * 
 */
class Recusive
{
    private $data;
    private $htmlSelect='';
    public function __construct($data){
        $this->data = $data;
    }
    
    function categoryRecusive($parentId, $id=0, $text=''){
        foreach ($this->data as $value) {
            if($value['category_parent'] == $id){
                if(!empty($parentId) && $parentId==$value['category_id']){
                	$this->htmlSelect .= "<option value=".$value['category_id']." selected=''>" .$text.$value['category_name'] ." </option>";
                }else{
                	$this->htmlSelect .= "<option value=".$value['category_id'].">" .$text.$value['category_name'] ." </option>";
                }
                
                $this->categoryRecusive($parentId, $value['category_id'], $text.'--');
            }
        }
        return $this->htmlSelect;
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

?>