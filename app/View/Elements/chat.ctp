<style> 
input { font:12px arial; }

.top-bar {
  background: #666;
  position: relative;
  overflow: hidden; 
  height:25px;
  color:white;
  text-align: left;
  line-height:25px; 
  font-weight: bold;
  padding-left:5px;
}
  
.search-bar {
  margin-top: 1px;
  background: #666;
  position: relative;
  overflow: hidden; 
  height:26px;
  color:white;
  text-align: left;
  line-height:25px; 
  font-weight: bold;
  /*padding-left:5px;*/
}
.search-bar input{
    width:98%;
}
#chatbox { 
    right:0px; 
    bottom:0px;
    position:fixed;
    background:#fff;
    height:340px;
    width:250px;
    border:1px solid #ACD8F0; 
}

.chatDiv, .userDiv{
    width:100%;
    height:260px;
}

/*.userDiv{
    width:100%;
    height:100%;
}	*/

#user-chat{ 
    bottom:0px;
    right:260px; 
    position:fixed;
    background:#fff;
    height:340px;
    width:260px;
    border:1px solid #ACD8F0;
    overflow:auto; 
}

.users-content{
    overflow:overflow-x;
    overflow:auto; 
    bottom:0px;
    position:relative;
    background:#fff;
    border:1px solid #ACD8F0;
} 
 
table #userOnline tr
{
    font-weight: bold;
    text-decoration: none;
    line-height: 1.0em; 
    cursor: pointer;
}

#inputMsg{
	bottom:0px;
	position: fixed; 
	background-color:#edfdfb;
}
.close-popup{
	float: right;
	opacity: 0.5;
	padding-right:5px;
	color:#FFFFFF;
	cursor:pointer;
}

#user-chat form {
	padding: 10px;
}

#user-chat textarea {
	border: 1px solid #ccc;
	border-radius: 3px;
	padding: 8px;
	outline: none;
	width: 234px;
}

label{
	float: none !important;
} 

.bottom-bar { 
    background-color:#edfdfb;
    height:25px;
    color:white;
    text-align: left;
    line-height:25px; 
    font-weight: bold;
    padding-left:5px;
    position: fixed; 
    bottom:0%;  
    opacity: 1;
}

#disChatBox{
    bottom:0px;
    right:0px; 
    min-width:100px;
    background: #666;
    position: fixed;
    height:25px;
    color:white;
    text-align: left;
    line-height:25px; 
    font-weight: bold;
    padding-left:5px;
    cursor:pointer;
    border-top-left-radius: 9px;
    border-bottom-left-radius: 9px;
} 
.roundM {
    display: block;
    height: 25px;
    width: 25px;
    line-height: 25px;
	margin-right:5px;
    -moz-border-radius: 30px; /* or 50% */
    border-radius: 30px; /* or 50% */

    background-color: white;
    color: black;
    text-align: center;
    
}
</style> 

<div id="wrapper"> 
    <div id="user-chat" style="display: none;"> 
        <div class="top-bar" style="width:100%">
    		<span id="chatUserName"></span>
                <span class="close-popup" onclick="close_popup()">X</span> 
    		<input type="hidden" name="user_id" id="chat_user_id" value=''/>
    		<input type="hidden" name="chat_is_active" id="chat_is_Active" value=''/>
    	</div>
    	<div class="users-content userDiv"> 
            <table id="prevMsg" width="100%"></table>
            <div id="inputMsg">
                <table width="100%">
                    <td width=""><textarea rows="1" name="message" id="txtMsg" style="height: 30px !important; overflow:auto;resize:vertical;"></textarea></td>
<!--                            <td><button id="sendMsg">Send</button></td>-->
                    </table>
                </div>
    	</div>
    </div>
    
    <div id="chat-box-container">
	    <div id="chatbox" style="display:none">  
	    	<div class="top-bar">
	    		<span>Chatbox</span>
	    		<span class="close-popup" onclick="close_chatBox()">X</span>
	    		<span class="close-popup" onclick="minimize_chatBox()">&minus;</span>
	    	</div>
                <div class="search-bar">
                    <table width="100%">
                        <tr>
                            <td width="100%"><input type="text" name="searchChatTerm" id="searchChatTerm" placeholder="Search User"/></td> 
                        </tr>
                    </table>
                     
	    	</div>
	    	<div class="users-content chatDiv"> 
                    <div id="userOnline">
                        <table align="center" width="90%" id="userOnline" class="UserChatDetails">
                            <?php foreach($userDetails as $key=> $val){?>
                                 <tr onclick="openUserChat(<?php echo "'".$key."','".$val."'"; ?>)">
                                    <?php if(in_array($key, $loginedUser)) { $image = "green"; } else { $image = "red"; } ?>
                                    <td width="10%"><?php echo $this->Html->image('icons/bullet-'.$image.'.png',array('alt'=>'Online'));?></td>
                                    <td><?php echo $val; ?></td>
                                 </tr>
                            <?php } ?>
                        </table>
                    </div> 
	    	</div>
	    	<div class="bottom-bar">
    			<table align="center" width="90%">
	    			<tr>
	    				<td>
	    					<label><input type="radio" class="chatstatus" name="status" value="online" checked="checked">Online</label>
	    				</td>
	    				<td>
	    					<label><input type="radio" class="chatstatus" name="status" value="offline">Offline</label>
	    				</td>
	    				<td>
	    					<label><input type="radio" class="chatstatus" name="status" value="all">All</label>
	    				</td>
	    			</tr>
	    		</table>  
    		</div>
	    </div>
	    <div id="disChatBox" onclick="openChatBox()" style="display:none;">
	    	<div class="roundM" id="unreadCount" style="display:none; float:left;"></div>
    		<div style="display:block; float:right; padding-right:5px;">Open Chatbox</div> 
    	</div>
    </div>
 </div>
      

<script type="text/javascript">  
    
	$(document).ready(function(){
            getChatUsers('online'); 
	}); 
	
	var chatCounter = 0;
	$(".chatstatus").click(function(){
		var userStatus = this.value;
		getChatUsers(userStatus);
	});
	
	//close user chat
	function close_popup(){ 
            document.getElementById("user-chat").style.display = "none";
            clearInterval(chatInterval);
	}
	
	//close online user chatbox
	function close_chatBox(){ 
            document.getElementById("chat-box-container").style.display = "none";
	}
	
	//minimize chatbox
	function minimize_chatBox(){
            document.getElementById("chatbox").style.display = "none";
            document.getElementById("disChatBox").style.display = "block";
	}
	
	//open chatbox
	function openChatBox(){ 
            document.getElementById("chatbox").style.display = "block";
            document.getElementById("disChatBox").style.display = "none";
            //getChatUsers('online');
	}

	var chatInterval = '';
	function openUserChat(id,name,is_active){
		clearInterval(chatInterval);
		$("#user-chat").show();
		$("#chatUserName").text(name);
		$("#chat_user_id").val(id);
		$("#chat_is_Active").val(is_active);
		$("#prevMsg").html('');
		chatCounter = 20;
		//getChatReports();
		if(is_active == '1'){
			getChatReports();
			chatInterval = setInterval('getChatReports()', 2000); 
		}else{
			clearInterval(chatInterval);
			getChatReports();
		}
		return false;
		if(chatInterval!=''){
			clearInterval(chatInterval); 
			chatInterval = setInterval('getChatReports()', 2000);   
		}else{
			getChatReports();
			chatInterval = setInterval('getChatReports()', 2000);
		}
	}

       // $(document).on('keypress','#txtMsg',function(e){
        $('#txtMsg').keypress(function(e) {
            if (e.keyCode==13 && !e.shiftKey) {
                var msg = $("#txtMsg").val();
		var sendTo = $("#chat_user_id").val();
		if(msg != '' && sendTo != ''){
			$.ajax({
				type: "POST",
		        url: "<?php echo $this->Html->url(array("controller" => "Chats", "action" => "saveChats")); ?>"+'/'+sendTo,
		        data: 'msg='+msg,
		        beforeSend:function(){
		        	blurElement("#prevMsg", 2);
		        	//clearInterval(chatInterval); 
			    },
		        success: function(data){
		        	blurElement("#prevMsg", 0);
		        	getChatReports(); 
					//chatInterval = setInterval('getChatReports()', 2000);   
					$("#txtMsg").val('');       
		        }
			});
		}
                e.preventDefault(); 
            }
            
        });
        
	$("#sendMsg").click(function(){
		var msg = $("#txtMsg").val();
		var sendTo = $("#chat_user_id").val();
		if(msg != '' && sendTo != ''){
			$.ajax({
				type: "POST",
		        url: "<?php echo $this->Html->url(array("controller" => "Chats", "action" => "saveChats")); ?>"+'/'+sendTo,
		        data: 'msg='+msg,
		        beforeSend:function(){
		        	blurElement("#prevMsg", 2);
		        	//clearInterval(chatInterval); 
			    },
		        success: function(data){
		        	blurElement("#prevMsg", 0);
		        	getChatReports(); 
					//chatInterval = setInterval('getChatReports()', 2000);   
					$("#txtMsg").val('');       
		        }
			});
		}
	});

	function getChatReports(limitVal){
		var name = $("#chatUserName").text();
		var sendTo = $("#chat_user_id").val();
		var limit = '';
		if(limitVal != '' && limitVal != undefined){
			limit = limitVal;
			chatCounter = chatCounter+10;
		}
		
		$.ajax({
			type: "POST",
	        url: "<?php echo $this->Html->url(array("controller" => "Chats", "action" => "getChats")); ?>"+'/'+sendTo+'/'+limit,
	        beforeSend:function(){
	        	//blurElement("#prevMsg", 2);
		    },
	        success: function(data){
	        	blurElement("#prevMsg", 0);
		        var obj = $.parseJSON(data);
		        $("#prevMsg").html('');
		        var field = '';
		        var isNewMsg = 0;
		        if( obj.returnData != '' && obj.returnData != undefined ){
			        if(parseInt(obj.msgCount) > 10 && obj.msgCount > obj.returnData.length){
				        field += '<tr><td align="center" style="cursor:pointer;" onclick="getChatReports('+chatCounter+')"><i>Load Previous messages</i></td></tr>';
			        }else{
			        	field += '<tr><td align="center"><i>No more messages to load</i></td></tr>';
			        }
			        
			        $.each(obj.returnData, function(key, value){ 
			        	var addAlign = 'text-align:right';
				        var bgColor = 'background-color:#BBD4E4';
				        var seenStatus = '';
				        if(value.msg_sender != "me"){
				        	value.msg_sender = name;
					        var addAlign = 'text-align:left';
				        	var bgColor = 'background-color:#d8f5f3';
				        	if(value.is_received == "0" && isNewMsg == 0){
					        	field += '<tr><td align="center"><i>New Message</i></td></tr>';
					        	isNewMsg = 1; 
					        }
				        } else{
					        if(value.is_sent == "1"){
					        	seenStatus = " Sent";
					        }
					        if(value.is_received == "1"){
					        	seenStatus = " Seen";
					        } 
				        }
				        field += '<tr style="'+bgColor+'"><td style="'+addAlign+'"><div class="blog bag-ind">';
				        field += value.msg_sender+": "+value.msg+" </br><font style='font-size:10px;'>("+value.msg_date+")"+"<i>"+seenStatus+"</i></font>";
				        field += "</td></tr>";
				    });  
	        	}
			    $("#prevMsg").append(field);
	        }
		});
	}

	function getChatUsers(id){
		var userStatus = '';
		if(id != '' && id != undefined){
			userStatus = id;
		}
		$.ajax({
			type: "POST",
	        url: "<?php echo $this->Html->url(array("controller" => "Chats", "action" => "getUsers",'admin'=>false)); ?>"+'/'+userStatus,
	        beforeSend:function(){
	        	blurElement("#userOnline", 2);
		    },
	        success: function(data){ 
	        	blurElement("#userOnline", 0);
		        var userObj = $.parseJSON(data);
		        var field = '';
		        $("#userOnline").html('');
		    	field += '<table align="center" width="90%" id="userOnline" class="UserChatDetails">';
		        if(userObj.returnArr !='' && userObj.returnArr != undefined){
			        $.each(userObj.returnArr, function(key, value){  
				        var id = "'"+value.id+"'";
				        var name = "'"+value.name+"'";
				        var isActive = "'"+value.is_active+"'";
				        var onclick = "openUserChat("+id+","+name+","+isActive+")"; 
				        field += '<tr onclick="'+onclick+'">';
				        if(value.is_active == "1"){
					        field += '<td width="10%"><?php echo $this->Html->image("icons/bullet-green.png",array("alt"=>"Online", "title"=>"Online")); ?></td>';
				        }else{
				        	field += '<td width="10%"><?php echo $this->Html->image("icons/bullet-red.png",array("alt"=>"Offline", "title"=>"Offline")); ?></td>';
				        }
				        field += '<td>'+value.name+'</td>';
				        var unReadMsgCount = '';
				        if(value.msgUnread!='' && value.msgUnread!= undefined && value.msgUnread!='null'){
				        	unReadMsgCount = value.msgUnread;
				        } 
				        field += '<td><span class="roundMsg">'+unReadMsgCount+'</span></td>';
				        field += '</tr>';
			        });
	        	}else{
		        	field += '<tr><td colspan="2" align="center">No User found..!!"</td></tr>';
	        	}
				field += '</table>';
			    $("#userOnline").append(field);
			    if(userObj.totalUnreadMsg !='' && userObj.totalUnreadMsg != undefined && parseInt(userObj.totalUnreadMsg)>0){
				    $("#unreadCount").show();
				    $("#unreadCount").html(userObj.totalUnreadMsg);
                                    titleScroller(userObj.totalUnreadMsg + " new message "); 
			    }
			    if($('#chatbox').css('display') == 'none')
			    {
				    document.getElementById("disChatBox").style.display = "block";
			    }
	        }
		});
	}

	//to blur the content by swapnil on 10.09.2015
	function blurElement(element, size){
        var filterVal = 'blur('+size+'px)';
        $(element)
          .css('filter',filterVal)
          .css('webkitFilter',filterVal)
          .css('mozFilter',filterVal)
          .css('oFilter',filterVal)
          .css('msFilter',filterVal);
    }
     
    //$(document).on('keyup', '#searchChatTerm', function () { 
    $('#searchChatTerm').keyup( function() {
        var $rows = $('.UserChatDetails tr');
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        $rows.show().filter(function () {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    }); 
    
    function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 200);
    };
</script>