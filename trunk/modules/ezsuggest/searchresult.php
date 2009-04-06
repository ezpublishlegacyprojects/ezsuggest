<?php
include_once( 'kernel/common/template.php' );

$db = eZDB::instance();
$rows = $db->arrayQuery( 'SELECT word, object_count FROM ezsearch_word where word like "'.$_GET['keyword'].'%" order by object_count desc limit 20' );

$xmlResult = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><results></results>');

foreach ( $rows as $row ) {
	$resultXmlNode = $xmlResult->addChild('result');
	$resultXmlNode->addChild('word',$row['word']);
	$resultXmlNode->addChild('count',$row['object_count']);
}

$tpl = templateInit();
$tpl->setVariable('xmlResult',$xmlResult->asXML());
$pagelayoutResult = $tpl->fetch( 'design:ezsuggest_pagelayout.tpl' );


eZDisplayResult( $pagelayoutResult );

// Stop execution at this point, if we do not we'll have the 
// pagelayout.tpl inside another pagelayout.tpl.
eZExecution::cleanExit();
?>
