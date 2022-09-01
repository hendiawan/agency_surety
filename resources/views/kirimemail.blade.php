<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="{{ url('/test-send-email') }}">
  {!! csrf_field() !!}
  <input type="hidden" name="status" value="P"/>
  <input type="hidden" name="id" value="1234"/>
  <table width="100%" border="0" cellspacing="4" cellpadding="0">
    <tr>
      <td width="10%">Email To</td>
      <td><label for="textfield"></label>
      <input type="email" name="to" id="textfield" /></td>
    </tr>
    <tr>
      <td>Email From</td>
      <td><label for="textfield2"></label>
      <input type="email" name="from" id="textfield2" /></td>
    </tr>
    <tr>
      <td>Subject</td>
      <td><label for="textfield3"></label>
      <input type="text" name="subject" id="textfield3" /></td>
    </tr>
    <tr>
      <td>Massage</td>
      <td><label for="textarea"></label>
      <textarea name="pesan" id="textarea" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Kirim" /></td>
    </tr>
  </table>
</form>
</body>
</html>