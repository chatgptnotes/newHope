<?php if($_SESSION['roleid'] == '45'){?>
<?php echo $this->element('portal_header');?>
<!--  <div align="right" > <a href="#" id="change_login_date"><?php echo __("Change Login Date");?></a></div>-->
<?php }?>
<style>
.mail_page_wrapper > p {
    font-size: 13px;
    
}

.mail_page_wrapper li {
    font-size: 13px;
}
td {
    font-size: 13px;
}
li{ 
font-size:13px;
}

/**
 * for left element1
 */

.td_second{
	border-left-style:solid; 
	padding-left: 20px; 
	padding-top: px;
}
/* EOCode */

</style>


<div class="inner_title">
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Mailbox') ?>
	</h3>
</div>

<table width="100%"  cellspacing='0' cellpadding='0' style="margin-bottom: -20px;" >
	<tr>
		<td valign="top" width="5%" >	
			<div class="mailbox_div">
			
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second">
			<div class="mail_page_wrapper">
			<p><strong>Health Maintainance Alerts:</strong></p>
				<p>DrM Hope Software has developed a "notification system" in your electronic
					chart to inform you and your physician that you may be due for certain
					health maintenance screening tests. (A list of recommended screening
					tests is shown below.) <br/>The right plan for your care may differ based
					on your personal preferences, medical history, family history,
					lifestyle, and your physician's experience. <br/>You and your physician
					should work together to develop the specific preventive screening plan
					for you.<br/> In addition, these are generally MINIMUM recommendations, are
					not all-inclusive, and are based on current evidence and national
					recommendations (see reference links below).<br/> Please also note that
					Medicare or your health insurance plan may not cover some of the
					following tests and vaccinations.<br/> You should check your specific
					coverage before obtaining them.</p>
				<p>Keep in mind that there is a chance that you may have received an
					"overdue" message in error due to one of the following reasons:
				
				
				<div style='padding-left: 39px'>
					<li>Information in your paper chart may not have been transferred to
						the electronic medical record.</li>
					<li>The suggested screening test may not be appropriate for you based
						on your current medical conditions.</li>
					<li>Current guidelines may have changed and the changes have not yet
						been modified by the team of physicians in charge of these
						recommendations at the Cleveland Clinic.</li>
				</div>
				</p>
				<p>If you have received an overdue alert, you may wish to do one of the
					following:
				
				
				<div style='padding-left: 39px'>
					<li>Discuss with your physician at your next regular office visit.</li>
					<li>Schedule a comprehensive office evaluation.</li>
					<li>Call the office for further clarification.</li>
				</div>
				The electronic medical record is currently set to generate health alerts for adults based on the following criteria:
				</p>
			</div>
			<div>
				<table class="" style="text-align: left;" width=100% cellspacing='0px' cellpadding='5px' >
					<tr>
						<td width="50%" valign="middle" class=""><strong>Screening Test</strong> </td>
						<td width="50%" valign="middle" class=""><strong>Recommendation</strong> </td>
					</tr>
					<tr>
						<td width="50%" valign="middle" class="">Cholesterol screening (including LDL), (for women and men).</td>
						<td width="50%" valign="middle" class="">Begin at age 20, if normal, repeat every 5 years.</td>
					</tr>
					<tr >
						<td width="50%" valign="middle" class="">Blood glucose (sugar) for diabetes (for women and men).</td>
						<td width="50%" valign="middle" class="">Start at age 45, then every 3 years.</td>
					</tr>
					<tr>
						<td width="50%" valign="middle" class="">Colorectal cancer screening (for women and men).</td>
						<td width="50%" valign="middle" class="">Start at age 50, then repeat based on findings. Stop alerts at age 80. Physician and patient can discuss whether to continue alerts after age 80.</td>
					</tr>
					<tr "">
						<td width="50%" valign="middle" class="">Mammograms (for women).</td>
						<td width="50%" valign="middle" class=""> Mammograms yearly starting at age 40. Stop mammogram alerts at age 80. Physician and patient can discuss whether to continue alerts after age 80.</td>
					</tr>
					<tr>
						<td width="50%" valign="middle" class="">Pap test (cervical cancer screen) (for women).</td>
						<td width="50%" valign="middle" class="">Every two years between age 21-30; every 3 years for age 31 and older (computer alert ends at age 65).</td>
					</tr>
					<tr "">
						<td width="50%" valign="middle" class="">Bone mineral density (osteoporosis screen)(for women).</td>
						<td width="50%" valign="middle" class="">Measure in all at age 65 and older and in postmenopausal women with additional risk factors</td>
					</tr>
					<tr>
						<td width="50%" valign="middle" class="">Prostate cancer screening (for men).</td>
						<td width="50%" valign="middle" class="">Once after age 50</td>
					</tr>
					<tr "">
						<td width="50%" valign="middle" class="">Influenza vaccination (Flu shot) (for women and men).</td>
						<td width="50%" valign="middle" class="">Influenza vaccine is a universal recommendation starting at age 6 months, then every year sometime between October and January</td>
					</tr>
					<tr>
						<td width="50%" valign="middle" class="">Pneumococcal vaccination (for women and men).</td>
						<td width="50%" valign="middle" class="">Once after age 65</td>
					</tr>
					<tr "">
						<td width="50%" valign="middle" class="">Tetanus and Diphtheria vaccination (for women and men).</td>
						<td width="50%" valign="middle" class="">Start at age 11, then every 10 years</td>
					</tr>
							</table>
					
						<p>For diabetic patients:</p>
						<div style='padding-left: 39px'>
			    <li>HBA1C at least every 6 months</li>
			    <li>Urine microalbumin yearly</li>
			    <li>Lipid (cholesterol) at least every year</li>
			    <li>Dilated eye exam (ophthalmology appt) at least every year</li>
			    <li>Foot exam at least every 12 months</li>
			    <li>Pneumovax (one-time vaccination)</li>
			    <li>Annual seasonal flu vaccine<br/>
			    <p></p>
				</div>
			
			</div>
		</td>	
	</tr>
</table>
