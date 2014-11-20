/*******************************************************************************
 * Created by: shlomo hassid.
 * Release Version : 3.0
 * Creation Date: 14/08/2013
 * Updated To V.2.X : 05/01/2014
 * Updated To V.3.0 : 14/08/2014
 * Mail: Shlomohassid@gmail.com
 * require: jquery latest ( best: 10.1 ) version SQL 4+ PHP 5.3+ .	
 * Copyright 2014, shlomo hassid.
*******************************************************************************/
$(document).ready(function() {	

//USERS:
    
    //Log-in for users:
    $('a#logMeIn').click(function() {
        window.location.href = "index.php?user";
    });
    
    //Log-out for users:
    $('a#logMeout').click(function() {
        window.location.href = "index.php?logout";
    });

//GENERAL:
    var logmebehave = '';
    //Behavior:
    $('.hoverfile').mouseenter(function(){ logmebehave += $(this).attr('grab');  });
    $('#but1sub').mouseenter(function(){ logmebehave += $(this).attr('grab'); });
    $('.outerConatainer').mouseenter(function(){ logmebehave += $(this).attr('grab'); });
    $('.graber').mouseenter(function(){ logmebehave += $(this).attr('grab'); });
    
    //Custom file picker:
    $(document).on('click','.hoverfile',function (eve) {
        eve.preventDefault();
        $(this).closest('table').prev('input').click();
        return false;
    });
    
    //Set selected file name:
    $(document).on('change','.file',function () {
        $(this).next('table').find('.tempShowfiler').val($(this).val().substring($(this).val().lastIndexOf("\\")+1));
    });	
	
    //Clear file:
    $(document).on('click','.clear_file',function() {
        var curfile = $(this).parent('td').parent('tr').find('input.file');
        if ($(curfile).val() != '') {
            curfile.replaceWith( curfile = curfile.clone( true ) );
            $(curfile).next('table').find('.tempShowfiler').val("");
        } else if ( $(curfile).attr('id').substr(4)!== "1" ) {
            $(curfile).parent('td').parent('tr').remove();
        }
        if( window.FormData !== undefined ) {
            //Size calc:
            curSizeFiles = sumsizes();
            if (curSizeFiles!='nofiles'){
                    $('#sizeclac').text(curSizeFiles);
            }
            else { $('#sizeclac').text(''); }
        }
    });

    //Add file:
    $('#add_file').click(function() {
        var takenNames = [];
        $('.file').each(function(){ takenNames.push($(this).attr('name')); });
        if ( takenNames.length < maxfiles ) {
            for(var i=1; i<maxfiles+1; i++){
                var newname = 'file'+(i+1);
                if ( $.inArray(newname,takenNames) < 0 ) {
                    $(this).parent('td').parent('tr').prev('tr').after(
                        "<tr><td>"
                        + "<input class='file' type='file' name='"+ newname +"' id='"+ newname +"' accept='"+ accept_file_types +"' style='display:none;' />"
                        + "<table border='0' cellpadding='0' cellspacing='0' style='border:0; padding:0; margin:0;'>"
                        + "<tr><td style='width: 80px;'><a href='#' type='button' class='hoverfile button facebook' grab='top1-' >" + browse_button_text + "</a>"
                        + "</td><td style='padding-right:5px;'><input class='tempShowfiler' type='text' name='tempShowfiler' id='tempShowfiler' placeholder='"+ placeholder_files_field +"' readonly />"
                        + "</td></tr></table>"          
                        + "</td><td width='30px'>"
                        + "<div class='clear_file' id='clear_file'>&#10006;</div>"
                        + "</td><td  width='40px'>"
                        + "<div id='showerror"+(i+1)+"' class='showerror' style='display:none; padding-top:4px;'><img src='img/glyphicons/png/1error.png' width='18px' height='18px' /></div>"
                        + "</td></tr>"
                    );
                    break;
                }
            }
        } else { $(this).next('div').find('div.maximum_reach').eq(0).fadeIn('fast').delay(1000).fadeOut('fast'); }
    });
	
    //Append sizes: 
    $(document).on('change',':file',function(){
        if( window.FormData !== undefined ) {
            curSizeFiles = sumsizes();
            if ( curSizeFiles != 'nofiles' ){
                $('#sizeclac').text(curSizeFiles);
            }
        }
    });
	
    //Clear recipients:
    $(document).on('click','.clear_to',function(){
        var curto = $(this).parent('td').parent('tr').find('input');
        if ( $(curto).val() != '' ) { $(curto).val(''); }
        else if( $(curto).attr('id').substr(6)!== "1" ) {
            $(curto).parent('td').parent('tr').remove(); }
    });
	
    //Add recipients:
    $('#add_to').click(function() {
        var takenNames_to = [];
        $('.recipients').each(function(){ takenNames_to.push($(this).attr('name')); });
        if ( takenNames_to.length < maxrecipients ) {
            for( var i=1; i < maxrecipients+1; i++ ) {
                var newname_to = 'sendto' + (i+1);
                if ( $.inArray(newname_to,takenNames_to) < 0 ) {
                    $(this).parent('td').parent('tr').prev('tr').after(
                          "<tr><td><input class='recipients' type='text' name='"+ newname_to +"' id='"+ newname_to +"' placeholder='"+ placeholder_recipients_field
                        + "' /></td><td><div class='clear_to' id='clear_to'>&#10006;</div></td><td><div id='showerror_to"+(i+1)+"' class='showerror' style='display:none; padding-top:4px;'>"
                        + "<img src='img/glyphicons/png/1error.png' width='18px' height='18px' /></div></td></tr>"
                    );
                    break;
                }
            }
        } else { $(this).next('div').find('div.maximum_reach').eq(0).fadeIn('fast').delay(1000).fadeOut('fast'); }
    });

    //Now the Ajax submit with the button's click: for ie older and for all browsers
    var timerBar;
    $('#but1sub').click(function(){ 
        //Submit:
        $('.showerror').fadeOut("fast");
        $('#conMessageReturn').slideUp(350,function(){ $(this).empty(); });
        $('#conMessageDone').slideUp(350,function(){ $(this).empty(); });
        
        //Validate:
        if (!$('.userAccountDisplay').length ) {
            if (!beforeSend_gen()) { return; }
        } else {
            if (!beforeSend_use()) { return; }
        }
        
        if( window.FormData !== undefined ) {
        //Make sure that we can use FormData ie>9, chrome > 7, opera > 12 safari >5, android > 3 gecko mobile > 2, opera mobile >12 <- will support XHR too
        //Append progress bar:
            if ($('#progCon').length < 1) $('#prog_mes').append("<div id='progCon' style='display:none;'><progress  class='porg1' id='prog1' max='100' value='0'><div class='prog1text'>"+ progress_bar_fallback +"</div></progress></div>"); 
            else { $('#prog1').val(0); }

            var formData = new FormData($('form#takethatform')[0]);
                formData.append("be",logmebehave);
                formData.append("ajaxsub",logmebehave);
                
            $.ajax({
                url: 'code/client/filesend.php',  //Server script to process data
                type: 'POST',
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload) { // Check if upload property exists
                        myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },
                //Ajax events
                beforeSend: function() {
                    clearTimeout(timerBar);
                    if(logmebehave.length > 120) { logmebehave = logmebehave.substring(0,60); }
                    $('#progCon').fadeIn(200);	
                },
                success: function(response) {
                    //console.log(response);
                    if (response.substring(0,4)=='val[') {
                        var obj = $.parseJSON(response.substring(3));
                        var noticeString = "<img src='img/glyphicons/png/glyphicons_052_eye_close.png' class='hide_errors' />";
                        for(var i=0; i<obj.length; i++) {
                            switch(obj[i].substring(0,9)) {
                                case 'File1': 
                                                noticeString += "&bull;&nbsp;"+ validation_mis_file_select +"<br />";
                                                $('#showerror1').fadeIn("fast");
                                                break;
                                case 'tosend1': 
                                                noticeString += "&bull;&nbsp;"+ validation_mis_recipient_select +"<br />";
                                                $('#showerror_to1').fadeIn("fast");
                                                break;
                                case 'fromsend1':
                                                noticeString += "&bull;&nbsp;" + validation_mis_sender_select + "<br />";
                                                $('#showerrorfromsend').fadeIn("fast");
                                                break;
                                case 'tosendem-': 
                                                noticeString += "&bull;&nbsp;" + validation_invalid_recipient + "<br />";
                                                $('#showerror_to'+obj[i].substring(15)).fadeIn("fast");
                                                break;
                                case 'fromsend2':
                                                noticeString += "&bull;&nbsp;" + validation_invalid_sender + "<br />";
                                                $('#showerrorfromsend').fadeIn("fast");
                                                break;
                                case 'filetype-': 
                                                noticeString += "&bull;&nbsp;" + validation_unauthorized_file_type + "<br />";
                                                $('#showerror'+obj[i].substring(13)).fadeIn("fast");
                                                break;																
                                case 'filesize-': 
                                                noticeString += "&bull;&nbsp;" + validation_unauthorized_file_size + "<br />";
                                                $('#showerror'+obj[i].substring(13)).fadeIn("fast");
                                                break;
                            }
                        }
                        
                        setTimeout(function(){ $('#conMessageReturn').html(noticeString).slideDown(500); },500);
                        
                    } else if (response.substring(0,3)=='ok[') {													
                        $('#fromsend').val('');
                        $('.recipients').val('');
                        setTimeout(function(){ $('#conMessageDone').html("<img src=\"img/glyphicons/png/glyphicons_052_eye_close.png\" class=\"hide_done\" width=\"16px\" height=\"14px\" />&bull;&nbsp;" + validation_file_sent_done).slideDown(500); },500);
                    } else if (response.substring(0,3)=='deb') {
                        var obj = $.parseJSON(response.substring(3));
                        var noticeString = "<img src='img/glyphicons/png/glyphicons_052_eye_close.png' class='hide_errors' />" + error_header_message + "<br />";
                        for(var i=0; i<obj.length; i++) {
                            switch(obj[i].substring(0,6)) {
                                    case 'upload':  
                                    case 'logfil':
                                    case 'logapp': noticeString += "&bull;&nbsp;" + validation_server_file_cant_send1 +(obj[i].substring(6)) + validation_server_file_cant_send2 +"<br />"; break;
                                    case 'mailre': noticeString += "&bull;&nbsp;" + validation_server_rec_not_send1 +(obj[i].substring(6)) + validation_server_rec_not_send2 + "<br />"; break;
                                    case 'mailco': noticeString +=  "&bull;&nbsp;" + error_copy_send + "<br />"; break;
                            }
                        }
                        noticeString += error_admin_footer + "<br />";

                        setTimeout(function(){ $('#conMessageReturn').html(noticeString).slideDown(500); },500);
                    } else if (response.substring(0,3)=='die') {
                        console.log(response);
                        setTimeout(function(){ $('#conMessageReturn').html(error_critical_cookies).slideDown(500); },500);
                    } else if (response.substring(0,3)=='blo') {
                        console.log(response);
                        setTimeout(function(){ $('#conMessageReturn').html(error_blocked_user).slideDown(500); },500);
                    } else if (response.substring(0,3)=='hum') {
                        console.log(response);
                        setTimeout(function(){ $('#conMessageReturn').html(validation_human_detection_behavior).slideDown(500); },500);
                    } else if (response.substring(0,3)=='log') {
                        console.log(response);
                        window.location.reload();
                    } else {
                        console.log(response);
                        setTimeout(function(){ $('#conMessageReturn').html(error_unknown_critical).slideDown(500); },500);
                    }

                    timerBar = setTimeout(function(){ $('#progCon').slideUp(300); },5000);
                },
                error: function(xhr, ajaxOptions, thrownError){
                    console.log(thrownError);
                    setTimeout(function(){ $('#conMessageReturn').html(error_unknown_critical).slideDown(500); },500);
                },
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
            });
        } else {
            setTimeout(function(){ $('#conMessageReturn').html(old_browser_notice).slideDown(500); },500);
        }
    });
	
    //Go home:
    $('input.home_but1').click(function(){
        var locationGo = document.URL.split('?');
        window.location = locationGo[0];
    });

    //Hide errors:
    $(document).on('click','.hide_errors',function(){ $(this).parent('div#conMessageReturn').slideUp('slow'); });

    //Hide done message:
    $(document).on('click','.hide_done',function(){ $(this).parent('div#conMessageDone').slideUp('slow'); });
	
    //Banner count clicks:
    $('#banner_click').click(function(){
            var bannerId = $(this).attr('bannerId');
            var inputs = { what:"counter_banner_click", user_token:$('input#get').val(), banner_id:bannerId };
            $.ajax({ type: "POST", url: "code/lib/counters.php", dataType: 'html', data: inputs }); 
    });
	
});	

/****************************  Functions:  ************************************/
function beforeSend_gen() {
    
    var noticeString = "<img src='img/glyphicons/png/glyphicons_052_eye_close.png' class='hide_errors' />";
    var finall = false;
    
    //Valid files:
    var filesS = validFile();

    //Valid from:
    var from_found = false;
    var from_error = false; 
    sender = $('#fromsend').val();
    if ( sender != "" ) {
        if (!validateEmail(sender)) {
                noticeString += "&bull;&nbsp;" + validation_sender_notgood + "<br />";
                $('#showerrorfromsend').fadeIn("fast");
                from_error = true;
        } else { from_found = true; }
    }    
    
    //Valid recipients:
    var rec_found = false;
    var rec_error = false; 
    $('.recipients').each(function(){
        if ( $(this).val() != "" ) {
            if (!validateEmail($(this).val())) {
                noticeString += "&bull;&nbsp;" + validation_recipient_notgood_1 + " " + $(this).attr('id').substring(6) + " " + validation_recipient_notgood_2 + "<br />";
                $('#showerror_to'+ $(this).attr('id').substring(6)).fadeIn("fast");
                rec_error = true;
            } else { rec_found = true; }
        }
    });
    
    //Check last:
    if ( filesS != "" ) noticeString += filesS;
    if ( !rec_found && !rec_error ) { $('#showerror_to1').fadeIn("fast"); noticeString += "&bull;&nbsp;" + validation_recipient_forgot + "<br />"; }
    if ( !from_found && !from_error ) { $('#showerrorfromsend').fadeIn("fast"); noticeString += "&bull;&nbsp;" + validation_sender_forgot + "<br />"; }
    
    if ( rec_found && !rec_error && from_found && !from_error && filesS == "" ) finall = true;
    else setTimeout(function() { $('#conMessageReturn').html(noticeString).slideDown(500); }, 500);
    
    return finall;
}

function beforeSend_use() {

    var noticeString = "<img src='img/glyphicons/png/glyphicons_052_eye_close.png' class='hide_errors' />";
    var finall = false;
    
    //Valid files:
    var filesS = validFile();
    
    //Valid recipients:
    var rec_found = false;
    var rec_error = false; 
    $('.recipients').each(function(){
        if ( $(this).val() != "" ) {
            if ( !validateEmail( $(this).val() ) ) {
                noticeString += "&bull;&nbsp;" + validation_recipient_notgood_1 + " " + $(this).attr('id').substring(6) + " " + validation_recipient_notgood_2 + "<br />";
                $('#showerror_to'+ $(this).attr('id').substring(6)).fadeIn("fast");
                rec_error = true;
            } else { rec_found = true; }
        }
    });
    
    //Check last:
    if ( filesS != "" ) noticeString += filesS;
    if ( !rec_found && !rec_error ) { $('#showerror_to1').fadeIn("fast"); noticeString += "&bull;&nbsp;" + validation_recipient_forgot + "<br />"; }
    
    if ( rec_found && !rec_error && filesS == "" ) finall = true;
    else setTimeout(function() { $('#conMessageReturn').html(noticeString).slideDown(500); }, 500);
    
    return finall;
}

function validateEmail(email) { 
    var re = /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return re.test(email);
}

function validFile() {
    var err = "";
    var found = false;
    $('.file').each(function(){
        if ( typeof this.files[0]!='undefined' && typeof this.files[0].size!='undefined' && typeof this.files[0].name!='undefined' ) {
            //console.log(this.files[0]);
            //Prepare:
            found = true;
            type = getExt(this.files[0].name);
            type = type.toLowerCase();
            //Validate size:
            if ( this.files[0].size > maxSize ) {
                $('#showerror' + $(this).attr('id').substring(4)).fadeIn("fast");
                err += "&bull;&nbsp;" + validation_file_notgood_1 + "("+ $(this).attr('id').substring(4) +") " + validation_file_notgood_2 + " (" + getBytesWithUnit(maxSize) + ").<br />";
            }
            //Validate type:
            if ( accept_file_types.indexOf(type) == -1 || type == "") {
                $('#showerror' + $(this).attr('id').substring(4)).fadeIn("fast");
                err += "&bull;&nbsp;" + validation_file_notgood_1 + "("+ $(this).attr('id').substring(4) +") " + validation_file_notgood_3 + "<br />";
            }
        }
    });
    
    if (!found) {
        $('#showerror1').fadeIn("fast");
        return "&bull;&nbsp;" + validation_file_forgot + "<br />";
    }
    return err;
}

function getExt(filename) {
    var ext = filename.split('.').pop();
    if ( ext == filename ) return "";
    return ext;
}

function sumsizes() {
    var sumSize = 0;
    $('.file').each(function() {
        if ( typeof this.files[0]!='undefined' ) sumSize += this.files[0].size;
    });
    if ( sumSize > 0 ) {
        return getBytesWithUnit(sumSize);
    } else {
        return 'nofiles';
    }
}

function progressHandlingFunction(e) {
    if ( e.lengthComputable ) {
        $('progress').attr({value:e.loaded,max:e.total});
    }
}

var getBytesWithUnit = function( bytes ) {
	if ( isNaN( bytes ) ){ return; }
	var units = [ ' bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB' ];
	var amountOf2s = Math.floor( Math.log( +bytes )/Math.log(2) );
	if( amountOf2s < 1 ){
		amountOf2s = 0;
	}
	var i = Math.floor( amountOf2s / 10 );
	bytes = +bytes / Math.pow( 2, 10*i );
 
	// Rounds to 3 decimals places.
        if( bytes.toString().length > bytes.toFixed(3).toString().length ){
            bytes = bytes.toFixed(3);
        }
	return Math.round(bytes)+units[i];
};
