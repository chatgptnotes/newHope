<?php 
echo $this->Html->css(array('jquery.booklet.latest.css'));
echo $this->Html->script(array('jquery.booklet.latest','jquery.booklet.latest.min','jquery.easing.1.3'));
?>
<link href="../booklet/jquery.booklet.latest.css" type="text/css" rel="stylesheet" media="screen, projection, tv" />
<div id="mybook">
	        <div title="first page" rel="first chapter">
	            <h3>1 jQuery Booklet</h3>
	            <p>This is a sample booklet! It uses all of the default options, but feel free to explore all the possibilities in the <a href="options">options</a> section.</p>
	            <h3>Content Variety</h3>
	            <p>You can place any sort of html elements inside of your booklet pages. There is no limit to the possibilities you can create. Even using simple options, you can have elaborate displays.</p>
	        </div>
	        <div title="second page">
	            <h3>2 Default Options</h3>
	            <p>The default options include:</p>
	            <ul>
	                <li><h4>Manual Page Turning</h4>This option requires jQuery UI, but will degrade and be usable if not included.</li>
	                <li><h4>Keyboard Navigation (use your arrows!)</h4></li>
	                <li><h4>Page Numbers</h4></li>
	                <li><h4>Shadows (during animation)</h4></li>
	            </ul>
	            <p>Move to the next page by dragging or the arrow keys to see the animation in action!</p>
	        </div>
	        <div title="third page">
	            <h3>3 Huzzah!</h3>
	            <p>That awesome page turning animation was made possible by jQuery. Pretty cool, huh?</p>
	            <h3>What's Next?</h3>
	            <ul>
	                <li><a href="options">View the Options Reference</a></li>
	                <li><a href="examples/">View Examples</a></li>
	                <li><a href="installation">View Installation Instructions</a></li>
	                <li>Download below!</li>
	            </ul>
	        </div>
	        <div title="fourth page">
	            <h3>4 jQuery Booklet</h3>
	            <p>This is a sample booklet! It uses all of the default options, but feel free to explore all the possibilities in the <a href="options">options</a> section.</p>
	            <h3>Content Variety</h3>
	            <p>You can place any sort of html elements inside of your booklet pages. There is no limit to the possibilities you can create. Even using simple options, you can have elaborate displays.</p>
	        </div>
	        <div title="fifth page" rel="second chapter">
	            <h3>5 jQuery Booklet</h3>
	            <p>This is a sample booklet! It uses all of the default options, but feel free to explore all the possibilities in the <a href="options">options</a> section.</p>
	            <h3>Content Variety</h3>
	            <p>You can place any sort of html elements inside of your booklet pages. There is no limit to the possibilities you can create. Even using simple options, you can have elaborate displays.</p>
	        </div>
	        <div title="sixth page">
	            <h3>6 Default Options</h3>
	            <p>The default options include:</p>
	            <ul>
	                <li><h4>Manual Page Turning</h4>This option requires jQuery UI, but will degrade and be usable if not included.</li>
	                <li><h4>Keyboard Navigation (use your arrows!)</h4></li>
	                <li><h4>Page Numbers</h4></li>
	                <li><h4>Shadows (during animation)</h4></li>
	            </ul>
	            <p>Move to the next page by dragging or the arrow keys to see the animation in action!</p>
	        </div>
	        <div title="seventh page">
	            <h3>7 Huzzah!</h3>
	            <p>That awesome page turning animation was made possible by jQuery. Pretty cool, huh?</p>
	            <h3>What's Next?</h3>
	            <ul>
	                <li><a href="options">View the Options Reference</a></li>
	                <li><a href="examples/">View Examples</a></li>
	                <li><a href="installation">View Installation Instructions</a></li>
	                <li>Download below!</li>
	            </ul>
	        </div>
	        <div title="eighth page">
	            <h3>8 jQuery Booklet</h3>
	            <p>This is a sample booklet! It uses all of the default options, but feel free to explore all the possibilities in the <a href="options">options</a> section.</p>
	            <h3>Content Variety</h3>
	            <p>You can place any sort of html elements inside of your booklet pages. There is no limit to the possibilities you can create. Even using simple options, you can have elaborate displays.</p>
	        </div>
	    </div>
	    
	    <script type="text/javascript">
	    $(function () {
		
			// Init
			
			var updateSelect = function (event, data) {
				var pageTotal = data.options.pageTotal;
				$('#gotoIndex, #addIndex, #removeIndex').children().remove();
				$('#gotoIndex, #addIndex, #removeIndex').append('<option value="start">start</option><option value="end">end</option>');						
				for(i = 0; i < pageTotal; i++) {
					$('#gotoIndex, #addIndex, #removeIndex').append('<option value="'+ i +'">'+ i +'</option>');						
				}
			};
			
			var options = $.extend({}, $.fn.booklet.defaults, {
			    pagePadding: 15,
			    menu: "#menu",
			    width:'100%',
			    pageSelector: true,
			    chapterSelector: true,
			    arrows: true,
			    tabs: true,
                arrowsHide:true,
                speed:1000,
                closed:true,
                hovers: true,
                manual: true
			});
			var updateOptions = function () {
				$('#options-list').children().remove();
				$.each(options, function(key, value){
					$('#options-list').append('<li>'+key+' <input value="'+value+'" id="option-'+key+'" /></li>');
					$('#option-'+key).on('change', function(e){
						e.preventDefault();
						var value = $(this).val();
						var intValue = parseInt(value);
						
						if(!isNaN(intValue)) {
							options[key] = intValue;
							return;
						}

						options[key] = value;
					});
				});
			};
			updateOptions();
			
			var config = $.extend({}, options, {
				create: updateSelect,
				add: updateSelect,
				remove: updateSelect
			});
	        var mybook = $("#mybook").booklet(config);
	
			$('#gotoIndex').on('change', function(e){
				e.preventDefault();
				$('#custom-gotopage').click();
			});
	
			// New Page Default HTML
	
			var newPageCount = 0;
	        var newPageHtml = function() {
				newPageCount++;
				return "<div rel='new chapter'>New Page \#"+newPageCount+"</div>";
			};
			
			
			// Display
			
	        var display = $("#display");
			var updateDisplay = function(message) {
				display.text(message + '\r\n' + display.text());
			};
	
			// Demo Actions
	
	        $('#custom-destroy').click(function (e) {
	            e.preventDefault();
	            $("#mybook").booklet("destroy");
	            updateDisplay('$("#mybook").booklet("destroy")');
	        });

	        $('#custom-create').click(function (e) {
	            e.preventDefault();
	            $("#mybook").booklet(config);
	            updateDisplay('$("#mybook").booklet();');
	        });

	        $('#custom-disable').click(function (e) {
	            e.preventDefault();
	            $("#mybook").booklet("disable");
	            updateDisplay('$("#mybook").booklet("disable")');
	        });

	        $('#custom-enable').click(function (e) {
	            e.preventDefault();
	            $("#mybook").booklet("enable");
	            updateDisplay('$("#mybook").booklet("enable")');
	        });

	        $('#custom-next').click(function (e) {
	            e.preventDefault();
	            $("#mybook").booklet("next");
				updateDisplay('$("#mybook").booklet("next");');
	        });

	        $('#custom-prev').click(function (e) {
	            e.preventDefault();
	            $("#mybook").booklet("prev");
				updateDisplay('$("#mybook").booklet("prev");');
	        });

	        $('#custom-gotopage').click(function (e) {
	            e.preventDefault();
				var index = $('#gotoIndex').val();
	            $("#mybook").booklet("gotopage", index);
				updateDisplay('$("#mybook").booklet("gotopage", '+(index == "start" || index == "end" ? '"'+index+'"' : index)+');');
	        });

	        $('#custom-add-index').click(function (e) {
	            e.preventDefault();
				var newPage = newPageHtml();
				var index = $('#addIndex').val();
	            $("#mybook").booklet("add", index, newPage);
				updateDisplay('$("#mybook").booklet("add", '+ (index == "start" || index == "end" ? '"'+index+'"' : index) +', "'+ new String(newPage) +'");');
	        });
	
	        $('#custom-remove-index').click(function (e) {
	            e.preventDefault();
				var index = $('#removeIndex').val();
	            $("#mybook").booklet("remove", index);
				updateDisplay('$("#mybook").booklet("remove", '+ (index == "start" || index == "end" ? '"'+index+'"' : index) +');');
	        });

	        $('#custom-update-options').click(function (e) {
	            e.preventDefault();
				$("#mybook").booklet("option", options);
				updateDisplay('$("#mybook").booklet("option", '+ options +');');
	        });
	
	        $('#custom-reset-options').click(function (e) {
	            e.preventDefault();
				$("#mybook").booklet("option", config);
				updateDisplay('$("#mybook").booklet("option", '+ options +');');
				updateOptions();
	        });

	    });
    </script>