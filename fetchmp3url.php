<?php
$mysql = new SaeMysql();

$sql = "SELECT sid,ssid FROM songs WHERE syncmp3 = 0";

$songs = $mysql->getData( $sql );

foreach($songs as $song){
    echo sprintf("http://music.douban.com/j/songlist/get_song_url?sid=%s&ssid=%s<br>",$song['sid'],$song['ssid']);
}

$mysql->closeDb();