<?php
    if(isset($_POST['submit']))
    {
    	//The form has been submitted, prep a nice thank you message
    	$output = '<h1>Thanks for your email!</h1>';
    	//Set the form flag to no display (cheap way!)
    	$flags = 'style="display:none;"';

    	//Deal with the email

        $to = 'mtwebmedia@gmail.com';
        $subject = 'Portfolio Contact Form';
		$name = "Name: " . strip_tags($_POST['name']) . "\n";
		$email = "Email: " . strip_tags($_POST['email']) . "\n";
		$note = "Message: " . strip_tags($_POST['note']) . "\n";
		
		
		$message = $name . $email . $note;
    	
    	$attachment = chunk_split(base64_encode(file_get_contents($_FILES['uploaded_file']['tmp_name'])));
    	$filename = $_FILES['uploaded_file']['name'];

    	$boundary =md5(date('r', time())); 

    	$headers = "From: mtwebmedia@reply.com\r\nReply-To: mtwebmedia@reply.com";
    	$headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_$boundary\"";

    	$message="This is a multi-part message in MIME format.

--_1_$boundary
Content-Type: multipart/alternative; boundary=\"_2_$boundary\"

--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

$message

--_2_$boundary--
--_1_$boundary
Content-Type: application/octet-stream; name=\"$filename\" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

$attachment
--_1_$boundary--";

    	mail($to, $subject, $message, $headers);
		$flags = 'style="display:none;"';
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Contact Me</title>
<style>
form {max-width:300px;width:100%;padding:20px;border:none;background-color:#ffffff;border-radius:5px;margin: 0px 0px 0px -8px;}
fieldset {margin:0px 0px 15px 0px;border:none;}
label {font-family:Arial;font-size:16px;color:#333;margin:0;padding:0;display:block;border:none;}
input {background-color:#fff;border:none;border-radius:5px;margin:10px 0px 0px 0px;max-width:250px;width:100%;padding: 10px 0px;}
input[type="file" i] {background-color: #ccc;}
input[type="submit"] {margin:20px 0px 0px 12px;padding:5px 10px;background-color:#fff;color:#333;display:block;width: 100px;height: 35px;}
input[type="submit"]:hover {background-color:#999;color:#fff;}
#submit {width:100%;text-align:left;margin:0;padding:0;}
</style>
</head>

<body>
<?php echo $output ?>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" <?php echo $flags;?>>
<fieldset>
<label>Name:</label>
<input type="text" required name="name" placeholder="Full Name">
</fieldset>
<fieldset>
<label>Email:</label>
<input type="text" required name="email" placeholder="Email Address">
</fieldset>
<fieldset>
<label>Message:</label>
<textarea name="note" placeholder="Type your message here." required></textarea>
</fieldset>
<input type="submit" name="submit" id="submit" value="Submit">
</form>
