<?php   
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
?>
<div class='outerConatainer'  style="margin:0 auto;">
<form action='admin.php' method='post'  class='hiddder'>
<table border='0'>
    <tr>
        <td colspan='3'>
            <div class='logoTakeThat'><img src='../img/takethatlogo.png' /></div>
            <div class='logoBrand'><span class='Brand' id='Brand'><?php echo $brand; ?></span></div>
        </td>
    </tr>
    <tr>
        <td colspan='3'><div class='border_div'></div></td>
    </tr>
    <tr>
        <td colspan='3' style='background-color:#BDBDBD; '>
            <p style='font-weight:700; color:#084B8A; padding:5px 0px 5px 5px; margin:0;'><?php echo $lang[$lang['set']]['type_login_page_main_title'];  ?></p>
        </td>
    </tr>
    <tr>
        <td colspan='3' style='padding:10px 70px 10px 70px;'>
            <p class='sec_form' style='font-weight:700; padding:5px 0px 5px 5px; margin:0;'><img src='../img/user.png' style='width:13px; opacity:.8;' />&nbsp;<?php echo $lang[$lang['set']]['type_login_page_user_name_input_label'];  ?></p>
            <input name='access_user' type='text' style='width:98%; font-size:1.2em;' />
            <br />
            <p class='sec_form' style='font-weight:700; padding:5px 0px 5px 5px; margin:0;'><img src='../img/password.png' style='width:13px; opacity:.8;' />&nbsp;<?php echo $lang[$lang['set']]['type_login_page_password_input_label'];  ?></p>
            <input name='access_password' type='password' style='margin-bottom:8px; width:98%; font-size:1.2em;' />
            <?php echo gettokenfield(); ?>
        </td>
    </tr>
    <tr>
        <td colspan='3'><div class='border_div'></div></td>
    </tr>
    <tr>
        <td colspan='3' class='button_td'>
            <div class='button_td'>
                <input class='css3button' type='submit' id='but1in' value='<?php echo $lang[$lang['set']]['type_login_page_submit_button'];  ?>' style='line-height:30px; margin-top:8px; height:auto;' />
            </div>
        </td>
    </tr>
</table>
</form>
</div>
</body>
</html>