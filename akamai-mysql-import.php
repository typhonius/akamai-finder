<?php

# Comment this out and fill in variables to migrate the XML file into a MySQL database.
exit;

$db_name = 'FILLME';
$db_user = 'FILLME';
$db_pass = 'FILLME';
$db_host = 'FILLME';
$db_port = 'FILLME';

$path = getcwd() . "/akamai_gnet_public.xml";
$xml = simplexml_load_file ($path);
$akamai = json_decode(json_encode($xml), TRUE);

$dbh = new PDO('mysql:host=' . $db_host . ';dbname' . $db_name . ';port=' . $db_port . ';charset=utf8', $db_user, $db_pass);

try {
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->beginTransaction();

  foreach ($akamai['location'] as $location) {
    $stmt = $dbh->prepare("INSERT INTO locations (latitude, longitude, hits, connections, continent, country, region, city, ghosts, candle) VALUES (:latitude, :longitude, :hits, :connections, :continent, :country, :region, :city, :ghosts, :candle)");

    $geo = explode('/', $location['name']);
    $location['continent'] = $geo[1];
    $location['country'] = $geo[2];
    $location['region'] = $geo[3];
    $location['city'] = $geo[4];

    $stmt->bindParam(':latitude', $location['latitude']);
    $stmt->bindParam(':longitude', $location['longitude']);
    $stmt->bindParam(':hits', $location['hits']);
    $stmt->bindParam(':connections', $location['connections']);
    $stmt->bindParam(':ghosts', $location['ghosts']);
    $stmt->bindParam(':candle', $location['candle']);
    $stmt->bindParam(':continent', $location['continent']);
    $stmt->bindParam(':country', $location['country']);
    $stmt->bindParam(':region', $location['region']);
    $stmt->bindParam(':city', $location['city']);

    $stmt->execute();

  }

  $dbh->commit();

} catch (Exception $e) {
  $dbh->rollBack();
  echo "Failed: " . $e->getMessage();
}

$dbh = null;

