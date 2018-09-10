<?
include 'Api.php';


class form_one{
    public $_id_company_result = [];
    public $_id_contact_result = [];
    public $_id_costumers_result = [];
    public $_id_leads_result = [];
    public $_all_id_companies = [];
    public $_all_id_contacts = [];
    public $_all_id_leads = [];
    public $_all_id_costumers = [];
    public $_get_company_id = [];
    public $_multy_value = [];
    public $_contact_value = [];
    // для получение результата
    public $_result = [];

    public function form_one(){

    }
    public function cycle_company(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lead = $_POST['counter'];
        }
        $api = new api();
        $arr = '';

        for ($i = 0; $i < $lead; $i++) {
            $arr[$i][name] = 'Компания ' . rand(0, 10000);
        }

        foreach (array_chunk($arr, 250) as $send) {

            $this->_id_company_result[] = $api->createCompany($send);

        }

    }

    public function cycle_contact(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lead = $_POST['counter'];
        }

        $this->_all_id_companies = [];
        foreach ($this->_id_company_result as $value) {
            $this->_all_id_companies = array_merge($this->_all_id_companies, $value);
        }
        $api = new api();
        $arr = '';

            for ($count = 0; $count < $lead; $count++) {
                $arr[$count][name] = 'Контакты ' . rand(0, 10000);
                $arr[$count][company_id] = $this->_all_id_companies[$count];
            }
        foreach (array_chunk($arr, 250) as $send) {

            $this->_id_contact_result[] = $api->createContact($send);
        }

    }

    public function cycle_customers(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lead = $_POST['counter'];
        }

        $this->_all_id_contacts = [];
        foreach ($this->_id_contact_result as $value) {
            $this->_all_id_contacts = array_merge($this->_all_id_contacts, $value);
        }
        $api = new api();
        $arr = '';

        for ($i = 0; $i < $lead; $i++) {
            $arr[$i][name] = 'Покупатель ' . rand(0, 10000);
            $arr[$i][next_date] = mt_rand(1535382000, 1538060400);
            $arr[$i][company_id] = $this->_all_id_companies[$i];
            $arr[$i][contacts_id][$i] = $this->_all_id_contacts[$i];
        }

        foreach (array_chunk($arr, 250) as $send) {

            $this->_id_costumers_result[] = $api->createCustomers($send);
        }


    }

    public function cycle_leads(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lead = $_POST['counter'];
        }
        $api = new api();
        $arr = '';

        for ($i = 0; $i < $lead; $i++) {
            $arr[$i][name] = 'Сделка ' . rand(0, 10000);
            $arr[$i][contacts_id][$i] = $this->_all_id_contacts[$i];
            $arr[$i][company_id] = $this->_all_id_companies[$i];
        }


        foreach (array_chunk($arr, 250) as $send) {
            $this->_id_leads_result[] = $api->createLeads($send);
        }

        $api->my_print($this->_id_leads_result);
    }

    public function multitext(){
        set_time_limit(3600);
        $api = new Api();
        $check_filed == true;
        $list_fields = $api->getCustomField();
        foreach ($list_fields["_embedded"]["custom_fields"]["contacts"] as $key => $value) {
            echo $value["name"];

            if ($value["name"] === "Ранг сотрудника") {
                echo "Условие1";
                $check_filed = true;
                break;
            } else {
                echo "Условие2";
                $check_filed = false;
            }
        }

        if ($check_filed == false) {
            $result_created = $api->getCreateMultiarea();
            $multy_field = $api->getCustomField();
            foreach ($multy_field["_embedded"]["custom_fields"]["contacts"] as $key => $value) {
                if ($value["name"] === "Ранг сотрудника") {
                    print_r($value);
                    $multy_field_id = $value["id"];
                    $mylty_field_enums = $value["enums"];
                }
            }
        } elseif ($check_filed == true) {
            $multy_field = $api->getCustomField();
            foreach ($multy_field["_embedded"]["custom_fields"]["contacts"] as $key => $value) {
                if ($value["name"] === "Ранг сотрудника") {
                    $multy_field_id = $value["id"];
                    $mylty_field_enums = $value["enums"];
                }
            }
            print_r("<hr>");
        } else {

        }
        $i = 0;
        $this->_id_contact_result = [];
        $id_list = [];
        while (true) {
            $this->_id_contact_result[$i] = $api->getContactList($i);
            if (count($this->_id_contact_result[$i]) > 0) {
                for ($j = 0; $j < 500; $j++) {
                    $id_list[] = $this->_id_contact_result[$i]["_embedded"]["items"][$j]["id"];
                }
                $i++;
            } else {
                break;
            }
        }
        $set = count($id_list);
        foreach ($mylty_field_enums as $key => $value) {
            $values[] = $key;
        }
    // массив на создание
        $date = date_create();
        for ($k = 0; $k <= $set; $k++) {
            $arr[$k]["id"] = $id_list[$k];
            $arr[$k]["updated_at"] = date_timestamp_get($date);
            $arr[$k]["custom_fields"][0]["id"] = $multy_field_id;
            for ($count = 0; $count <= rand(0, 10); $count++) {
                $number = mt_rand(0, count($values) - 1);
                $arr[$k]["custom_fields"][0]["values"][rand(0, 9)] = $values[$number];
            }


        }

        foreach (array_chunk($arr, 500) as  $send) {
            $request = $api->updateForMultiselect($send);
        }
    }
    public function init(){
        set_time_limit(3600);

        $form = new form_one();
        $form->cycle_company();
        $form->cycle_contact();
        $form->cycle_customers();
        $form->cycle_leads();
    }
}
$form = new form_one();
$form->init();
$multy = new form_one();
$multy->multitext();