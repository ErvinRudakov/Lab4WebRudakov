<?php
error_reporting(E_ERROR | E_PARSE);
require_once ('../vendor/autoload.php');

$googleAccountKeyFilePath = __DIR__ . '/assets/sheets-integration-for-ads-1bd62cdb84ca.json';
putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );

$client = new Google_Client();
$client->useApplicationDefaultCredentials();


$client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

$service = new Google_Service_Sheets( $client );


$spreadsheetId = '1qQcfLedf2YMp03mL_3lbyKNVyggwPKUFNttXrsVNlIY';

//Отправка запроса
if (
    array_key_exists('email', $_POST)
    && array_key_exists('category', $_POST)
    && array_key_exists('header', $_POST)
    && array_key_exists('content', $_POST)
)
{
    $values = [[$_POST['email'], $_POST['category'], $_POST['header'], $_POST['content']]];

    $body = new Google_Service_Sheets_ValueRange();
    $body->setValues($values);
    $options = array( 'valueInputOption' => 'RAW' );
    $service->spreadsheets_values->append( $spreadsheetId, 'Лист1', $body, $options );

    header('Location: index.php');
}

$categories = ['Home', 'Buy', 'Sell', 'Work'];
$categoriesHTML = '';
foreach ($categories as $category)
{
    $categoriesHTML .= "<option>$category</option>";
}

echo '<form action="" method="post">
		<p>Email<p>
    	<input type="email" name="email"/>
    	<p>Category<p>
    	<select name="category">'
    . $categoriesHTML .
    '</select>
    	<p>Header<p>
    	<input type="text" name="header"/>
    	<p>Content<p>
    	<textarea rows="10" cols="40" name="content"></textarea>
    	<input type="submit" value="Отправить">
  	  </form>';