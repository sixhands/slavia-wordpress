<?php
    class Ref_Awards
    {
        public $items;

        function __construct($args)
        {
            $this->items = $this->get_all();
        }
        function get_all()
        {
            return rcl_get_option('ref_awards');
        }
        function add($host_id, $award_item)
        {
            $this->items = $this->get_all();

            $items = $this->items;

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

            //ref_awards[host_user_id][award_id] => data = array("date", "award_sum", "ref_user_id", "status")

        }

    }
?>