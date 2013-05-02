<?php
    $line = $events[0]['Event'];
    $this->CSV->addRow(array_keys($line));
    foreach ($events as $event) {
        $line = $event['Event'];
        debug(strip_tags(html_entity_decode($line['desc'])));exit;
        $this->CSV->addRow($line);
    }
    $filename = 'Export_myEvent';
    echo $this->CSV->render($filename);
?>