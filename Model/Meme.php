<?php

class Meme extends AppModel {

    public $belongsTo = array(
        'MemeImage' => array(
            'className' => 'MemeImage',
            'foreignKey' => 'meme_image_id'
        )
    );

}

?>