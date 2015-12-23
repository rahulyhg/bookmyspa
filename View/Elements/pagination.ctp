<?php 
if ($this->Paginator->hasPage(null, 2)) { 
    echo '<tfoot>';
    echo '<tr>';
    echo '<td colspan="7" class="text-right">';
    echo '  <ul class="pagination pagination-right">';
    echo $this->Paginator->first('<span class="glyphicon glyphicon-fast-backward"></span> First', array('escape' => false, 'tag' => 'li'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
    echo $this->Paginator->prev('<span class="glyphicon glyphicon-step-backward"></span> Prev', array('escape' => false, 'tag' => 'li'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
    echo $this->Paginator->numbers(array(
        'currentClass' => 'current',
        'currentTag' => 'a',
        'tag' => 'li',
        'separator' => '',
    ));
    echo $this->Paginator->next('Next <span class="glyphicon glyphicon-step-forward"></span>', array('escape' => false, 'tag' => 'li', 'currentClass' => 'disabled'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
    echo $this->Paginator->last('Last <span class="glyphicon glyphicon-fast-forward"></span>', array('escape' => false, 'tag' => 'li', 'currentClass' => 'disabled'), null, array('escape' => false, 'tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));

    echo '  </ul>';
    //echo '<p>'.$this->Paginator->counter(array('format' => 'Page {:page} of {:pages}, showing {:current} records out of {:count} total.')).'</p>';
    echo '</td>';
    echo '</tr>';
    echo '</tfoot>';    
}

?>
 <?php echo $this->Js->writeBuffer(); ?>  