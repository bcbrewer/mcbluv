<?php

    $data = 'id="players", size="9"';
    echo form_label('Add Players to game', 'players[]', array('style' => 'float: left;'));
    echo "<br />";
    echo form_multiselect('id[]', $list, '', $data);
    echo "<br />";
    echo form_submit('submit', 'Add Players');

?>
