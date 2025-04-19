 <?php 
 		
 
                              
                               if($this->data['Person']['credit_type_id'] == 1) { 
                        ?>
                         
                         <span><font color="red">*</font>&nbsp;
                           <?php 
          						echo $this->Form->input('Patient.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>
                          <br>
                          <span id="changeCorprateLocationList">
                          <font color="red">*</font>&nbsp;
                            <?php 
          						echo $this->Form->input('Patient.corporate_location_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporatelocations, 'empty' => __('Select Corporate Location'), 'id' => 'ajaxcorporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>
                          <br>
                          <span id="changeCorporateList">
                          <font color="red">*</font>&nbsp;
                           <?php 
          						echo $this->Form->input('Patient.corporate_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporates, 'empty' => __('Select Corporate'), 'id' => 'ajaxcorporateid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList', 'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?>
                          <br>
                          <span id="changeCorporateSublocList">&nbsp;&nbsp;
                            <?php 
          						echo $this->Form->input('Patient.corporate_sublocation_id', array('class'=>'textBoxExpnd1','options' => $corporatesublocations, 'empty' => __('Select Corporate Sublocation'), 'id' => 'ajaxcorporatesublocationid', 'label'=> false, 'div' => false, 'error' => false));
                          ?>
                          <?php 
                                echo "<br />";
                                echo __('Other Details :');
                                echo $this->Form->textarea('corporate_otherdetails', array('value'=> $this->data['Person']['corporate_otherdetails'],'class' => 'textBoxExpnd','id' => 'otherdetails','row'=>'3')); 
                          ?>
                          </span>
                          </span>
                          </span>
                          </span>
                          
                       <?php } if($this->data['Person']['credit_type_id'] == 2) { ?>
                           <span><font color="red">*</font>&nbsp;
                           <?php 
         						 echo $this->Form->input('Patient.credit_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?><br>
                           <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp;
                            <?php 
          						echo $this->Form->input('Patient.insurance_type_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancetypes, 'empty' => __('Select Insurance Type'), 'id' => 'insurancetypeid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true, 'div'=>false))));
                          ?><br>
                          <span id="changeInsuranceCompanyList"><font color="red">*</font>&nbsp;
                           <?php 
          						echo $this->Form->input('Patient.insurance_company_id', array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
                          ?>
                         </span>
                        </span>
                        </span>
                       <?php 
                             } 
                            
                       ?>