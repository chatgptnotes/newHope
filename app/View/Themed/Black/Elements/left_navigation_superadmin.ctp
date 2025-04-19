<!-- First Tab Department -->
        <div class="tab_dept">
        <span style="text-align:center;font-size:19px;">Enterprise Centric Specialty</span>
        
        <!-- Row 1 -->
        <div class="row_modules">
          <?php echo $this->Html->link($this->Html->image('/img/icons/hospital.jpg', array('alt' => 'Company')),array("controller" => "hospitals", "action" => "index", "superadmin" => true, 'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Enterprise',true); ?></p>
       </div>
       <div class="row_modules">
          <?php echo $this->Html->link($this->Html->image('/img/icons/role.jpg', array('alt' => 'Users')),array("controller" => "users", "action" => "index", "superadmin" => true, 'plugin' => false), array('escape' => false)); ?>
					 <p style="margin:0px; padding:0px;"><?php echo __('Users',true); ?></p>
       </div> 
        <!-- Row 1 Ends Here -->
        
        <!-- Row 2 -->
        <!--<div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        <tr>
		                <td align="center" valign="top">
                                       <?php echo $this->Html->link($this->Html->image('/img/icons/city.jpg', array('alt' => 'Cities')),array("controller" => "cities", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('City',true); ?></p>
				</td>
					<td align="center" valign="top">
                                      <?php echo $this->Html->link($this->Html->image('/img/icons/state.jpg', array('alt' => 'States')),array("controller" => "states", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('State',true); ?></p>
				</td>
				<td align="center" valign="top">
                                      <?php echo $this->Html->link($this->Html->image('/img/icons/country.jpg', array('alt' => 'Countries')),array("controller" => "countries", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Country',true); ?></p>
				</td>
				
        </tr>
        </table>
        </div>-->
        <!-- Row 2 Ends Here -->
         <!-- Row 3 -->
        <div class="row_modules">
          <?php echo $this->Html->link($this->Html->image('icons/map.jpg', array('alt' => __('Geographical Region'), 'title' => __('Geographical Region'))),array("controller" => "countries", "action" => "geographicmap", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
           <p style="margin:0px; padding:0px;"><?php echo __('Geographical Region',true); ?></p>	  
        </div>
        <div class="row_modules">
          <?php echo $this->Html->link($this->Html->image('icons/hospital-invoice.jpg', array('alt' => __('Company Invoice'), 'title' => __('Hospital Invoice'))),array("controller" => "hospital_invoices", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> true), array('escape' => false)); ?>
           <p style="margin:0px; padding:0px;"><?php echo __('Enterprise Invoice',true); ?></p>	  
        </div>
         <div class="row_modules">
          <?php echo $this->Html->link($this->Html->image('icons/permission.jpg', array('alt' => __('Permissions'), 'title' => __('Permissions'))),
          		array("controller" => "hospitals", "action" => "permissions", "admin" => false,'plugin' => false, 'superadmin'=> true), array('escape' => false)); ?>
           <p style="margin:0px; padding:0px;"><?php echo __('Permissions',true); ?></p>
        </div>
        
        <!-- Row 3 -->
                
        </div>
        <!-- First Tab Department Ends Here -->
  
    
  