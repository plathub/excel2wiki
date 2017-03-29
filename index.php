<!--
Copyright (c) 2010 Shawn M. Douglas (shawndouglas.com)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
-->

<?php
echo "<html>
<head><title>excel2wiki.net | Excel xls to wiki copy and paste converter for wikipedia and mediawiki</title></head>
<body><h1>Copy & Paste Excel-to-Wiki Converter</h1>
<form action='index.php' method='post'>
  <textarea name='data' rows='20' cols='100'></textarea><br>
  <label for='tableclass'>Table style:
  <input id='tableclass' type='text' name='tableclass' value='class=\"wikitable\"'/><br/>
  </label>
  <input type='checkbox' name='header' checked='checked'>Format first row as header<br/><br/>
  <input type='submit' />
</form>";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
echo "<h2>Instructions</h2>
<p>Copy & paste cells from Excel and click submit. Paste results into wikipedia or similar wiki.</p>";
} 
else {
	echo "<h2>Result</h2>\n<pre>\n{| ". $_POST['tableclass'] . "\n";
	$lines = preg_split("/\n/", $_POST['data']);
	$n = sizeof($lines);
	foreach ($lines as $index => $value) 
	{
	  $line = preg_split("/\t/", $value);
	  if ($index == 0 && isset($_POST['header'])) 
	  {
		$separator = '!';
	  }
	  else {
		$separator = '|';
	  }
	  $data = implode($separator.$separator, $line);
	  echo $separator .' '. $data;
	  if ($index < $n - 1) 
	  {
		echo "|-\n";
	  }
	}
    echo "\n|}</pre>";
}

echo "</body></html>";

?>
