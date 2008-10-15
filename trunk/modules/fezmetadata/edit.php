<?php
//
// Created on: <7-Jui-2008 10:18:22 sp>
//
// SOFTWARE NAME: feZ Meta Data
// SOFTWARE RELEASE: 1.0.0
// COPYRIGHT NOTICE: Copyright (C) 2008 Frédéric DAVID
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//

$metaID = $Params['metaID'];
$Module = $Params['Module'];
$http = eZHTTPTool::instance();

if( $http->hasPostVariable( 'PublishButton' ) )
{
	// Check content variable
	$fieldsOk = true;
	$ContentObjectID = $http->postVariable( 'ContentObjectID' );
	$MetaName = $http->postVariable( 'metaDataName' );
	$MetaValue = $http->postVariable('metaDataValue' );

	if( $metaID == 0 )
	{
		$MetaDataObject = feZMetaData::create( $MetaName, $MetaValue, $ContentObjectID );
	}
	else
	{
		$MetaDataObject = feZMetaData::fetch( $metaID );
		$MetaDataObject->setAttribute( 'meta_value', $MetaValue );
	}

	$MetaDataObject->store();
	eZContentCacheManager::clearContentCache( $ContentObjectID );
	$ContentObject = eZContentObject::fetch( $ContentObjectID );
	$ContentNodeID = $ContentObject->mainNodeID();
	return $Module->redirectToView( 'view', array( 'full', $ContentNodeID ) );
}

if( $http->hasPostVariable( 'DiscardButton' ) )
{
	if( $http->hasPostVariable( 'ContentObjectID') )
	{
		$ContentObject = eZContentObject::fetch( $ContentObjectID );
		$ContentNodeID = $ContentObject->mainNodeID();
		return $Module->redirectToView( 'view', array( 'full', $ContentNodeID ) );
	}
}

if( is_numeric( $metaID ) and $metaID == 0 )
{
	$contentObjectID = $Params[ 'contentObjectID' ];
	$contentObject = eZContentObject::fetch( $contentObjectID );
	$metaObject = feZMetaData::create( null, null, $contentObjectID );
}
else
{
	$metaObject = feZMetaData::fetch( $metaID );
	$contentObject = eZContentObject::fetch( $metaObject->attribute( 'contentobject_id') );
}

if( !$contentObject->attribute('can_edit') )
{
	return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel',
                                 array( 'AccessList' => $obj->accessList( 'edit' ) ) );
}

$MetaDataINI = eZINI::instance( 'ezmetadata.ini' );
$AvailableMetaData = $MetaDataINI->variable( 'MetaData', 'AvailablesMetaData' );

foreach( $AvailableMetaData as $MetaData )
{
	if( $MetaDataINI->hasVariable( 'MetaData_'.$MetaData ) )
	{

	}
}

include_once( 'kernel/common/template.php' );
$tpl = templateInit();

$tpl->setVariable( 'object', $metaObject );

$Result = array();

$Result['path'] = array( array( 'url' => false,
								'text' => 'feZ Meta Data' ),
						array( 'url' => false,
							   'text' => 'Edit' )
						);

$Result['content'] = $tpl->fetch( 'design:fezmetadata/edit.tpl' );

?>
