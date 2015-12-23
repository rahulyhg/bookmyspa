 <?php
echo $this->Paginator->numbers(array(
        'before' => '<ul class="pagination">',
        'separator' => '',
       'currentClass' => 'active',
        'currentTag' => 'a',
        'tag' => 'li',
        'after' => '</ul>'
    ));
?>