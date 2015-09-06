<?php

define('AKAMAI_NODES_LOCATION', 'http://wwwnui.akamai.com/gnet/gnet_public.xml');

function akamai_finder_table() {
  header("Cache-Control: max-age=86400");
  $header = akamai_finder_header();
  $rows = akamai_finder_rows();
  return '<table>' . $header . '<tbody>' . $rows . '</tbody></table>';
}

function akamai_finder_header() {
  return '<thead>
            <tr>
              <th>City</th>
              <th>Region</th>
              <th>Country</th>
              <th>Continent</th>
              <th>GHosts</th>
              <th>Hits</th>
              <th>Longitude</th>
              <th>Latitude</th>
              <th>Candle</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>City</th>
              <th>Region</th>
              <th>Country</th>
              <th>Continent</th>
              <th>GHosts</th>
              <th>Hits</th>
              <th>Longitude</th>
              <th>Latitude</th>
              <th>Candle</th>
            </tr>
            <tr>
            <th colspan="9" class="ts-pager form-horizontal">
              <button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
              <button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
              <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
              <button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
              <button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
              <select class="pagesize input-mini" title="Select page size">
                <option selected="selected" value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
              </select>
              <select class="pagenum input-mini" title="Select page number"></select>
            </th>
          </tr>
        </tfoot>';

}

function akamai_finder_rows($local = TRUE) {
  // Mapping of country code to country from https://github.com/devasur/kivasearch
  $countrymap = json_decode(file_get_contents('./slim-2.json'));
  foreach ($countrymap as $country) {
    $cmap[$country->{'alpha-2'}] = $country->name;
  }

  // Load the Akamai file from into a SimpleXML object.
  $akamai_xml = akamai_finder_load_nodes(TRUE);

  $rows = '';
  foreach ($akamai_xml->location as $location) {
    $geo = explode('/', $location->name);
    $continent = $geo[1];
    $country = $cmap[$geo[2]];
    $region = $geo[3];
    $city = $geo[4];
    $rows .= '<tr><td>' . $city . '</td><td>' . $region . '</td><td>' . $country . '</td><td>' . $continent . '</td><td>' . $location->ghosts . '</td><td>' . $location->hits . '</td><td>' . $location->longitude . '</td><td>' . $location->latitude . '</td><td>' . $location->candle . '</td></tr>';
  }
  return $rows;
}

// Loads the Akamai origin servers from either the source or the local cache.
function akamai_finder_load_nodes($local = TRUE) {
  if ($local !== TRUE) {
    if ($xml = @simplexml_load_file(AKAMAI_NODES_LOCATION, 'SimpleXMLElement', LIBXML_NOCDATA) !== FALSE) {
      return $xml;
    }
  }
  return simplexml_load_file('./akamai_gnet_public.xml');
}
