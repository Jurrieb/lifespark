<?php
    foreach($friends as $friend) {
        echo $this->element('friend', ['friend' => $friend]);
    }