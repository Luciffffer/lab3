<?php

function getPlaylists ($pdo) {
    $playlistQuery = $pdo->prepare('select * from playlists');
    $playlistQuery->execute();
    return $playlistQuery->fetchAll();
}