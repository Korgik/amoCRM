<?
include 'Api.php';

class form_two {
    public $_select_essences;
    public $_id_essences;
    public $_text_value;
    public $_id_field_text;
    public $_list_field;

    public function chek_type(){
        
        switch ($_POST['essence']){
            case 1:
            return 'contacts';
            break;

            case 3:
            return 'companies';
            break;

            case 12:
            return 'customers';
            break;
            case 2:
            return 'leads';
            break;
            default:
            echo "не выбрана сущность";
        }
    }

    public  function checked(){
        $api = new api();
        $type = $this->chek_type();
        $chek_create = $api->getCustomField();
        print_r("<hr>");
        foreach($chek_create['_embedded']['custom_fields'][$type] as $key => $value){
            if($value['field_type'] == 1 && $value['name'] == 'Поле'){
                $this->_id_field_text = $value['id'];
                return TRUE;
            }
            else{
        }
        }
    }

    public function handler(){
        $api = new api();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->_select_essences = $_POST['essence'];
            $this->_id_essences = $_POST['idValue'];
            $this->_text_value = $_POST['field_value'];
        }

        switch ($this->_select_essences) {
            case 1:
            // Выбраны контакты
            if($this->checked() == TRUE){
                print_r("Условие 1");
                $api->updateContact($this->_id_essences, $this->_id_field_text, $this->_text_value);
            }
            else{
                print_r("Условие 2");
                $id_result_field = $api->getCreateTextField($this->_select_essences);
                $api->updateContact($this->_id_essences, $id_result_field, $this->_text_value);
            }
                break;
            case 3:
                // echo 'Выбрана компания';
                if($this->checked() == TRUE){
                    print_r("Условие 1");
                    $api->updateCompany($this->_id_essences, $this->_id_field_text, $this->_text_value);
                }
                else{
                    print_r("Условие 2");
                    $id_result_field = $api->getCreateTextField($this->_select_essences);
                    $api->updateCompany($this->_id_essences, $id_result_field, $this->_text_value);
                }

                break;
            case 12:
                // echo 'Выбран покупатель';
                if($this->checked() == TRUE){
                    print_r("Условие 1");
                    $api->updateCostumers($this->_id_essences, $this->_id_field_text, $this->_text_value);
                }
                else{
                    print_r("Условие 2");
                    $id_result_field = $api->getCreateTextField($this->_select_essences);
                    $api->updateCostumers($this->_id_essences, $id_result_field, $this->_text_value);
                }
                break;
            case 2:
                // echo 'Выбрана сделка';
                if($this->checked() == TRUE){
                    print_r("Условие 1");
                    $api->updateLeads($this->_id_essences, $this->_id_field_text, $this->_text_value);
                }
                else{
                    print_r("Условие 2");
                    $id_result_field = $api->getCreateTextField($this->_select_essences);
                    $api->updateLeads($this->_id_essences, $id_result_field, $this->_text_value);
                }

                break;
            default:
                echo 'Не выбрана сущность';
        }
    }

}

$form = new form_two();
$form->chek_type();
$form->checked();
$form->handler();

