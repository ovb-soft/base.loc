<?php

namespace Run\model\panel\module\personal;

class Personal extends \Run\model\panel\Main {

    private $mail,
            $user,
            $time,
            $date;

    public function __construct($param)
    {
        parent::__construct($param);
        $this->_view();
        parent::view([
            'content' => require 'view.php'
        ]);
    }

    private function _view()
    {
        $this->user = filter_input(2, 'panel:user');
        $data = unserialize(file_get_contents(
                        dirname(__DIR__, 3) . '/data/panel/user/' . $this->user . '/data.sz')
        );
        $this->mail = $data['mail'];
        $this->user = str_replace('.', ' ', $this->user);
        $this->_created($data['created']);
    }

    private function _created($created)
    {
        $date_time = unserialize(file_get_contents(dirname(__DIR__, 3) . '/data/param/date.time.sz'));
        $date = new \DateTime(null, new \DateTimeZone($date_time['time_zone']));
        $date->setTimestamp($created);
        $d = explode(' ', $date->format('Y d m H i'));
        $this->time = $d[3] . ':' . $d[4];
        $this->date = $d[1] . '.' . $d[2] . '.' . $d[0];
    }

}
