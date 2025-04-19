(function($) {
    var defaults = {
        url : null,
        totalRecordCount : null,
        offset : null,
        success : null,
        complete :null,
        error :null,
        divToScroll:window,
        beforeSend : null ,/* set false to disable*/
    };
    var requiredOptions = new Array('url','totalRecordCount','offset','success');
    var settings;
    var prevHeight=0 ; 
    var methods = {
        /*
         * like a constructor call once plugin is initialized
         */
        init : function(options) {
            settings =  methods.saveOptions(options);
            methods._initPaging(options);
        },
        _initPaging: function(options){
            var offset  = options.offset ;
             $(options.divToScroll).scroll(function(options){
            	 
            	
                  if(settings.totalRecordCount >= settings.offset)
                   {   var targetId = $(settings.divToScroll);
                   		//applyPaging = $(targetId).scrollTop() >= $(targetId).height() - 300;
                   		 
                   		applyPaging = $(this).scrollTop() >= /*$(this).prev().height() -*/ prevHeight+$(this).height();
                   		
                        if(applyPaging)
                        { 
                        	 	 
                        	prevHeight = $(this).scrollTop()+$(this).height(); 
                        	
                            if(settings.data == null || settings.data == ''){
                                data = 'offset='+settings.offset
                            }else{
                                 data = settings.data+'&offset='+settings.offset
                            }
                            settings.offset;
                            $.ajaxq('scrollpaging',{url:settings.url,
                                                    data :data,
                                                    type : (settings.type)?settings.type:'GET',
                                                    beforeSend :function(){
                                                        if($.isFunction(settings.beforeSend)){
                                                           settings.beforeSend();
                                                        }
                                                    },
                                                    success: function(data){
                                                           if($.isFunction(settings.success)){
                                                           settings.success(data);
                                                        }
                                                    },
                                                    complete: function(data){
                                                           if($.isFunction(settings.complete)){
                                                           settings.complete(data);
                                                        }
                                                    },
                                                    error : function(e){
                                                        if($.isFunction(settings.error)){
                                                           settings.error(e);
                                                        } 
                                                    }
                                           });
                             
                              settings.offset = settings.offset + offset;
                        }
                    }
             });
        },
        /*
         * save settings in element data
         * @params : object element,object settings
         */
        saveOptions : function(options) {
           // console.log(requiredOptions);
            for(i in options){
                /*console.log(i + ':'+$.inArray(i,requiredOptions));
                if($.inArray(i,requiredOptions) >=0 && options[i]==null){
                    alert(i  + ' cant be null'); 
                    $.error(i  + ' cant be null');
                    return false;
                }*/
            }
            settings = $.extend({}, defaults, options || {});
            $(document).data('settings', settings);
            return settings;
        }, 
    }

    $.fn.scrollPaging = function(options) {
        
        if ( typeof options != 'object') {
            alert("Please follow the below standard to apply this plugin \n $('#file').scrollPaging({url:'url of the file',data:'params',totalCount:count,offset:offset});");
        }else{
            methods.init(options);
        }
  }

})(jQuery);

jQuery.ajaxq=function(e,t){if(typeof document.ajaxq=="undefined")document.ajaxq={q:{},r:null};if(typeof document.ajaxq.q[e]=="undefined")document.ajaxq.q[e]=[];if(typeof t!="undefined"){var n={};for(var r in t)n[r]=t[r];t=n;var i=t.complete;t.complete=function(t,n){document.ajaxq.q[e].shift();document.ajaxq.r=null;if(i)i(t,n);if(document.ajaxq.q[e].length>0)document.ajaxq.r=jQuery.ajax(document.ajaxq.q[e][0])};document.ajaxq.q[e].push(t);if(document.ajaxq.q[e].length==1)document.ajaxq.r=jQuery.ajax(t)}else{if(document.ajaxq.r){document.ajaxq.r.abort();document.ajaxq.r=null}document.ajaxq.q[e]=[]}}

