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
$data = trim($_POST['data']);
echo "<html>
<head><title>excel2wiki</title>
<link rel='stylesheet' href='style.css' type='text/css' />
</head>
<body><h2>Copy &amp; Paste Excel-to-Wiki Converter</h2>
<p>Copy &amp; paste CSV data or cells from Excel and click submit. Paste results into Wikipedia or similar Wiki.</p>
<form action='index.php' method='post'>
  <textarea name='data' rows='20' cols='100'>$data</textarea><br/><br/>
  <label for='delimiter'>Delimiter
  <select id='delimiter' name='delimiter'>
  <option value='\t' selected>Tab (Excel)</option>
  <option value=';'>Semicolon</option>
  <option value=','>Comma</option>
  <option value=' '>Space</option>
  </select>
  </label>
  <label for='tableclass'>Wiki table style
  <select id='tableclass' name='tableclass'><option></option><option selected>wikitable</option><option>wikitable sortable</option></select>
  </label>
  <label><input type='checkbox' name='header' checked='checked'>Format first row as header</label><br/><br/>
  <button>Convert Text to Wiki Markup</button>
</form>";

if ($data != '')
{
	$delimiter = $_POST['delimiter'];
	$tableclass = $_POST['tableclass'];
	$first_row_as_header = isset($_POST['header']);
	echo "<h2>Wiki Markup</h2>\n<pre>\n{| ";
	if ($tableclass != '')
	{
		$tableclass = 'class="'. $tableclass .'"';
	}
	echo $tableclass ."\n";
	$lines = preg_split("/\n/", $data);
	$n = sizeof($lines);
	foreach ($lines as $index => $line) 
	{
		$separator = ($index == 0 && $first_row_as_header) ? '!' : '|';
		$line = str_replace($separator, "&lt;nowiki&gt;$separator&lt;/nowiki&gt;", $line);
		$values = preg_split('/'.$delimiter.'/', $line);
		echo $separator .' '. implode(" $separator$separator ", $values) . (($index < $n - 1) ? "|-\n" : '');
	}
	echo "\n|}</pre>";
}
echo "<footer><a href='https://github.com/plathub/excel2wiki'>Excel2Wiki Copy and Paste Wiki Converter</a></footer>";
echo "</body></html>";

?>