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

    //Refresh icons:
    $('.refresh_tab').click(function() {
        switch ( $(this).attr('posRe') ) {
            case '1': window.location.href="admin.php?pager=1"; break;
            case '2': window.location.href="admin.php?pager=2"; break;
            case '3': window.location.href="admin.php?pager=3"; break;
            case '4': window.location.href="admin.php?pager=4"; break;
            case '5': window.location.href="admin.php?pager=5"; break;
            case '6': window.location.href="admin.php?pager=6"; break;
            case '7': window.location.href="admin.php?pager=7"; break;
            case '8': window.location.href="admin.php?pager=8"; break;
            case '9': window.location.href="admin.php?pager=9"; break;
            default: window.location.href="admin.php?pager=1";  break;
        }
    });
        
    //Logout button:
    $('#but1out').click(function(){ window.location = "admin.php?logout"; });
		
    //Tab button:		
    $('.tab_select').click(function(){ 
        var pager = $(this).attr('id'); 
        
        //hide updater if visible:
        hide_ads_update();
        $('.tab_page').css({'z-index':'2'}); 
        $('#page_' + pager).css({'z-index':'4'}); 
        //parse url:
        if (history.pushState) {
            var numberPos = $(this).attr('tabNum');
            var q = queryString.parse(location.search);
            //console.log(q);
            q['pager'] = numberPos;
            newHistory = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + queryString.stringify(q);
            window.history.pushState({path:newHistory},'',newHistory);
        }
    });

    //General Settings:
    $('.button_save_ge').click(function(){
        
        //Hide Previous errors:
        $('div.error_page_ge').slideUp('fast');
        
        //Set:
        var object_ge_error = $(this).closest('tr').next('tr').find('div.error_page_ge').eq(0);
        var inputs = { 
            what_save: $(this).attr('id'),
            user_token: $('input#get').val()
        };
        
        //Post variables extend:
        switch(inputs.what_save){
            
            //Set theme:
            case 'theme_s':
                inputs["theme_selected"] = $('select#theme_select').val();
            break;
            //Set pass:
            case 'admin_change':
                inputs["userName"] = $('input#general_userName').val();
                inputs["userPass"] = $('input#general_userPass').val();
                object_ge_error = $(this).closest('tr').next('tr').next('tr').find('div.error_page_ge').eq(0);
            break; 
            //Set brand:
            case 'brand_s':
                inputs["brand_name_ge"] = $('input#general_brand').val();
            break;
            //Set sofar display:
            case 'sofar_s':                
                inputs["sofar_select_ge"] = $('select#sofar_select').val();
            break;
            //Set max files:
            case 'max_files_s':
                inputs["max_files_ge"] = $('input#general_max_files').val();					
            break;
            //Set max file size:
            case 'max_size_s':
                inputs["max_size_ge"] = $('input#general_max_file_size').val();
                inputs["max_size_num_files"] = $('input#general_max_files').val();
            break;
            //Set types:
            case 'types_s':
                inputs["Text"] = $('input#1').is(':checked');
                inputs["Data"] = $('input#2').is(':checked');
                inputs["Audio"] = $('input#3').is(':checked');
                inputs["Video"] = $('input#4').is(':checked');
                inputs["eBook"] = $('input#5').is(':checked');
                inputs["image3d"] = $('input#6').is(':checked');
                inputs["Raster"] = $('input#7').is(':checked');
                inputs["Vector"] = $('input#8').is(':checked');
                inputs["Camera"] = $('input#9').is(':checked');
                inputs["Layout"] = $('input#10').is(':checked');
                inputs["Spreadsheet"] = $('input#11').is(':checked');
                inputs["Database"] = $('input#12').is(':checked');
                inputs["Executable"] = $('input#13').is(':checked');
                inputs["Game"] = $('input#14').is(':checked');
                inputs["CAD"] = $('input#15').is(':checked');
                inputs["GIS"] = $('input#16').is(':checked');
                inputs["Web"] = $('input#17').is(':checked');
                inputs["Plugin"] = $('input#18').is(':checked');
                inputs["Font"] = $('input#19').is(':checked');
                inputs["System"] = $('input#20').is(':checked');
                inputs["Settings"] = $('input#21').is(':checked');
                inputs["Encoded"] = $('input#22').is(':checked');
                inputs["Compressed"] = $('input#23').is(':checked');
                inputs["Disk"] = $('input#24').is(':checked');
                inputs["Developer"] = $('input#25').is(':checked');
                inputs["Backup"] = $('input#26').is(':checked');
                inputs["Misc"] = $('input#27').is(':checked');
            break;
            //Set max recipeints:
            case 'max_rec_s':
                inputs["max_rec_ge"] = $('input#general_max_rec').val();
            break;
            //Set email:
            case 'max_email_s':
                inputs["email_ge"] = $('input#general_email').val();
            break;
            //Set files folder path:
            case 'folder_s':
                inputs["files_folder"] = $('input#general_folder').val();
            break;
            //Set message recipient:
            case 'mes_rec_s':
                inputs["mes_rec_title"] = $('input#general_mes_rec_title').val();
                inputs["mes_rec_body"] = $('textarea#general_mes_rec_body').val();								
            break;
            //Set message copy:
            case 'mes_cop_s':
                inputs["mes_cop_title"] = $('input#general_mes_cop_title').val();
                inputs["mes_cop_body"] = $('textarea#general_mes_cop_body').val();
            break;
        }
            
        //Call:
        $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
        ,success: function(response){ if ( response=='OK!' || response=='die5' ) { window.location.href="admin.php?pager=1"; } 
                                      else { console.log(response); $(object_ge_error).slideDown('slow'); }}
        ,error: function(thrownError){ console.log(thrownError); }});
        
    });
			
    //LOG SEARCH:
    $('div#search_log').click(function(){
        var object_log_error = $('div#log_page_error');
        $(object_log_error).slideUp('slow');
        $('div#log_page_res_conn').slideUp('fast',function(){
            $('div#log_page_res_conn').empty();
            //Set:
            var what_save = 'search_log';
            var inputs = { 
                what_save: what_save,
                user_token: $('input#get').val(), 
                s_date_log: $('input#search_start_date').val(),
                e_date_log: $('input#search_end_date').val()
            };

            //Call:
            $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
            ,success: function(response){ 
                if (response.substring(0,4) == 'die5') refresh_location();
                if (response.substring(0,3)=='OK!') { $('div#log_page_res_conn').html(response.substring(3)).slideDown('fast'); }
                else { $(object_log_error).slideDown('slow'); }
            }
            ,error: function(thrownError){ console.log(thrownError + 's'); }}); 
        });	
    });
    
    //Expand Row is Search log:
    $(document).on('click','.expand_log',function(){
        $(this).closest('tr').next('tr').find('div.row_log_details').eq(0).slideToggle();
    });

    //SEARCH USER ACTIVITY:
    $('div#search_user').click(function(){
        var object_log_error = $('div#search_page_error');
        $(object_log_error).slideUp('slow');
        $('div#search_page_res_conn').slideUp('fast',function(){
            $('div#search_page_res_conn').empty();
            //Set:
            var what_save = 'search_mail';
            var inputs = { 
                what_save: what_save,
                user_token: $('input#get').val(), 
                user_search: $('input#search_mail_input').val()
            };
            //Call:
            $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response.substring(0,4) == 'die5') refresh_location();
                if (response.substring(0,3)=='OK!') { $('div#search_page_res_conn').html(response.substring(3)).slideDown('fast'); }
                else { console.log(response); $(object_log_error).slideDown('slow'); }
            }
            ,error: function(thrownError){ console.log(thrownError); }}); 
        });	
    });
    
    //Expand Row is Search by mail:
    $(document).on('click','.expand_search',function(){
        $(this).closest('tr').next('tr').find('div.row_search_details').eq(0).slideToggle();
    });

    //Exclude a user:
    $('div#add_ex').click(function(){
        var object_log_error = $('div#ex_page_error');
        $(object_log_error).slideUp('slow');
        var what_save = 'ex_add';
        var inputs = { 
            what_save: what_save,
            user_token: $('input#get').val(), 
            ex_email: $('input#email_ex_input').val(),
            ex_note: $('input#com_ex_input').val()
        };
        $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
        ,success: function(response){
            if (response.substring(0,4) == 'die5') refresh_location();
            if ( response.substring(0,3) == 'OK!' ) { window.location.href="admin.php?pager=4"; }
            else { console.log(response); $(object_log_error).slideDown('slow'); }
        }
        ,error: function(thrownError){
            console.log(thrownError);
        }}); 			
    });

    //remove Exclude:
    $('div.remove_ex_but').click(function(){
        var id_to_remove_ex = $(this).next('input#id_ex').val();
        var what_save = 'ex_rem';
        var inputs = { 
            what_save: what_save,
            user_token: $('input#get').val(), 
            id_to_remove_ex: id_to_remove_ex
        };
        $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response.substring(0,4) == 'die5') refresh_location();
                if (response.substring(0,3)=='OK!') window.location.href="admin.php?pager=4";
                else { refresh_location(); }
            }
            ,error: function(thrownError){ console.log(thrownError); }
        }); 
    });
		
    //remove Blocked:
    $('div.remove_block_but').click(function(){
        var id_to_remove_blocked = $(this).next('input#id_block').val();
        var what_save = 'block_rem';
        var inputs = { 
            what_save: what_save,
            user_token: $('input#get').val(), 
            id_to_remove_blocked: id_to_remove_blocked
        };
        $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response.substring(0,4) == 'die5') refresh_location();
                if (response.substring(0,3)=='OK!') window.location.href="admin.php?pager=5";
                else { refresh_location(); }}
            ,error: function(thrownError){ console.log(thrownError); }
        }); 
    });

    //remove From log search:
    $(document).on('click','div.remove_log_search_but',function(){
        var row_log_search1 = $(this).closest('tr');
        var row_log_search2 = $(row_log_search1).next('tr');
        var id_to_remove_log = $(this).next('input#row_log_id').val();
        var what_save = 'log_rem';
        var inputs = { 
            what_save: what_save,
            user_token: $('input#get').val(), 
            id_to_remove_log: id_to_remove_log
        };
        $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
            ,success: function(response) {
            if (response.substring(0,3)=='OK!') {
                $(row_log_search2).remove();
                $(row_log_search1).remove();												
            } else { refresh_location(); } }
            ,error: function(thrownError){ console.log(thrownError); }
        }); 
    });	

    //remove From user search:
    $(document).on('click','div.remove_user_search_but',function(){
        var row_user_search1 = $(this).closest('tr');
        var row_user_search2 = $(row_user_search1).next('tr');
        var id_to_remove_search = $(this).next('input#row_search_id').val();
        var what_save = 'log_rem';
        var inputs = { 
            what_save: what_save,
            user_token: $('input#get').val(), 
            id_to_remove_log: id_to_remove_search
        };
        $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response.substring(0,3)=='OK!') {
                        $(row_user_search2).remove();
                        $(row_user_search1).remove();
                } else { refresh_location(); }}
            ,error: function(thrownError){ console.log(thrownError); }
        }); 
    });
        
    //error catcher hide:
    $(document).off('click','.closeMessageVal').on('click','.closeMessageVal',function() {
        $(this).parent('div').slideUp(function(){
            $(this).html("<div class='closeMessageVal'></div>");
        });
    });

    //expand users tools:
    $('img.expand_users_action_display').click(function(){
        $(this).parent('p').next('div').slideToggle('slow');
    });

    //expand users row for update:
    $(document).off('click','.update_row_user').on('click','.update_row_user',function(event){
        event.preventDefault();
        $(this).closest('tr').next('tr').find('.row_info_users').slideToggle('slow');
    });  
        
    //set users Mode:
    $('#but_submit_users_mode').click(function(){
        //get:
        var users_mode = $('#users_mode_select').val();
        var what_save  = 'users_mode';
        var user_token = $('input#get').val(); 
        var inputs = { 
            what_save  : what_save,
            user_token : user_token, 
            users_mode : users_mode
        };
        $.ajax({ type: "POST", url: "users.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response.substring(0,4) == 'die5') refresh_location();
                if (response == 'OK!') {
                    alert(type_js_user_mode_update_success);
                } else { console.log(response); alert(type_js_general_error_contact_admin); } }
            ,error: function(thrownError){
                console.log(thrownError);
                alert(type_js_general_error_contact_admin); }
        });                
    });

    //add user:
    $('#but_submit_new_user').click(function(){ 
        //get:
        var new_userName        = $('#user_name_new').val();
        var new_userPassword    = $('#user_pass_new').val();
        var new_fullName        = $('#user_Fname_new').val();
        var new_userMail        = $('#user_Email_new').val();
        var new_maxFiles        = $('#user_MaxFnum_new').val();
        var new_maxSize         = $('#user_MaxFsize_new').val();
        var new_maxRec          = parseInt($('#user_MaxRec_new').val());
        var what_save           = 'add_user_new';
        var user_token          = $('input#get').val(); 
        //validate:
        var valCatch = {};
        //username:
        if (new_userName.length     < 5)                              { valCatch['username'] = type_js_addUser_validation_userName_invalid; }
        if (new_userPassword.length < 5)                              { valCatch['userpass'] = type_js_addUser_validation_password_invalid; }
        if (typeof new_maxRec == 'number' && new_maxRec > 0) { } else { valCatch['maxrec'] = type_js_addUser_validation_recLimit_invalid; }
        if (!validateEmail(new_userMail))                             { valCatch['useremail'] = type_js_addUser_validation_email_invalid; }

        if (Object.keys(valCatch).length < 1) {
            //save new user:
            var inputs = { 
                what_save        : what_save,
                user_token       : user_token, 
                new_userName     : new_userName,
                new_userPassword : new_userPassword,
                new_fullName     : new_fullName,
                new_userMail     : new_userMail,
                new_maxSize     : new_maxSize,
                new_maxFiles     : new_maxFiles,
                new_maxRec       : new_maxRec
            };
            $.ajax({ type: "POST", url: "users.php", dataType: 'html', data: inputs
                ,success: function(response){
                    if (response == 'OK!') {
                        alert(type_js_addUser_success_created1 + new_userName + type_js_addUser_success_created2);
                        window.location.href="admin.php?pager=7";
                        return false;
                    } else if (response == 'Taken!') {
                        strAppend2 = "&bull;&nbsp;&nbsp;&nbsp;" + type_js_addUser_userName_taken1 + "<b>" + new_userName + "</b>&nbsp;" + type_js_addUser_userName_taken2 + "<br />";
                        $('.error_catcher').slideUp(function(){
                        $('#valid_of_new_user').html("<div class='closeMessageVal'></div>" + strAppend2).delay(300).slideDown();
                        }); 
                    } else if (response.substring(0,4) == 'die5') {
                        refresh_location();
                    } else {
                        console.log(response);
                        alert(type_js_general_error_contact_admin);
                    }}
                ,error: function(thrownError){
                    console.log(thrownError);
                    alert(type_js_general_error_contact_admin);
                }
            });                     
        } else {
            //output errors:
            strAppend = '';
            for (var key in valCatch) {
                strAppend += "&bull;&nbsp;&nbsp;&nbsp;" + valCatch[key] + "<br />";
            }
            $('#valid_of_guest_user').slideUp();
            $('#valid_of_new_user').slideUp(function(){
                $('#valid_of_new_user').html("<div class='closeMessageVal'></div>" + strAppend);
                $('#valid_of_new_user').slideDown();
            });
        }
    });

    //delete user:
    $('.delete_row_user').click(function(){

        //get:
        var rowMaster = $(this).closest('tr').eq(0);
        var rowMaster_next = $(rowMaster).next('tr').eq(0);
        var what_save    = 'delete_user';
        var user_token   = $('input#get').val(); 
        var user_name    = $(this).closest('tr').find('td').eq(0).text();
        var rowId        = parseInt($(this).attr('rowId')); 

        //validate:
        var valCatch2 = {};
        if (typeof rowId == 'number' && rowId > 0) { } else { valCatch2['idRow'] = type_js_general_error_contact_admin; }

        if (Object.keys(valCatch2).length < 1) {
            //Set:
            var inputs = { 
                rowId      : rowId,
                what_save  : what_save,
                user_token : user_token
            };  
            //Call
            $.ajax({ type: "POST", url: "users.php", dataType: 'html', data: inputs
            ,success: function( response ) {
                if ( response == 'OK!' ) { 
                    alert(type_js_addUser_success_del1 + user_name + type_js_addUser_success_del2);
                    $(rowMaster).fadeOut(function(){ $(this).remove(); });
                    $(rowMaster_next).fadeOut(function(){ $(this).remove(); });
                } else if ( response.substring(0,4) == 'die5' ) {
                    refresh_location();
                } else {
                    console.log(response);                    
                    alert(type_js_general_error_contact_admin);
                }}
            ,error: function( thrownError ) {
                    console.log(thrownError);
                    alert(type_js_general_error_contact_admin);
            }});                       
        } else {
            //output errors:
            strAppend2 = '';
            for (var key in valCatch2) { strAppend2 += "- " + valCatch2[key] + "\n"; }
            alert(strAppend2);                
        }
    });

    //update user:
    $('.but_submit_update_user').click(function(){
        //get:
        var parent                 = $(this).closest('table'); 
        var clickUpdate            = $(parent).closest('tr').prev('tr').find('.update_row_user').eq(0); 
        var update_userName        = $(parent).find('#user_name_update').val();
        var update_userPassword    = $(parent).find('#user_pass_update').val();
        var update_fullName        = $(parent).find('#user_Fname_update').val();
        var update_userMail        = $(parent).find('#user_Email_update').val();
        var update_maxFiles        = $(parent).find('#user_MaxFnum_update').val();
        var update_maxSize         = $(parent).find('#user_MaxFsize_update').val();
        var update_maxRec          = parseInt($(parent).find('#user_MaxRec_update').val());
        var update_active          = $(parent).find('#user_activate_status').val();
        var what_save              = 'update_user';
        var user_token             = $('input#get').val(); 
        var rowId                  = $(this).attr('rowId');

        //validate:
        var valCatch2 = {};
        //username:
        if (update_userName.length     < 5)                                 { valCatch2['username']     = type_js_addUser_validation_userName_invalid;         }
        if (update_userPassword != "" && update_userPassword.length < 5)    { valCatch2['userpass']     = type_js_addUser_validation_password_invalid;     }
        if (typeof update_maxRec == 'number' && update_maxRec > 0) { } else { valCatch2['maxrec']       = type_js_addUser_validation_recLimit_invalid;   }
        if (!validateEmail(update_userMail))                                { valCatch2['useremail']    = type_js_addUser_validation_email_invalid;   }

        if (Object.keys(valCatch2).length < 1) { 
            //save new user:
            var inputs = { 
                rowId               : rowId,
                what_save           : what_save,
                user_token          : user_token, 
                update_userName     : update_userName,
                update_userPassword : update_userPassword,
                update_fullName     : update_fullName,
                update_userMail     : update_userMail,
                update_maxSize      : update_maxSize,
                update_maxFiles     : update_maxFiles,
                update_maxRec       : update_maxRec,
                update_active       : update_active
            };
            //Call:
            $.ajax({ type: "POST", url: "users.php", dataType: 'html', data: inputs
                ,success: function(response){
                    if (response == 'OK!') {
                        alert(type_js_updateUser_success_created1 + update_userName + type_js_updateUser_success_created2);
                        $(clickUpdate).trigger( "click" );

                        //update Row: display:
                        if(update_active == 'yes') $(clickUpdate).closest('tr').find('td').eq(0).html("<img src='../img/active.png' width='15px' height='15px'  style='position:relative; top:3px' alt='Activation mode' title='Activation mode' />&nbsp;&nbsp;" + update_userName);
                        else                       $(clickUpdate).closest('tr').find('td').eq(0).html("<img src='../img/inactive.png' width='15px' height='15px'  style='position:relative; top:3px' alt='Activation mode' title='Activation mode' />&nbsp;&nbsp;" + update_userName);
                        $(clickUpdate).closest('tr').find('td').eq(1).text(update_fullName);
                        $(clickUpdate).closest('tr').find('td').eq(2).text(update_userMail);
                    } else if (response == 'Taken!') {
                        alert(type_js_updateUser_userName_taken1 + update_userName + type_js_updateUser_userName_taken2); 
                    } else if (response.substring(0,4) == 'die5') {
                        refresh_location();
                    } else {
                        console.log(response);
                        alert(type_js_general_error_contact_admin);
                    }}
                ,error: function(thrownError){
                    console.log(thrownError);                    
                    alert(type_js_general_error_contact_admin);
                }
            });                     
        } else {
            //output errors:
            strAppend2 = '';
            for (var key in valCatch2) { strAppend2 += "- " + valCatch2[key] + "\n"; }
            alert(strAppend2);
        }
    });
        
    //submit guests:
    $('#but_submit_guest').click(function(){
        //get:
        var parent                 = $(this).closest('table'); 
        var update_guest_maxFiles  = $(parent).find('#guest_MaxFnum_new').val();
        var update_guest_maxSize   = $(parent).find('#guest_MaxFsize_new').val();
        var update_guest_maxRec    = parseInt($(parent).find('#guest_MaxRec_new').val());
        var what_save              = 'update_guest';
        var user_token             = $('input#get').val(); 
        //validate:
        var valCatch3 = {};
        //username:
        if (typeof update_guest_maxRec == 'number' && update_guest_maxRec > 0) { } else { valCatch3['maxrec'] = type_js_guestAccount_invalid_recLimit; }

        if (Object.keys(valCatch3).length < 1) { 
            //save new user:
            var inputs = { 
                what_save                 : what_save,
                user_token                : user_token, 
                update_guest_maxSize      : update_guest_maxSize,
                update_guest_maxFiles     : update_guest_maxFiles,
                update_guest_maxRec       : update_guest_maxRec
            };
            //Call:
            $.ajax({ type: "POST", url: "users.php", dataType: 'html', data: inputs
                ,success: function(response){
                    if (response == 'OK!') {
                        alert(type_js_guestAccount_updated);
                    } else if (response.substring(0,4) == 'die5') {
                        refresh_location();
                    } else {
                        console.log(response);
                        alert(type_js_general_error_contact_admin);
                    }}
                ,error: function(thrownError){
                    console.log(thrownError);
                    alert(type_js_general_error_contact_admin);
                }
            });
        } else {
            //output errors:
            strAppend = '';
            for (var key in valCatch3) { strAppend += "&bull;&nbsp;&nbsp;&nbsp;" + valCatch3[key] + "<br />"; }
            $('#valid_of_new_user').slideUp();
            $('#valid_of_guest_user').slideUp(function(){
                $('#valid_of_guest_user').html("<div class='closeMessageVal'></div>" + strAppend).delay(300).slideDown();
            });
        }
    });

    //error catcher2 hide:
    $(document).off('click','.closeMessageVal2').on('click','.closeMessageVal2',function() { 
        $(this).parent('div').slideUp(function(){ }); 
    });
    
    //Run CleanUp:
    $('#but_cleanUp').click(function(){
        //hide previous errors:
        $('#errorMessageOfCleanUp').slideUp('fast',function(){
            //get:
            var parent                 = $(this).closest('table'); 
            var intervalweeks          = parseInt($(parent).find('#selectWeeksInterval').val());
            var what_save              = "cleanup_rem";
            var user_token             = $('input#get').val(); 
            //console.log(intervalweeks,what_save);

            //validate:
            var valCatch5 = {};
            //username:
            if (typeof intervalweeks == 'number' && intervalweeks > 0) { } else { valCatch5['weeksInterval'] = type_js_cleanUp_weeks_interval_invalid; }

            if (Object.keys(valCatch5).length < 1) { 
                //expose processing bar:
                if ($('#cleanUpSetParams').is(":visible")) { $('#cleanUpSetParams').slideUp('slow'); }
                if (!$('#runningCleanUp').is(":visible")) {$('#runningCleanUp').slideDown('slow'); }

                setTimeout(function(){
                    var inputs = { 
                        what_save     : what_save,
                        user_token    : user_token, 
                        intervalweeks : intervalweeks
                    };                                
                    $.ajax({ type: "POST", url: "doit.php", dataType: 'html', data: inputs
                        ,success: function(response){
                        if (response == 'OK!') {
                            alert('CleanUp Done!');
                            window.location.href="admin.php?pager=6";
                        } else if (response.substring(0,4) == 'die5') {
                            refresh_location();
                        } else {
                            if (!$('#cleanUpSetParams').is(":visible")) { $('#cleanUpSetParams').slideDown('slow'); }
                            $('#errorMessageOfCleanUp').slideDown('slow');
                            $('#runningCleanUp').slideUp('slow');
                            console.log(response);
                        }}
                        ,error: function(thrownError){
                            if (!$('#cleanUpSetParams').is(":visible")) { $('#cleanUpSetParams').slideDown('slow'); }
                            $('#errorMessageOfCleanUp').slideDown('slow');
                            $('#runningCleanUp').slideUp('slow');
                            console.log(thrownError);
                    }}); 
                },1500);
            } else {
                //output errors:
                if ($('#runningCleanUp').is(":visible"))    { $('#runningCleanUp').slideUp('fast'); }
                if (!$('#cleanUpSetParams').is(":visible")) { $('#cleanUpSetParams').slideDown('fast'); }
                $('#errorMessageOfCleanUp').slideDown();
            }
        });
    });

    //Advertise manager - save general:
    $('#but_advertise_general').click(function(){
        //Set:
        var inputs = $('#advertise_general_form').serializeArray();
        inputs.push({name: 'what_save', value: "general_advertise"});
        inputs.push({name: 'user_token', value: $('input#get').val()});
        //Call:
        $.ajax({ type: "POST", url: "advertise_save.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response == 'OK!') {
                    alert(type_js_advertise_saved_success);
                } else if (response.substring(0,4) == 'die5') {
                    refresh_location();
                } else {
                    console.log(response);
                    alert(type_js_general_error_contact_admin);
                    refresh_location();
                }}
            ,error: function(thrownError){
                console.log(thrownError);
                alert(type_js_general_error_contact_admin);
                refresh_location();
        }});     
    });

    //Advertise manager - save code:
    $('#but_adsense_code').click(function(){
        var inputs = $('#advertise_adsenseCode_form').serializeArray();
        inputs.push({name: 'what_save', value: "general_adsenseCode"});
        inputs.push({name: 'user_token', value: $('input#get').val()});

        $.ajax({ type: "POST", url: "advertise_save.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response == 'OK!') {
                    alert(type_js_advertise_adsense_saved_success);
                } else if (response.substring(0,4) == 'die5') {
                    refresh_location();
                } else {
                    console.log(response);
                    alert(type_js_general_error_contact_admin);
                    refresh_location();
                }}
            ,error: function(thrownError){
                console.log(thrownError);
                alert(type_js_general_error_contact_admin);
                refresh_location();
        }});     
    });        

    //Advertise manager - save banner:
    $('#but_advertise_bannerAdd').click(function(){
        //Set:
        var inputs = $('#advertise_addbanner_form').serializeArray();
        inputs.push({name: 'what_save', value: "general_addbanner"});
        inputs.push({name: 'user_token', value: $('input#get').val()});
        //Call:
        $.ajax({ type: "POST", url: "advertise_save.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response == 'OK!') {
                    alert(type_js_advertise_addBanner_saved_success);
                    window.location.href="admin.php?pager=8";
                } else if (response.substring(0,4) == 'die5') {
                    refresh_location();
                } else {
                    console.log(response);
                    alert(type_js_general_error_contact_admin);
                    window.location.href="admin.php?pager=8";
                }}
            ,error: function(thrownError){
                console.log(thrownError);
                alert(type_js_general_error_contact_admin);
                window.location.href="admin.php?pager=8";
        }});     
    });          
    
    //Advertise update - update button Expose:
    $('.update_ads').click(function() {
        var ban_id = $(this).attr("bannerId");
        var ban_type = $(this).attr("bannerType");
        var json_values = $(this).closest('div').find('.json_info_ads').eq(0).val();
        json_values = jQuery.parseJSON(json_values);
        expose_ads_update(ban_id,ban_type,json_values);
    });
    
    //Advertise save updates:
    $('#submit_ads_update').click(function() {
        //Set:
        var inputs = $('#ads_form_update').serializeArray();
        inputs.push({name: 'what_save', value: "update_advertise"});
        inputs.push({name: 'user_token', value: $('input#get').val()});
        //Call:
        $.ajax({ type: "POST", url: "advertise_save.php", dataType: 'html', data: inputs
            ,success: function(response){
                if (response == 'OK!') {
                    alert(type_js_advertise_updateBanner_saved_success);
                    window.location.href="admin.php?pager=8";
                } else if (response.substring(0,4) == 'die5') {
                    refresh_location();
                } else {
                    console.log(response);
                    alert(type_js_general_error_contact_admin);
                    window.location.href="admin.php?pager=8";
                }}
            ,error: function(thrownError){
                console.log(thrownError);
                alert(type_js_general_error_contact_admin);
                window.location.href="admin.php?pager=8";
        }});     
    }); 
    
    //Advertise reset counters:
    $('.reset_counters_ads').click(function() {
        var ads_id_up = $(this).attr("bannerId");
        if ( confirm(type_js_advertise_resetCounter_confirm) ) {
            //Set:
            var inputs = new Object();
            inputs.ads_id_up  = ads_id_up;
            inputs.what_save  = "reset_counters";
            inputs.user_token = $('input#get').val();
            //Call:
            $.ajax({ type: "POST", url: "advertise_save.php", dataType: 'html', data: inputs
                ,success: function(response){
                    if (response == 'OK!') {
                        alert(type_js_advertise_resetCounter_success);
                        window.location.href="admin.php?pager=8";
                    } else if (response.substring(0,4) == 'die5') {
                        refresh_location();
                    } else {
                        console.log(response);
                        alert(type_js_general_error_contact_admin);
                        window.location.href="admin.php?pager=8";
                    }}
                ,error: function(thrownError){
                    console.log(thrownError);
                    alert(type_js_general_error_contact_admin);
                    window.location.href="admin.php?pager=8";
            }});
        }
    }); 

    //Advertise delete banner:
    $('.del_banner_ads').click(function() {
        var ads_id_up = $(this).attr("bannerId");
        if ( confirm(type_js_advertise_delBanner_confirm) ) {
            //Set:
            var inputs = new Object();
            inputs.ads_id_up  = ads_id_up;
            inputs.what_save  = "delete_advertise";
            inputs.user_token = $('input#get').val();
            //Call:
            $.ajax({ type: "POST", url: "advertise_save.php", dataType: 'html', data: inputs
                ,success: function(response){
                    if (response == 'OK!') {
                        alert(type_js_advertise_delBanner_success);
                        window.location.href="admin.php?pager=8";
                    } else if (response.substring(0,4) == 'die5') {
                        refresh_location();
                    } else {
                        console.log(response);
                        alert(type_js_general_error_contact_admin);
                        window.location.href="admin.php?pager=8";
                    }}
                ,error: function(thrownError){
                    console.log(thrownError);
                    alert(type_js_general_error_contact_admin);
                    window.location.href="admin.php?pager=8";
            }});
        }
    });    
    
    //close adds updater:
    $('.close_updater_ads').click(function() {
        hide_ads_update();
    });
    
    //stat reset:
    $('.reset_stat').click(function(){
        inputs_reset = { what_do:$(this).attr('id'),user_token:$('input#get').val()};
        if (confirm(type_js_stat_reset_confirm)) {
            //Call api securely:
            $.ajax({ type: "POST", url: "reset_stats.php", dataType: 'html', data:inputs_reset
            ,success: function(response){
                if (response.substring(0,4) == 'die5') refresh_location();
                if (response.substr(0,2) != "OK") {
                        alert(type_js_general_error_contact_admin);
                }
                window.location.href="admin.php?pager=9";
            }
            ,error: function(thrownError){
                console.log(thrownError);
                alert(type_js_general_error_contact_admin);
                window.location.href="admin.php?pager=9";
            }});
        }
    });
        
    //Plot for stats - last activity:
    var inputs_plot = { what_do:"json_sent_counts",user_token:$('input#get').val()};
    var s1          = new Array();
    var ticks1      = new Array();
    var plot1       = null;
        
    //Call api securely for plot data:
    $.ajax({ type: "POST", url: "json_week.php", dataType: 'html', data:inputs_plot
        ,success: function(response){
            if (response.substr(0,2) == "OK") {
                parsed = $.parseJSON(response.substr(2));   
                if (parsed != null) {
                    for (var i = 0; i < parsed.length; i++ ) {
                        s1.push(parsed[i].count);
                        ticks1.push(parsed[i].date);
                    }
                    $.jqplot.config.enablePlugins = true;
                    plot1 = $.jqplot("plot1_stat", [s1], {
                                seriesColors: ["#FAAC58"],
                                seriesDefaults:{
                                    renderer:$.jqplot.BarRenderer,
                                    pointLabels: { show: true, location: 'n'},
                                    rendererOptions: {fillToZero: true},
                                    trendline: { show: true }
                                },
                                animate: !$.jqplot.use_excanvas,
                                legend: { show: false },
                                highlighter: { show: false },
                                axes: { 
                                        xaxis: { renderer: $.jqplot.CategoryAxisRenderer, ticks:ticks1 },
                                        yaxis: { padMax: 1.1 } 
                                }
                    });  
                }
            } else {
                console.log(type_js_general_error_contact_admin);
                console.log(response);
            }}
        ,error: function(thrownError){
            console.log(type_js_general_error_contact_admin);
            console.log(thrownError);
    }});
            
    //Plot for storage - last activity:
    var inputs_plot = { what_do:"json_file_sizes",user_token:$('input#get').val()};
    var s2          = new Array();
    var ticks2      = new Array();
    var plot2       = null;
        
    //Call api securely:
    $.ajax({ type: "POST", url: "json_week.php", dataType: 'html', data:inputs_plot
        ,success: function(response){
            if (response.substr(0,2) == "OK") {
                parsed = $.parseJSON(response.substr(2));   
                if (parsed != null) {
                    for (var i = 0; i < parsed.length; i++ ) {
                        s2.push(parseFloat(parsed[i].count));
                        ticks2.push(parsed[i].date);
                    }
                    plot2 = $.jqplot("plot2_storage", [s2], {
                                seriesColors: ["#FAAC58"],
                                seriesDefaults:{
                                    renderer:$.jqplot.BarRenderer,
                                    pointLabels: { show: true, formatString: '%.2f mb', location: 'n'},
                                    rendererOptions: {fillToZero: true},
                                    trendline: { show: true }
                                },
                                animate: !$.jqplot.use_excanvas,
                                legend: { show: false },
                                highlighter: { show: false },
                                axes: { 
                                        xaxis: { renderer: $.jqplot.CategoryAxisRenderer, ticks:ticks2 },
                                        yaxis: { padMax: 1.1 } 
                                }
                    });  
                }
            } else {
                console.log(type_js_general_error_contact_admin);
                console.log(response);
            }}
        ,error: function(thrownError){
            console.log(type_js_general_error_contact_admin);
            console.log(thrownError);
    }});


}); // <-- END OF DOM READY

/******************************   FUNCTIONS   *********************************/
function isNumeric(num){
    return !isNaN(num);
}
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 
function expose_ads_update(ban_id,ban_type,json_values) {
    //set id:
    $('.ads_update_overlay').find('#ads_up_id').val(ban_id);
    //Preview:
    if ( ban_type == "image" ) $('.ads_update_overlay').find('#display_banner_up').html("<img src='../banners/" + json_values.banner_filename + "' style='width:200px; height:45px;' />");
    else $('.ads_update_overlay').find('#display_banner_up').html("<iframe src='../banners/" + json_values.banner_filename + "' frameborder='0' scrolling='no' style='width:200px; height:45px;'></iframe>");
    //banner alt name:
    $('.ads_update_overlay').find('#banners_alt_name_up').val(json_values.banner_altname);
    //Expose To users:
    if ( json_values.user === "1" ) $('.ads_update_overlay').find('#banners_users_exposure_up').attr('checked', true);
    //Expose to guests:
    if ( json_values.guest === "1" ) $('.ads_update_overlay').find('#banners_guests_exposure_up').attr('checked', true);
    //Expose in main:
    if ( json_values.mainpage === "1" ) $('.ads_update_overlay').find('#banners_allow_main_up').attr('checked', true);
    //Expose in download:
    if ( json_values.downpage === "1" ) $('.ads_update_overlay').find('#banners_allow_down_up').attr('checked', true);
    //Expose to recipients:
    if ( json_values.email_rec === "1" ) $('.ads_update_overlay').find('#banners_allow_rec_up').attr('checked', true);
    //Expose to senders:
    if ( json_values.email_sender === "1" ) $('.ads_update_overlay').find('#banners_allow_sender_up').attr('checked', true);
    //banner alt name:
    $('.ads_update_overlay').find('#banners_url_up').val(json_values.url);
    //Expose:
    $('.ads_update_overlay').attr("expose","true");
    $('.ads_update_overlay').fadeIn();
}
function hide_ads_update() {
    if ($('.ads_update_overlay').attr("expose") == "true") {
        $('.ads_update_overlay').find('#ads_up_id').val("");
        $('.ads_update_overlay').find('#display_banner_up').html("");
        $('.ads_update_overlay').find('#banners_alt_name_up').val("");
        $('.ads_update_overlay').find('#banners_users_exposure_up').attr('checked', false);
        $('.ads_update_overlay').find('#banners_guests_exposure_up').attr('checked', false);
        $('.ads_update_overlay').find('#banners_allow_main_up').attr('checked', false);
        $('.ads_update_overlay').find('#banners_allow_down_up').attr('checked', false);
        $('.ads_update_overlay').find('#banners_allow_rec_up').attr('checked', false);
        $('.ads_update_overlay').find('#banners_allow_sender_up').attr('checked', false);
        $('.ads_update_overlay').find('#banners_url_up').val("");
        $('.ads_update_overlay').attr("expose","false");
        $('.ads_update_overlay').fadeOut();    
    } else {
        $('.ads_update_overlay').hide();
    }
}
function refresh_location() {
    location.reload();
}