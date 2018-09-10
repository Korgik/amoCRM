<?
include 'Api.php';

class form_five{
    public $_tack_list_text = [];
    public $_tack_list_id = [];

    public function handler(){
        $api = new api();
        $api->tack_list();
        foreach ($api->_task as $key => $value){
            $this->_task_list_text[] = $value["text"];
            $this->_task_list_id[] = $value["id"];
            if ($value["id"] == $_POST["task"]){
                $api->finish_task($value["id"]);
            }
        }

    }
}
$form = new form_five();
$form->handler();
