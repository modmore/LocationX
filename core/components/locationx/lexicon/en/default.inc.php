<?php

$_lang['locationx'] = 'LocationX';
$_lang['locationx.desc'] = 'LocationX manages, lists and maps your locations.';

$_lang['locationx.store'] = 'Location';
$_lang['locationx.stores'] = 'Locations';
$_lang['locationx.marker'] = 'Map Marker';
$_lang['locationx.markers'] = 'Map Markers';
$_lang['locationx.category'] = 'Category';
$_lang['locationx.categories'] = 'Categories';

$_lang['locationx.address_set'] = 'Location Details';
$_lang['locationx.contact_set'] = 'Contact Details';
$_lang['locationx.general_set'] = 'General Details';
$_lang['locationx.map_set'] = 'Map';
$_lang['locationx.get_latlong'] = 'Get Lat/Long';
$_lang['locationx.name'] = 'Name';
$_lang['locationx.link'] = 'Link';
$_lang['locationx.active'] = 'Active';
$_lang['locationx.rank'] = 'Rank';
$_lang['locationx.address1'] = 'Address';
$_lang['locationx.address2'] = 'Address (2)';
$_lang['locationx.city'] = 'City';
$_lang['locationx.state'] = 'State';
$_lang['locationx.zip'] = 'Zipcode';
$_lang['locationx.country'] = 'Country';
$_lang['locationx.latitude'] = 'Latitude';
$_lang['locationx.longitude'] = 'Longitude';
$_lang['locationx.gmap_marker'] = $_lang['locationx.marker'];
$_lang['locationx.contactperson'] = 'Contact Person';
$_lang['locationx.phone'] = 'Phone';
$_lang['locationx.fax'] = 'Fax';
$_lang['locationx.email'] = 'Email';
$_lang['locationx.image'] = 'Image';
$_lang['locationx.shadow'] = 'Shadow Image';
$_lang['locationx.size'] = 'Size';
$_lang['locationx.origin'] = 'Origin';
$_lang['locationx.flat'] = 'Flat';
$_lang['locationx.visible'] = 'Visible';
$_lang['locationx.xmlfile'] = 'File (.xml)';
$_lang['locationx.xmlfile.upload_fail'] = 'No file, empty file or upload error occurred.';
$_lang['locationx.overwrite_stores'] = 'Update Locations if the ID is in use';
$_lang['locationx.auto_create_categories'] = 'Create Categories that don\'t exist.';
$_lang['locationx.import.get_latlong'] = 'If not set, get Latitude &amp; Longitude from Google';
$_lang['locationx.import.get_latlong.disabled_quote'] = 'This option has been disabled as while it is functional, Google doesn\'t like bulk requests and throws fits on query limits after the first 10 or so.';

$_lang['locationx.create'] = 'Create New [[+what]]';
$_lang['locationx.import'] = 'Import';
$_lang['locationx.activate'] = 'Activate [[+what]]';
$_lang['locationx.deactivate'] = 'Deactivate [[+what]]';
$_lang['locationx.update'] = 'Update [[+what]]';
$_lang['locationx.remove'] = 'Remove [[+what]]';
$_lang['locationx.remove.store.confirm'] = 'Are you absolutely sure you want to remove this Location? There is no way to get it back other than recreating if you click YES below. <br /><br />
If you only want to hide it from your website, you may want to deactive the Location instead: this will keep it safe, but wont show it to your visitors.';
$_lang['locationx.remove.marker.confirm'] = 'Are you absolutely sure you want to remove this Marker? There is no way to get it back other than recreating if you click YES below. <br /><br />
Any locations currently using this Marker will be set to the Google Default marker.';
$_lang['locationx.remove.category.confirm'] = 'Are you absolutely sure you want to remove this Category? There is no way to get it back other than recreating if you click YES below. <br /><br />
Any locations currently using this Category will be marked as uncategorized.';
$_lang['locationx.duplicate'] = 'Duplicate [[+what]]';
$_lang['locationx.filter'] = 'Filter on [[+what]]';
$_lang['locationx.query'] = 'Search...';
$_lang['locationx.clear_filter'] = 'Clear Filter';

$_lang['locationx.error.noresults'] = 'Sorry, no [[+what]] found.';
$_lang['locationx.err_ns_name'] = 'Name not specified.';
$_lang['locationx.err_ae_name'] = 'Name already exists.';

$_lang['locationx.default_marker'] = 'Google Default';
$_lang['locationx.uncategorized'] = 'Uncategorized';

$_lang['locationx.import.initiated'] = 'Import initiated, uploading file...';
$_lang['locationx.import.file_received'] = 'File received. Amount of data: [[+size]]';
$_lang['locationx.import.parsing_xml'] = 'Parsing XML...';
$_lang['locationx.import.missing_simplexml'] = '<a href="http://php.net/manual/en/book.simplexml.php">SimpleXML</a> is not available on the server. Unable to continue.';
$_lang['locationx.import.error_parsing_xml'] = 'Error parsing XML, file might be damaged or uses invalid syntax.';
$_lang['locationx.import.error_xml_misses_lxstore'] = 'XML file seems to be empty: does not contain lxStore objects.';
$_lang['locationx.import.error.lat_long'] = 'Unable to get latitude/longitude for [[+name]]: [[+message]]';
$_lang['locationx.import.done'] = 'Done.';
