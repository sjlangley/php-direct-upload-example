<?php
// Direct uploads requires PHP 5.5 on App Engine.
if (strncmp("5.5", phpversion(), strlen("5.5")) != 0) {
  die("Direct uploads require the PHP 5.5 runtime. Your runtime: " . phpversion());
}
?>
<html>
<body>
<form action="handle_upload" method="post" enctype="multipart/form-data">
  Select JPEG files to upload:<p/>
  <input name="userfile[]" type="file" multiple="multiple"/><p/>
  <input type="submit" value="Send files" />
</form>
</body>
</html>

