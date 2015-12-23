<div class="row-fluid">
    <div class="span12">
         <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                   Import <?php echo Inflector::pluralize($modelClass);?> from CSV data file
                </h3>
            </div>
        
            <div class="box-content">
              <?php
                    echo $this->Form->create($modelClass, array('action' => 'import', 'type' => 'file') );
                    echo $this->Form->input('CsvFile', array('label'=>'','type'=>'file'));
                    echo $this->Form->end('Submit');
                ?>  
             </div>
        </div>
    </div>
</div>




