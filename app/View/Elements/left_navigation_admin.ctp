<span>Hospital Centric Details</span>

<!-- Row 1 -->
<div class="row_modules">
<table cellpadding="0px" cellspacing="0px" align="center">
<tr>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "index", "superadmin" => false));?>"">
			<img src="<?php echo $this->Html->url("/img/icons/patient_record.jpg");?>" />
		</a>

<p style="margin:0px; padding:0px;"><?php echo __('Patients',true); ?></p>
</td>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "locations", "action" => "index", "superadmin" => true));?>"">
			<img src="<?php echo $this->Html->url("/img/icons/location.png");?>" />
		</a>

<p style="margin:0px; padding:0px;"><?php echo __('Locations',true); ?></p>
</td>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "users", "action" => "index","superadmin"=>true, 'plugin' => false));?>"">
			<img src="<?php echo $this->Html->url("/img/icons/role.png");?>" />
		</a>

<p style="margin:0px; padding:0px;"><?php echo __('Users',true); ?></p>
</td>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "acl", "action" => "index", 'admin' => true));?>"">
			<img src="<?php echo $this->Html->url("/img/icons/roomready.jpg");?>" />
		</a>

<p style="margin:0px; padding:0px;"><?php echo __('Permissions',true); ?></p>
</td>
</tr>
</table>
</div>
<!-- Row 1 Ends Here -->

<!-- Row 1 -->
<div class="row_modules">
<table cellpadding="0px" cellspacing="0px" align="center">
<tr>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "cities", "action" => "index", "admin" => true, 'plugin' => false));?>"">
<img src="<?php echo $this->Html->url("/img/icons/city.png");?>" />
<p style="margin:0px; padding:0px;"><?php echo __('City',true); ?></p></a>
</td>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "states", "action" => "index", "admin" => true, 'plugin' => false));?>"">
<img src="<?php echo $this->Html->url("/img/icons/state.png");?>" />
<p style="margin:0px; padding:0px;"><?php echo __('State',true); ?></p></a>
</td>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "countries", "action" => "index", "admin" => true, 'plugin' => false));?>"">
<img src="<?php echo $this->Html->url("/img/icons/country.png");?>" />
<p style="margin:0px; padding:0px;"><?php echo __('Country',true); ?></p></a>
</td>
<td align="center" valign="top">
<a href="<?php echo $this->Html->url(array("controller" => "roles", "action" => "index", 'plugin' => false, 'admin' => true));?>"">
<img src="<?php echo $this->Html->url("/img/icons/roomready.jpg");?>" />
<p style="margin:0px; padding:0px;"><?php echo __('Role',true); ?></p></a>
</td>
</tr>
</table>
</div>
<!-- Row 1 Ends Here -->




</div>