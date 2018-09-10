<?
include 'Api.php';
    class form_four{
            public $_select_essences;
            public $_id_essences;
            public $_text_value;
            public $_date_value;
            public $_type_tack;
            public $_id_responsible;

            public function handler(){
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $this->_select_essences = $_POST['essence'];
                    $this->_id_essences = $_POST['idValue'];
                    $this->_text_value = $_POST['task'];
                    $this->_date_value = $_POST['date'];
                    $this->_type_tack = $_POST['typeTask'];
                    $this->_id_responsible = $_POST['idResponsible'];
                }
                $api = new api();
                switch($this->_select_essences){
                    case 1:
                    echo 'Контакты';
                    $api->tack($this->_id_essences,  $this->_select_essences, $this->_date_value, $this->_type_tack, $this->_text_value, $this->_id_responsible);

                    break;
                    case 3:
                    echo 'Компании';
                    $api->tack($this->_id_essences,  $this->_select_essences, $this->_date_value, $this->_type_tack, $this->_text_value, $this->_id_responsible);
                    break;
                    case 12:
                    echo 'Покупатели';
                    $api->tack($this->_id_essences,  $this->_select_essences, $this->_date_value, $this->_type_tack, $this->_text_value, $this->_id_responsible);
                    break;
                    case 2:
                    echo 'Сделки';
                    $api->tack($this->_id_essences,  $this->_select_essences, $this->_date_value, $this->_type_tack, $this->_text_value, $this->_id_responsible);
                    break;
                    default:
                    echo "Не выбрана сущность";
                }
            }
    }
    $form = new form_four();
    $form->handler();