<?

class Api
{
    public $_task = [];

    public function api(){
        #Массив с параметрами, которые нужно передать методом POST к API системы
        $user = array(
            'USER_LOGIN' => 'adyneco@team.amocrm.com',
            'USER_HASH' => 'd3e655dfd191638f28ee15721948b7335aeb37c8',
        );
        #Формируем ссылку для запроса
        $link = 'https://test2korgik.amocrm.ru/private/api/auth.php?type=json';
        /* Нам необходимо инициировать запрос к серверу. Воспользуемся библиотекой cURL (поставляется в составе PHP). Вы также
        можете
        использовать и кроссплатформенную программу cURL, если вы не программируете на PHP. */
        $curl = curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Завершаем сеанс cURL
        /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        );
        try {
            #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }

        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        /*
        Данные получаем в формате JSON, поэтому, для получения читаемых данных,
        нам придётся перевести ответ в формат, понятный PHP
         */
        $Response = json_decode($out, true);
        $Response = $Response['response'];
        if (isset($Response['auth'])) #Флаг авторизации доступен в свойстве "auth"
        {
            return 'Авторизация прошла успешно';
        }

        return 'Авторизация не удалась';
    }

    public function createCompany($send){
        // Ввод данных
        $data = array(
            'add' => $send,
        );

        $link = "https://test2korgik.amocrm.ru/api/v2/companies";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        // curl_close($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $Response = json_decode($out, true);
        $id = [];
        foreach ($Response["_embedded"]["items"] as $key => $id_value){
            $id[] = $id_value["id"];
        }
        sleep(1);
        // print_r($id);
        return $id;
    }

    public function createContact($send){
        // Ввод данных
        $data = array(
            'add' => $send,
        );

        $link = "https://test2korgik.amocrm.ru/api/v2/contacts";

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        );
        try {
            if ($code != 200 && $code != 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $Response = json_decode($out, true);

        $output = 'ID добавленных контактов:' . PHP_EOL;
        // foreach ($this->_id_contact_result as $v) {
        //     if (is_array($v)) {
        //         $output .= $v['id'] . PHP_EOL;
        //     }
        // }
        $id = [];
        foreach ($Response["_embedded"]["items"] as $key => $id_value){
            $id[] = $id_value["id"];
        }
        sleep(1);
        return $id;
    }
    public function createCustomers($send){
        // Ввод данных
        $data = array(
            'add' => $send,
        );


        $link = 'https://test2korgik.amocrm.ru/api/v2/customers';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        );
        try {

            if ($code != 200 && $code != 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }

        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }

        $Response = json_decode($out, true);
        $id = [];
        foreach ($Response["_embedded"]["items"] as $key => $id_value){
            $id[] = $id_value["id"];
        }
        sleep(1);
        return $id;
    }

    public function createLeads($send){
        // Ввод данных
        $data = array(
            'add' => $send,
        );

        $link = "https://test2korgik.amocrm.ru/api/v2/leads";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // curl_close($curl);
        $Response = json_decode($out, true);
         /* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $id = [];
        foreach ($Response["_embedded"]["items"] as $key => $id_value){
            $id[] = $id_value["id"];
        }
        sleep(1);
        return $id;
    }
    public function getCreateMultiarea(){
        $data = array(
            'add' => array(
                0 => array(
                    'name' => 'Ранг сотрудника',
                    'type' => '5',
                    'element_type' => '1',
                    'origin' => '1488',
                    'enums' => array(
                        0 => '1 ранг',
                        1 => '2 ранг',
                        2 => '3 ранг',
                        3 => '4 ранг',
                        4 => '5 ранг',
                        5 => '6 ранг',
                        6 => '7 ранг',
                        7 => '8 ранг',
                        8 => '9 ранг',
                        9 => '10 ранг',
                    ),
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/fields";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        // /* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        // $code=(int)$code;
        // $errors=array(
        // 301=>'Moved permanently',
        // 400=>'Bad request',
        // 401=>'Unauthorized',
        // 403=>'Forbidden',
        // 404=>'Not found',
        // 500=>'Internal server error',
        // 502=>'Bad gateway',
        // 503=>'Service unavailable'
        // );
        // try
        // {
        // #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        // if($code!=200 && $code!=204)
        //     throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        // }
        // catch(Exception $E)
        // {
        // die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        // }
        $result = json_decode($out, true);
        return $result["_embedded"]["items"][0];
        sleep(1);

    }
    public function getCustomField(){
        $link = 'https://test2korgik.amocrm.ru/api/v2/account?with=custom_fields';

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        curl_close($curl);
        // $code=(int)$code;
        // $errors=array(
        // 301=>'Moved permanently',
        // 400=>'Bad request',
        // 401=>'Unauthorized',
        // 403=>'Forbidden',
        // 404=>'Not found',
        // 500=>'Internal server error',
        // 502=>'Bad gateway',
        // 503=>'Service unavailable'
        // );
        // try
        // {
        // #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        // if($code!=200 && $code!=204) {
        //     throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        // }
        // }
        // catch(Exception $E)
        // {
        // die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        // }
        $result = json_decode($out, true);
        // $this->_result_fields = $result;
        // $this->_custom_field = $result["_embedded"]["custom_fields"];
        // $this->_data_account_custom_field_value = $result["_embedded"]["custom_fields"]["contacts"]["420203"]["enums"];
        sleep(1);
        return $result;
    }
    public function getContactList($i){
        $offset = $i * 500;
        $link = "https://test2korgik.amocrm.ru/api/v2/contacts/?limit_rows=500&limit_offset={$offset}";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        curl_close($curl);
        // $code=(int)$code;
        // $errors=array(
        // 301=>'Moved permanently',
        // 400=>'Bad request',
        // 401=>'Unauthorized',
        // 403=>'Forbidden',
        // 404=>'Not found',
        // 500=>'Internal server error',
        // 502=>'Bad gateway',
        // 503=>'Service unavailable'
        // );
        // try
        // {
        // #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        // if($code!=200 && $code!=204) {
        //     throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        // }
        // }
        // catch(Exception $E)
        // {
        // die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        // }
        $result = json_decode($out, true);
        // id контактов
        $this->_result_contact_list = $result;

        return $result;
        sleep(1);
    }

    public function getCreateTextField($_type_essences){
        $data = array(
            'add' => array(
                0 => array(
                    'name' => 'Поле',
                    'type' => '1',
                    'element_type' => $_type_essences,
                    'origin' => rand(0, 500),
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/fields";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        // $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        // /* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        // $code=(int)$code;
        // $errors=array(
        // 301=>'Moved permanently',
        // 400=>'Bad request',
        // 401=>'Unauthorized',
        // 403=>'Forbidden',
        // 404=>'Not found',
        // 500=>'Internal server error',
        // 502=>'Bad gateway',
        // 503=>'Service unavailable'
        // );
        // try
        // {
        // #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        // if($code!=200 && $code!=204)
        //     throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        // }
        // catch(Exception $E)
        // {
        // die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        // }
        $result = json_decode($out, true);
        $this->_result_create_field_id = $result["_embedded"]["items"][0]["id"];
        sleep(1);
        return $result["_embedded"]["items"][0]["id"];
    }
    public function updateForMultiselect($send){
        $data = array(
            'update' => $send,
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/contacts";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        curl_close($curl);
        // $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        // /* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        // $code=(int)$code;
        // $errors=array(
        // 301=>'Moved permanently',
        // 400=>'Bad request',
        // 401=>'Unauthorized',
        // 403=>'Forbidden',
        // 404=>'Not found',
        // 500=>'Internal server error',
        // 502=>'Bad gateway',
        // 503=>'Service unavailable'
        // );
        // try
        // {
        // #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        // if($code!=200 && $code!=204) {
        //     throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        // }
        // }
        // catch(Exception $E)
        // {
        // die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        // }
        $result = json_decode($out, true);
        sleep(1);
        return $result;
    }
    public function updateContact($id_essence, $id_field_text, $text_value){
        $date = date_create();
        $data = array(
            'update' => array(
                0 => array(
                    'id' => $id_essence,
                    'updated_at' => date_timestamp_get($date),
                    'custom_fields' => array(
                        0 => array(
                            'id' => $id_field_text,
                            'values' => array(
                                0 => array(
                                    'value' => $text_value,
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/contacts";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        curl_close($curl);
        // $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        // /* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
        // $code=(int)$code;
        // $errors=array(
        // 301=>'Moved permanently',
        // 400=>'Bad request',
        // 401=>'Unauthorized',
        // 403=>'Forbidden',
        // 404=>'Not found',
        // 500=>'Internal server error',
        // 502=>'Bad gateway',
        // 503=>'Service unavailable'
        // );
        // try
        // {
        // #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
        // if($code!=200 && $code!=204) {
        //     throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        // }
        // }
        // catch(Exception $E)
        // {
        // die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        // }
        $result = json_decode($out, true);
        sleep(1);
    }
    public function updateCompany($id_essence, $id_field_text, $text_value){
        $date = date_create();
        $data = array(
            'update' => array(
                0 => array(
                    'id' => $id_essence,
                    'updated_at' => date_timestamp_get($date),
                    'custom_fields' => array(
                        0 => array(
                            'id' => $id_field_text,
                            'values' => array(
                                0 => array(
                                    'value' => $text_value,
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/companies";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $result = json_decode($out, true);
        sleep(1);
    }
    public function updateCostumers($id_essence, $id_field_text, $text_value){
        $date = date_create();
        $data = array(
            'update' => array(
                0 => array(
                    'id' => $id_essence,
                    'updated_at' => date_timestamp_get($date),
                    'custom_fields' => array(
                        0 => array(
                            'id' => $id_field_text,
                            'values' => array(
                                0 => array(
                                    'value' => $text_value,
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/customers";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $result = json_decode($out, true);
        print_r($result);
        sleep(1);
    }
    public function updateLeads($id_essence, $id_field_text, $text_value){
        $date = date_create();
        $data = array(
            'update' => array(
                0 => array(
                    'id' => $id_essence,
                    'updated_at' => date_timestamp_get($date),
                    'custom_fields' => array(
                        0 => array(
                            'id' => $id_field_text,
                            'values' => array(
                                0 => array(
                                    'value' => $text_value,
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/leads/";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
            }
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $result = json_decode($out, true);
        print_r($result);
        sleep(1);
    }
    public function notes($param_id, $param_type, $param_note_type, $param_text){
        $data = array(
            'add' => array(
                0 => array(
                    'element_id' => $param_id,
                    'element_type' => $param_type,
                    'note_type' => $param_note_type,
                    'text' => $param_text,
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/notes";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $result = json_decode($out, true);
        sleep(1);
    }
    public function tack($param_id, $param_essence_type, $param_date, $param_task_type, $param_text, $idResponsible){
        $data = array(
            'add' => array(
                0 => array(
                    'element_id' => $param_id,
                    'element_type' => $param_essence_type,
                    'complete_till' => $param_date,
                    'task_type' => $param_task_type,
                    'text' => $param_text,
                    'responsible_user_id' => $idResponsible,
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/tasks";

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-
                  undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $result = json_decode($out, true);
        print_r($result);
        sleep(1);
    }
    public function tack_list(){
        $link = 'https://test2korgik.amocrm.ru/api/v2/tasks';

        $headers[] = "Accept: application/json";

        //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
        #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $result = json_decode($out, true);
        $this->_task = $result["_embedded"]["items"];
        sleep(1);
    }
    public function finish_task($param_id_task){
        $date = date_create();
        $data = array(
            'update' =>
                array(
                0 =>
                    array(
                    'id' => $param_id_task,
                    'updated_at' => date_timestamp_get($date),
                    'text' => 'Завершено',
                    'is_completed' => '1',
                ),
            ),
        );
        $link = "https://test2korgik.amocrm.ru/api/v2/tasks";

        $headers[] = "Accept: application/json";
          
           //Curl options
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client-undefined/2.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . "/cookie.txt");
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . "/cookie.txt");
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
           /* Теперь мы можем обработать ответ, полученный от сервера.*/
        $code = (int)$code;
        $errors = array(
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable'
        );
        try {
            #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if ($code != 200 && $code != 204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
        } catch (Exception $E) {
            die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
        }
        $result = json_decode($out, true);
        print_r($result);
        sleep(1);

    }
    public function my_print($data){
        print_r("<pre>");
        print_r($data);
        print_r("</pre>");
    }
}
