<?php

$_lang['storesx'] = 'StoresX';
$_lang['storesx.desc'] = 'StoresX manages, lists and maps your locations.';

$_lang['storesx.store'] = 'Location';
$_lang['storesx.stores'] = 'Locations';
$_lang['storesx.marker'] = 'Map Marker';
$_lang['storesx.markers'] = 'Map Markers';
$_lang['storesx.category'] = 'Category';
$_lang['storesx.categories'] = 'Categories';

$_lang['storesx.address_set'] = 'Location Details';
$_lang['storesx.contact_set'] = 'Contact Details';
$_lang['storesx.general_set'] = 'General Details';
$_lang['storesx.map_set'] = 'Map';
$_lang['storesx.get_latlong'] = 'Get Lat/Long';
$_lang['storesx.name'] = 'Name';
$_lang['storesx.link'] = 'Link';
$_lang['storesx.active'] = 'Active';
$_lang['storesx.rank'] = 'Rank';
$_lang['storesx.address1'] = 'Address';
$_lang['storesx.address2'] = 'Address (2)';
$_lang['storesx.city'] = 'City';
$_lang['storesx.state'] = 'State';
$_lang['storesx.zip'] = 'Zipcode';
$_lang['storesx.country'] = 'Country';
$_lang['storesx.latitude'] = 'Latitude';
$_lang['storesx.longitude'] = 'Longitude';
$_lang['storesx.gmap_marker'] = $_lang['storesx.marker'];
$_lang['storesx.contactperson'] = 'Contact Person';
$_lang['storesx.phone'] = 'Phone';
$_lang['storesx.fax'] = 'Fax';
$_lang['storesx.email'] = 'Email';
$_lang['storesx.image'] = 'Image';
$_lang['storesx.shadow'] = 'Shadow Image';
$_lang['storesx.size'] = 'Size';
$_lang['storesx.origin'] = 'Origin';
$_lang['storesx.flat'] = 'Flat';
$_lang['storesx.visible'] = 'Visible';
$_lang['storesx.xmlfile'] = 'File (.xml)';
$_lang['storesx.xmlfile.upload_fail'] = 'No file, empty file or upload error occurred.';
$_lang['storesx.overwrite_stores'] = 'Update Stores if the ID is in use';
$_lang['storesx.auto_create_categories'] = 'Create Categories that don\'t exist.';
$_lang['storesx.import.get_latlong'] = 'If not set, get Latitude &amp; Longitude from Google';
$_lang['storesx.import.get_latlong.disabled_quote'] = 'This option has been disabled as while it is functional, Google doesn\'t like bulk requests and throws fits on query limits after the first 10 or so.';

$_lang['storesx.create'] = 'Create New [[+what]]';
$_lang['storesx.import'] = 'Import';
$_lang['storesx.activate'] = 'Activate [[+what]]';
$_lang['storesx.deactivate'] = 'Deactivate [[+what]]';
$_lang['storesx.update'] = 'Update [[+what]]';
$_lang['storesx.remove'] = 'Remove [[+what]]';
$_lang['storesx.remove.store.confirm'] = 'Are you absolutely sure you want to remove this Store? There is no way to get it back other than recreating if you click YES below. <br /><br />
If you only want to hide it from your website, you may want to deactive the Store instead: this will keep it safe, but wont show it to your visitors.';
$_lang['storesx.remove.marker.confirm'] = 'Are you absolutely sure you want to remove this Marker? There is no way to get it back other than recreating if you click YES below. <br /><br />
Any locations currently using this Marker will be set to the Google Default marker.';
$_lang['storesx.remove.category.confirm'] = 'Are you absolutely sure you want to remove this Category? There is no way to get it back other than recreating if you click YES below. <br /><br />
Any locations currently using this Category will be marked as uncategorized.';
$_lang['storesx.duplicate'] = 'Duplicate [[+what]]';
$_lang['storesx.filter'] = 'Filter on [[+what]]';
$_lang['storesx.query'] = 'Search...';
$_lang['storesx.clear_filter'] = 'Clear Filter';

$_lang['storesx.error.noresults'] = 'Sorry, no [[+what]] found.';
$_lang['storesx.err_ns_name'] = 'Name not specified.';
$_lang['storesx.err_ae_name'] = 'Name already exists.';

$_lang['storesx.default_marker'] = 'Google Default';
$_lang['storesx.uncategorized'] = 'Uncategorized';

$_lang['storesx.import.initiated'] = 'Import initiated, uploading file...';
$_lang['storesx.import.file_received'] = 'File received. Amount of data: [[+size]]';
$_lang['storesx.import.parsing_xml'] = 'Parsing XML...';
$_lang['storesx.import.missing_simplexml'] = '<a href="http://php.net/manual/en/book.simplexml.php">SimpleXML</a> is not available on the server. Unable to continue.';
$_lang['storesx.import.error_parsing_xml'] = 'Error parsing XML, file might be damaged or uses invalid syntax.';
$_lang['storesx.import.error_xml_misses_sxstore'] = 'XML file seems to be empty: does not contain sxStore objects.';
$_lang['storesx.import.error.lat_long'] = 'Unable to get latitude/longitude for [[+name]]: [[+message]]';
$_lang['storesx.import.done'] = 'Done.';
