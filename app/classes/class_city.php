<?php

header('Content-Type: application/json');

$url = "https://data.gov.il/api/3/action/datastore_search?resource_id=ad16434d-85b2-4b61-b8a7-3616589913a5&limit=1000";
$response = file_get_contents($url);
$data = json_decode($response, true);

$cities = [];

if (isset($data['result']['records'])) 
{
    foreach ($data['result']['records'] as $record) 
    {
        $cities[] = $record['שם_ישוב'];
    }
}

echo json_encode($cities);

?>