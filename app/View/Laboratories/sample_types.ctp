
<div id="doctemp_content">
	<div class="inner_title">
		<h3>
			<?php echo __($title_for_layout, true); ?>
		</h3>
		<span> <?php
		
		echo $this->Html->link ( __ ( 'Add', true ), "javascript:void(0);", array (
				'escape' => false,
				'class' => 'blueBtn',
				'id' => 'add-note' 
		) );
		
		echo $this->Html->link ( __ ( 'Back', true ), array (
				'controller' => 'Laboratories' 
		), array (
				'escape' => false,
				'class' => 'blueBtn' 
		) );
		?>
		</span>
	</div>
	<?php
	
	echo $this->Form->create ( 'sampleTypes', array (
			'url' => array (
					'controller' => 'Laboratories',
					'action' => 'sampleTypes' 
			),
			'id' => 'specimenTypefrm',
			'inputDefaults' => array (
					'label' => false,
					'div' => false 
			) 
	) );
	echo $this->Form->hidden ( 'SpecimenType.id', array (
			'id' => 'note-id' 
	) );
	if ($action == 'edit')
		$display = '';
	else
		$display = 'none';
	?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="500px" align="right" style="display:<?php echo $display; ?>;" id="note-add-form">
		<tr>
			<td><label style="width: 99px;"><?php echo __('Sample Type');?>:<font
					color="red">*</font> </label></td>
			<td><?php echo $this->Form->input('SpecimenType.description', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
			</td>
		</tr>
		<tr>
			<td class="row_format" align="right" colspan="2"><?php
			echo $this->Html->link ( 'Cancel', 'javascript:void(0);', array (
					'escape' => false,
					'id' => 'note-cancel',
					'class' => 'blueBtn' 
			) );
			echo $this->Form->submit ( __ ( 'Submit' ), array (
					'label' => false,
					'div' => false,
					'error' => false,
					'class' => 'blueBtn' 
			) );
			?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	<div>&nbsp;</div>
	<?php echo $this->Form->create('',array('url'=>array('controller'=>'Laboratories','action'=>'sampleTypes'),'type'=>'Get','id'=>'specimenTypefrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));?>
	<table border="0" cellpadding="0" cellspacing="0" width="500px;"
		style="padding-left: 19px; padding-right: 20px;">
		<tbody>
			<tr class="row_title">
				<td width="30%" class=""
					style="border: none !important; font-size: 13px;"><?php echo __('Sample Type :')?>
				</td>
				<td width="30%" style="border: none !important;"><?php  echo $this->Form->input('', array('name'=>'description','type'=>'text','id' => 'description_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
				</td>
				<td width="40%" style="border: none !important;"><?php echo $this->Form->submit(__('Search'),array('label'=> false,'div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search','style'=>'margin-left:10px;'));	?>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Laboratories','action'=>'sampleTypes'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('SpecimenType.description', __('Sample Type', true)); ?>
			</strong></td>
			<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
			</td>
		</tr>
		<?php
		$cnt = 0;
		if (count ( $data ) > 0) {
			foreach ( $data as $sampleAry ) :
				$cnt ++;
				?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $sampleAry['SpecimenType']['description']; ?>
			</td>
			<td><?php
				echo $this->Html->link ( $this->Html->image ( 'icons/edit-icon.png', array (
						'title' => __ ( 'Edit', true ),
						'alt' => __ ( 'Edit', true ) 
				) ), array (
						'controller' => 'Laboratories',
						'action' => 'sampleTypes',
						$sampleAry ['SpecimenType'] ['id'] 
				), array (
						'escape' => false 
				) );
				echo $this->Html->link ( $this->Html->image ( 'icons/delete-icon.png', array (
						'title' => __ ( 'Delete', true ),
						'alt' => __ ( 'Delete', true ) 
				) ), array (
						'controller' => 'Laboratories',
						'action' => 'deleteSampleType',
						$sampleAry ['SpecimenType'] ['id'] 
				), array (
						'escape' => false 
				), "Are you sure you wish to delete this sample type?" );
				?>
		
		
		
		
		
		
		
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="8" align="center" class="table_format"><?php
			$queryStr = $this->General->removePaginatorSortArg ( $this->params->query ); // for sort column
			$this->Paginator->options ( array (
					'url' => array (
							"?" => $queryStr 
					) 
			) );
			echo $this->Paginator->counter ( array (
					'class' => 'paginator_links' 
			) );
// 			echo $this->Paginator->prev ( __ ( '« Previous', true ), array(/*'update'=>'#doctemp_content',*/
// 						'complete' => $this->Js->get ( '#busy-indicator' )->effect ( 'fadeOut', array (
// 							'buffer' => false 
// 					) ),
// 					'before' => $this->Js->get ( '#busy-indicator' )->effect ( 'fadeIn', array (
// 							'buffer' => false 
// 					) ) 
// 			), null, array (
// 					'class' => 'paginator_links' 
// 			) );
			?>

				<?php
			echo $this->Paginator->numbers ();
			?> <?php
			
			echo $this->Paginator->next ( __ ( 'Next »', true ), array(/*'update'=>'#doctemp_content',*/
							'complete' => $this->Js->get ( '#busy-indicator' )->effect ( 'fadeOut', array (
							'buffer' => false 
					) ),
					'before' => $this->Js->get ( '#busy-indicator' )->effect ( 'fadeIn', array (
							'buffer' => false 
					) ) 
			), null, array (
					'class' => 'paginator_links' 
			) );
			?>

				<span class="paginator_links"> </span></TD>
		</tr>
		<?php
		} else {
			?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
		}
		echo $this->Js->writeBuffer (); // please do not remove
		?>
	</table>
</div>
<script>
jQuery(document).ready(function(){
	
 	jQuery("#specimenTypefrm").validationEngine();						 
				 
 	$('#description_search').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","SpecimenType","id&description",'null',"no","no","is_deleted=0","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
		},
		 messages: {noResults: '',results: function() {}
		 }
	});
	
	$("#add-note").click(function(){
		$( "#specimenTypefrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) {
			$(this).val('');
		});
		$("#note-add-form").show('slow') ;
	});

	$("#note-cancel").click(function(){
		$( "#specimenTypefrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) { //reset current form
			$(this).val('');
		});
		$("#note-add-form").hide('slow') ;
	});
});
</script>
