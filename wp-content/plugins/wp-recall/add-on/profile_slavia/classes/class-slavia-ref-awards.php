<?php
    class Ref_Awards
    {

        public function __construct($args)
        {

        }

        public function get_all()
        {
            return rcl_get_option('ref_awards');
        }

        /*Функция уведомления выбранных пользователей по email о реферальной операции
        (на вход подается host_id, host_name - id и имя пригласившего (хоста),
        ref_id, ref_name - id и имя приглашенного (пользователь, совершивший операцию),
        $notify_managers - уведомление всех менеджеров, $notify_cur_user - уведомить текущего пользователя)*/
        public function operation_notify($notification_data, $notify_managers = true, $notify_cur_user = true)
        {
            $log = new Rcl_Log();
            $log->insert_log("notification_data: ".print_r($notification_data, true));
            if ($notify_managers)
            {
                $managers = get_users(array('role' => 'manager'));
                if (!empty($managers))
                {
                    $subject = 'SLAVIA: Отправить пользователю ' . $notification_data['host_name'] . ' с ID ' .
                        $notification_data['host_id'] . ' вознаграждение.';

                    //Отправляем email всем менеджерам о необходимости отправить вознаграждение пригласившему

                    $textmail = '<p>Пользователь ' . $notification_data['ref_name'] . ' с ID ' . $notification_data['ref_id'] .
                        ' только что совершил новую операцию.</p>' .
                        '<p>Необходимо выплатить пригласившему его пользователю ' . $notification_data['host_name'] .
                        ' с ID ' . $notification_data['host_id'] . ' вознаграждение в размере ' .
                        $notification_data['award_sum'] . ' ' . $notification_data['award_currency'] .
                        ' в соответствии с условиями реферальной программы.</p>';

                    foreach ($managers as $manager) {

                        $user_email = $manager->user_email;

                        rcl_mail($user_email, $subject, $textmail);
                    }
                }
            }
            if ($notify_cur_user)
            {
                $subject = 'SLAVIA: Вознаграждение по реферальной программе: приглашенный вами пользователь ' . $notification_data['ref_name'] . ' совершил новюу операцию.';

                //Отправляем email всем менеджерам о необходимости отправить вознаграждение пригласившему

                $textmail = '<p>Приглашенный вами пользователь ' . $notification_data['ref_name'] .
                    ' только что совершил новую операцию.</p>' .
                    '<p>Вам причитается вознаграждение в размере ' .
                    $notification_data['award_sum'] . ' ' . $notification_data['award_currency'] .
                    ' в соответствии с условиями реферальной программы.</p>';

                $user_data = get_userdata($notification_data['host_id']);
                $user_email = $user_data->user_email;

                rcl_mail($user_email, $subject, $textmail);
            }
        }

        public function add($host_id, $award_item)
        {
            $items = $this->get_all();

            if (isset($items) && !empty($items))
            {
                if (isset($items[$host_id]) )
                {
                    array_push($items[$host_id], $award_item);
                }
                elseif (!isset($items[$host_id]))
                {
                    //Добавляем массив данных для данного пользователя
                    array_push($items, array($host_id => array()));
                    array_push($items[$host_id], $award_item);
                }
            }
            //Если еще нету запросов на обмен
            else
            {
                $items = array($host_id => array());
                array_push($items[$host_id], $award_item);
            }

            rcl_update_option('ref_awards', $items);

            $log = new Rcl_Log();
            $log->insert_log("ref_awards: ".print_r(rcl_get_option('ref_awards'), true));

            //ref_awards[host_user_id][award_id] => data = array("date", "award_sum", "ref_user_id", "status")
        }

        public function change_item_status($new_status)
        {

        }

    }
?>