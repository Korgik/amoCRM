<?
include 'Api.php';
    class form_three{
            public $_select_essences;
            public $_id_essences;
            public $_text_value;
            public $_radio_value;

            public function handler(){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $this->_select_essences = $_POST['essence'];
                    $this->_id_essences = $_POST['idValue'];
                    $this->_text_value = $_POST['notice'];
                    $this->_radio_value = $_POST['radio_essence'];
                }
                $api = new api();
                switch($this->_select_essences){
                    case 1:
                    echo 'Контакты';
                    $api->notes($this->_id_essences, $this->_select_essences, $this->_radio_value, $this->_text_value);

                    break;
                    case 3:
                    echo 'Компании';
                    $api->notes($this->_id_essences, $this->_select_essences, $this->_radio_value, $this->_text_value);

                    break;
                    case 12:
                    echo 'Покупатели';
                    $api->notes($this->_id_essences, $this->_select_essences, $this->_radio_value, $this->_text_value);

                    break;
                    case 2:
                    echo 'Сделки';
                    $api->notes($this->_id_essences, $this->_select_essences, $this->_radio_value, $this->_text_value);

                    break;
                    default:
                    echo "Не выбрана сущность";
                }
            }
    }
    $form = new form_three();
    $form->handler();