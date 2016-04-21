$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
	  numFiles = input.get(0).files ? input.get(0).files.length : 1,
	  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});	
$(document).ready( function() {
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		
		var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;
		
		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}      
	});
});
var emails = [];

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function addReceiver() {
	var emailInput = document.getElementById("emailTo").value;
	if (validateEmail(emailInput)) {
		if (emailInput == '' || emailInput == null) {
			$('#receivers').addClass('shake animated has-error').one('animationEnd webkitAnimationEnd',function () { $("#receivers").removeClass('shake animated has-error'); });
		} 
		else
		{
			var emailExist = emails.indexOf(emailInput);
			if(emailExist == -1) {
				emails.push(emailInput);
				var divReceivers = document.getElementById('receiverList');
				var divHiddenReceivers = document.getElementById('receiverHiddenList');
				var emailToValue = document.getElementById("emailTo").value;

				divReceivers.innerHTML = divReceivers.innerHTML + '<p><i class="fa fa-angle-right"></i> '+emailToValue+'</p>';
				divHiddenReceivers.innerHTML = divHiddenReceivers.innerHTML + '<input type="hidden" name="email_to[]" id="email_to" value="'+emailToValue+'">';
				document.getElementById("emailTo").value = '';
				document.getElementById('uploadDiv').style.height = '550px';
				document.getElementById('receivers').style.display = "block";
				document.getElementById('receiverList').style.display = "block";
			} else {
				$('#receivers').addClass('shake animated has-error').one('animationEnd webkitAnimationEnd',function () { $("#receivers").removeClass('shake animated has-error'); });
				document.getElementById("emailTo").value = '';
			}
		}
	} else {
		$('#receivers').addClass('shake animated has-error').one('animationEnd webkitAnimationEnd',function () { $("#receivers").removeClass('shake animated has-error'); });
		document.getElementById("emailTo").value = '';
	}
}
$(function() {
    $(".progressCircle").knob({
    	'min':0,
        'max':100,
        'readOnly': true,
        'width': 250,
        'height': 250,
    });
});
$('body').on('click', '#submitpassword', function(){
	document.getElementById("errorDiv").innerHTML = "";
	document.getElementById('downloadPassword').style.display = "none";
	document.getElementById('downloadLogo').innerHTML = '<i class="fa fa-check-square-o fa-5x" style="padding-top: 100px;"></i>';	
	document.getElementById("statusDownload").innerHTML = msg_download_started;
});
$('body').on('click', '#submit_upload', function(e){
	e.preventDefault();
	
	var filesInput = document.getElementById("files").value;
	var emailfrom = document.getElementById("emailFrom").value;
	var shareOption = document.getElementById("share").value;

	var form = new FormData($('#uploadForm')[0]);
	var totalSizefiles = 0;

	var files = $("#files")[0].files
	for (i = 0; i < files.length; i++) {
		totalSizefiles+= files[i].size;
	}
	if (totalSizefiles > maxSize * 1048576) {
		document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_file_to_large+'</div>';
	}
	else
	{
		if(shareOption == 'mail' && emailfrom == '' || emailfrom == null || filesInput == '' || filesInput == null) {
			document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_fill_fields+'</div>';
		}
		else
		{
			$.ajax({
			    url: 'src/upload.php',
			    type: 'POST',
			    dataType: 'json',
			    xhr: function() {
			        var myXhr = $.ajaxSettings.xhr();
			        if(myXhr.upload){
			            myXhr.upload.addEventListener('progress',uploadProgress, false);
			        }
			        return myXhr;
			    },
			    success: function(res)
				{
					if(res.upload_error == 'true'){
						errorMode();
						document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_upload_error+'</div>';
					}
					if(res.email_error == 'true'){
						errorMode();
						document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_upload_error+'</div>';
					}
					if(res.type_error == 'true'){
						errorMode();
						document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_file_blocked+'</div>';
					}
					if(res.fields == 'false'){
						errorMode();
						document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_fill_fields+'</div>';
					}
					if(res.upload_type == 'link') {
						uploadComplete();
						document.getElementById('linkMessage').style.display = "block";
						document.getElementById('downloadLink').innerHTML = '<a href="' + siteUrl + res.upload_id + '" target="_blank">'  + siteUrl + res.upload_id + '</a>';
					}
				},				
			    data: form,
			    cache: false,
			    contentType: false,
			    processData: false
			});
		}
	}
});
function uploadProgress(evt) {
	document.getElementById('errorDiv').innerHTML = "";
  	if (evt.lengthComputable) {
	    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
	    var totalMb = evt.total/1048576;
	    var uploadedMb = evt.loaded/1048576;
	    var shareOption = document.getElementById("share").value;

	    //document.getElementById('Uploadprogress').innerHTML = percentComplete.toString() + '%';
	    document.getElementById('uploadDiv').style.display = "none";
	    document.getElementById('uploadDivSocial').style.display = "none";
	    document.getElementById('uploadSettings').style.display = "none";
	    document.getElementById('uploadingDiv').style.display = "block";
	    document.getElementById('uploadingDivSocial').style.display = "block";
	    document.getElementById('progressMb').innerHTML = '<p align="center"><i>' + Math.round(uploadedMb).toFixed(1) + ' MB uploaded of ' + Math.round(totalMb).toFixed(1) + ' MB</i></p>';

	    document.getElementById("progresscircle").value = percentComplete.toString();
	    $('.progressCircle')
			.val(percentComplete.toString())
			.trigger('change');

		if (totalMb > maxSize) {
			uploadSize();
		}
		if(uploadedMb == totalMb) {
			if(shareOption == 'mail') {
				uploadComplete();
			}
			else
			{
				document.getElementById('uploadProcess').style.display = "none";
				document.getElementById('loadingMessage').style.display = "block";
			}

		}
  	} else {
    	document.getElementById('uploadDiv').innerHTML = 'unable to compute';
  	}
}

function uploadComplete(evt) {
	setTimeout(function() {
		var shareOption = document.getElementById("share").value;
		if(shareOption == 'mail') {
			document.getElementById('emailMessage').style.display = "block";
		}
		document.getElementById('uploadProcess').style.display = "none";
		document.getElementById('loadingMessage').style.display = "none";
		document.getElementById('uploadSuccess').style.display = "block";
	}, 1000);
}

function uploadFailed(evt) {
  	alert("There was an error while attempting to upload the file.");
}

function uploadSize(evt) {
  	document.getElementById('uploadProcess').style.display = "none";
	document.getElementById('uploadSuccess').style.display = "none";
	document.getElementById('uploadingDiv').style.display = "none";
	document.getElementById('uploadingDivSocial').style.display = "none";
	document.getElementById('uploadDiv').style.display = "block";
	document.getElementById('uploadDivSocial').style.display = "block";
	document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_file_to_large+'</div>';
}

function uploadCanceled(evt) {
  	alert("The upload has been canceled by the user or the browser dropped the connection.");
}

function openSettings(evt) {
  	document.getElementById('uploadSettings').style.display = "block";
}

function closeSettings(evt) {
	document.getElementById('uploadSettings').style.display = "none";
}

function shareEmail() {
	var share = 'mail';
	document.getElementById('EmailToSection').style.display = "block";
	document.getElementById('EmailFromSection').style.display = "block";
	document.getElementById('share').value = 'mail';

}

function shareLink() {
	var share = 'link';
	document.getElementById('EmailToSection').style.display = "none";
	document.getElementById('EmailFromSection').style.display = "none";
	document.getElementById('share').value = 'link';
}

function errorMode() {
	document.getElementById('uploadDiv').style.display = "block";
	document.getElementById('uploadDivSocial').style.display = "block";
	document.getElementById('uploadSettings').style.display = "none";
	document.getElementById('uploadingDiv').style.display = "none";
	document.getElementById('uploadingDivSocial').style.display = "none";
}
$('#submit_password').click(function()
{
	var downloadId=$("#download_id").val();
	var password=$("#password").val();
	var formAction = 'download';
	var dataString = 'action='+formAction+'&download_id='+downloadId+'&password='+password;
	
	if (password==null || password=="")
	{
		document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_fill_fields+'</div>';
	}else{
		$.ajax({
			type: "POST",
			url: 'src/action.php',
			dataType: 'json',
			data: dataString,
			cache: false,
			success: function(data){
				if(data.password == 'true')
				{
					window.location = 'src/action.php';
				}
				if(data.password == 'false')
				{
					document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">'+msg_wrong_pass+'</div>';
				}
			}
		});
	}
	return false;
});
$('#submitdownload').click(function()
{
	document.getElementById('downloadForm').style.display = "none";
	document.getElementById('downloadSuccess').style.display = "block";
});

//________________________________________Plugin coding________________________________________
$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
//Load all photos before site load
function preloadImages(srcs, imgs) {
    var img;
    var remaining = srcs.length;
    for (var i = 0; i < srcs.length; i++) {
        img = new Image();
        img.onload = function() {
        };
        img.src = srcs[i];
        imgs.push(img);
    }
}