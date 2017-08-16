<?php
$url = 'https://twitter.com/search?f=tweets&vertical=default&q=sarahah.com&src=typd';
$refresh=10;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$response = curl_exec($curl);
curl_close($curl);
preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $response, $match);
$check = [];
$existing = file('collected.txt', FILE_IGNORE_NEW_LINES);
$usernames = [];
$file = fopen('collected.txt', 'a');
foreach( array_unique( $match[0] ) AS $url )
{
    if( strpos( $url, '.sarahah.com' ) !== false )
    {
        $pieces = explode('.', str_replace(['http://','https://'],'',$url));
        if( $pieces[0] != 'www' && !in_array($pieces[0],$existing) ) $usernames[] = $pieces[0];
    }
}
foreach( array_unique( $usernames ) AS $username )
{
    fwrite($file, $username."\n");
}
fclose($file);
print 'done';
print '<meta http-equiv="refresh" content="'.$refresh.'">';
