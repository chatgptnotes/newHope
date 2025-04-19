<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<?php 
     App::import('Vendor', 'fusionx_charts'); 
     echo $this->Html->script(array('/fusionx_charts/fusioncharts', 'jquery-ui-1.9.0.custom.min'));
?>
<style>
/*  reset & .clear
----------------------------*/

* {
    margin: 0;
    padding: 0;
}

.clear:before,
.clear:after {
    content: " ";
    display: table;
}

.clear:after { clear: both }

.clear { *zoom: 1 }

/*  MAIN
----------------------------*/



li { list-style: none }

a { text-decoration: none }

.container {
    position: relative;
    width: 1170px;
    margin: 30px auto;
}

.container #product {
    position: relative;
    z-index: 2;
    float: left;
    width: 290px;
   
}

.container #sidebar {
    position: relative;
    z-index: 1;
    float: right;
    width: 400px;
}

/*  PRODUCTS
----------------------------*/

#product ul {
    width: 280px;
    margin-left: -10px;
    padding-right: 50px; }

#product ul li {
    position: relative;
    float: left;
    width: 290px;
    margin: 0 0 10px 10px;
    padding: 5px;
    background-color: #3A4346;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
    box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
    -webkit-transition: -webkit-transform .1s ease;
    -moz-transition: -webkit-transform .1s ease;
    -o-transition: -webkit-transform .1s ease;
    -ms-transition: -webkit-transform .1s ease;
    transition: transform .1s ease;
    text-align: center;
}

#product ul li:hover {
    background-color: #212224;
}

#product.active ul li {
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
    filter: alpha(opacity = 40);
    opacity: .4;
}

#product.active ul li.active {
    z-index: 2;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    filter: alpha(opacity = 100);
    opacity: 1;
    -webkit-transform-origin: 50% 50%;
    -moz-transform-origin: 50% 50%;
    -o-transform-origin: 50% 50%;
    -ms-transform-origin: 50% 50%;
    transform-origin: 50% 50%;
    -webkit-transform: scale(.6);
    -moz-transform: scale(.6);
    -o-transform: scale(.6);
    -ms-transform: scale(.6);
    transform: scale(.6);
}

#product ul li a {
    display: block;
    color: #fff
}

#product ul li a h3 {
    margin-top: 5px;
}

#product ul li a h3,
#product ul li a p {
    white-space: nowrap;
    overflow: hidden;
    -o-text-overflow: ellipsis;
    -ms-text-overflow: ellipsis;
    text-overflow: ellipsis;
}

#product ul li a img { display: block }

/*  BASKET
----------------------------*/

.basket {
    position: relative;
}

/*.basket .basket_list {
    width: 220px;
    background-color: #fff;
    border: 2px dashed transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
    box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
}*/

.basket.active .basket_list,
.basket.hover .basket_list { border-color: #ffa0a3 }

.basket.active .basket_list { background-color: #fff8c1 }

.basket.hover .basket_list { background-color: #ffa0a3 }

/* .head */

/*.basket .head {
    overflow: hidden;
    margin: 0 10px;
    height: 26px;
    line-height: 26px;
    color: #666;
    border-bottom: 1px solid #ddd;
}*/

.basket .head .name { float: left }

.basket .head .count { float: right }

/* .head */

.basket ul { padding-bottom: 10px }

.basket ul li {
    position: relative;
    /*clear: both;*/
    /overflow: hidden;
    margin: 0 10px;
    /*height: 26px;*/
    line-height: 32px;
    border-bottom: 1px dashed #eee;
    float:left;
    
}

.basket ul li:hover { border-bottom-color: #ccc }


.basket ul li span.name {
    display: block;
    float: left;
    width: 165px;
    font-weight: bold;
    white-space: nowrap;
    /*overflow: hidden;*/
    -o-text-overflow: ellipsis;
    -ms-text-overflow: ellipsis;
    text-overflow: ellipsis;
    -webkit-transition: width .2s ease;
    -moz-transition: width .2s ease;
    -o-transition: width .2s ease;
    -ms-transition: width .2s ease;
    transition: width .2s ease;
}

.basket ul li:hover span.name { width: 146px }

.basket ul li input.count {
    float: right;
    margin: 3px 2px 0 0;
    width: 25px;
    line-height: 20px;
    text-align: center;
    border: 0;
    border-radius: 3px;
    background-color: #ddd;
}

.basket ul li button.delete {
    position: absolute;
    right: 30px;
    top: 3px;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity = 0);
    opacity: 0;
    width: 20px;
    line-height: 20px;
    height: 20px;
    text-align: center;
    font-size: 11px;
    border: 0;
    color: #EE5757;
    background-color: #eee;
    border-radius: 3px;
    cursor: pointer;
    -webkit-transition: opacity .2s ease;
    -moz-transition: opacity .2s ease;
    -o-transition: opacity .2s ease;
    -ms-transition: opacity .2s ease;
    transition: opacity .2s ease;
}

.basket ul li:hover button.delete {
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    filter: alpha(opacity = 100);
    opacity: 1;
}

.basket ul li button.delete:hover {
    color: #fff;
    background-color: #ffa0a3;
}

.basket ul li button.delete:active {
    color: #fff;
    background-color: #EE5757;
}

</style>
<div style="text-align:center;padding-top:20px">
<h3><?php echo __('Customize Chart Dashboard', true); ?></h3>

</div>
<span style="float: right; padding-right:20px"><?php //echo $this->Html->link(__('Back'),array(), array('escape' => false,'class'=>'blueBtn back')); ?>
		<input type="button" name="Back" value="Back" class="blueBtn goBack">
	</span>
<div class="container">

	    <div id="product">
        <ul class="clear">
            <li id="1">
                <a href="#">
                  <h3>Total Number of UID Registration</h3>
                </a>
            </li>
            <li id="2">
                <a href="#">
                  <h3>Total Number of IPD Patient Cash/Card</h3>
                </a>
            </li>
            <li id="3">
                <a href="#">
                 <h3>OPD Patient Survey</h3>
                </a>
            </li>
            <li id="4">
                <a href="#">
                    <h3>Total Number of OPD/IPD</h3>
                </a>
            </li>
         </ul>
  </div>


 <?php echo $this->Form->create(null, array('controller' => 'users', 'action' => 'save_customize_chart_dashboard'));?>          
        <div id="sidebar">
        <div style="padding-left:220px;"><input type="submit" value="Save Dashboard Chart" class="blueBtn"></div>
        <div class="basket" style="border: 1px solid #3C4548; height: 704px; margin: 0px; padding: 0px; float: right; width: 840px;">
            <div class="basket_list">
                 <ul>
                  <!-- here we are inserting chart -->
                  <?php 
                     $chartArray = array('chart1' => 'Total Number of UID Registration', 'chart2' => 'Total Number of IPD Patient Cash/Card', 'chart3' => 'OPD Patient Survey', 'chart4' => 'Total Number of OPD/IPD');
                     if(count($userDashboardChart) > 0) {  
                  ?>
                      <?php foreach($userDashboardChart as $userDashboardChartVal) { $userChartCnt++; ?>
	                    <li id="<?php echo $userChartCnt;?>">
	                     <span class="name"><?php echo $chartArray[$userDashboardChartVal['UserDashboardChart']['chartname']]; ?></span>
	                     <input type="hidden" value="<?php echo $userDashboardChartVal['UserDashboardChart']['ordervalue']; ?>" name="chartname[<?php echo $userDashboardChartVal['UserDashboardChart']['chartname'];?>]">
	                     <button class="delete">✕</button>
                         <?php
                            $userChartToDisplay = $this->requestAction('/users/createCustomizeChart?charttypeid='.$userDashboardChartVal['UserDashboardChart']['chartname']); 
                            echo $userChartToDisplay;
                         ?>
	                  <?php } ?>
                  <?php } ?>
                </ul>
            </div>
        </div>
     </div>
     
 <?php echo $this->Form->end();?>
</div>

<script>
    $(function () {

		// jQuery UI Draggable
		$("#product li").draggable({
		
			// brings the item back to its place when dragging is over
			revert:true,
		
			// once the dragging starts, we decrease the opactiy of other items
			// Appending a class as we do that with CSS
			drag:function () {
				$(this).addClass("active");
				$(this).closest("#product").addClass("active");
			},
		
			// removing the CSS classes once dragging is over.
			stop:function () {
				$(this).removeClass("active").closest("#product").removeClass("active");
			}
		});

        // jQuery Ui Droppable
		$(".basket").droppable({
		
			// The class that will be appended to the to-be-dropped-element (basket)
			activeClass:"active",
		
			// The class that will be appended once we are hovering the to-be-dropped-element (basket)
			hoverClass:"hover",
		
			// The acceptance of the item once it touches the to-be-dropped-element basket
			// For different values http://api.jqueryui.com/droppable/#option-tolerance
			tolerance:"touch",
			drop:function (event, ui) {
		
				var basket = $(this),
						move = ui.draggable,
						itemId = basket.find("ul li[id='" + move.attr("id") + "']");
				$('#'+ move.attr("id")).hide();
				// To increase the value by +1 if the same item is already in the basket
				if (itemId.html() != null) { return false;
					//itemId.find("input").val(parseInt(itemId.find("input").val()) + 1);
				}
				else {
					// Add the dragged item to the basket
					addBasket(basket, move);
		
					// Updating the quantity by +1" rather than adding it to the basket
					//move.find("input").val(parseInt(move.find("input").val()) + 1);
				}
			}
		});

        // This function runs once an item is added to the basket
        var cnt=0;
        function addBasket(basket, move) { 
        	cnt++;
        	$('#busy-indicator').show();
        	var data = "charttypeid=chart" + move.attr("id");
			$.ajax({url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "createCustomizeChart", "admin" => false)); ?>",type: "GET",data: data,success: function (html) { $('#busy-indicator').hide(); basket.find("ul").append('<li id="' + move.attr("id") + '">'
					+ '<span class="name">' + move.find("h3").html() + '</span>'
					+ '<input name="chartname[chart'+move.attr("id")+']" value="'+cnt+'" type="hidden">'
					+ '<button class="delete">&#10005;</button>'+html);} });
			
		}


        // The function that is triggered once delete button is pressed
        $(".basket ul li button.delete").live("click", function () {
            $('#'+$(this).parent("li").attr('id')).show();
        	$(this).parent("li").remove();
		});

    });
    $(document).ready(function(){     
		$('.goBack').click(function(){         parent.history.back();         return false;     }); });
</script>