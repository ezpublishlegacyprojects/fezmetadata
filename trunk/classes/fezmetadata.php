<?php
//
// Definition of feZMetaData class
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

/*! \file fezmetadata.php
*/

/*!
  \class feZMetaData fezmetadata.php
  \brief Handles eZ publish meta data

  It encapsulates the data for a meta data and provides functions for dealing with attributes.

*/

class feZMetaData extends eZPersistentObject
{
	/*!
     Constructor
    */
    function feZMetaData( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

	static function definition()
	{
		return array( 'fields' => array( "id" => array( 'name' => "MetaID",
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
									 	 "contentobject_id" => array( 'name' => "ContentObjectID",
                                                                      'datatype' => 'integer',
                                                                      'default' => 0,
                                                                      'required' => true,
                                                                      'foreign_class' => 'eZContentObject',
                                                                      'foreign_attribute' => 'id',
                                                                      'multiplicity' => '1..*' ),
										 "meta_name" => array( 'name' => 'MetaName',
										 				  'datatype' => 'text',
														  'default' => '',
														  'required' => true ),
										 "meta_value" => array( 'name' => 'MetaValue',
										 				   'datatype' => 'text',
														   'default' => '',
														   'required' => true ) ),
					'keys' => array( 'id' ),
					'function_attributes' => array( 'object' => 'object',
													'can_read' => 'canRead',
													'can_create' => 'canCreate',
													'can_edit' => 'canEdit',
													'can_remove' => 'canRemove',
													'creator' => 'creator',
													'name' => 'getName',
													'value' => 'getValue' ),
					'increment_key' => 'id',
					'class_name' => 'feZMetaData',
					'name' => 'fezmeta_data' );
	}

	/*!
	 Create a new meta data and returns it.
	 \param $metaName The Meta Name like keywords or description
	 \param $metaValue The Meta value
	 \param $contentObjectID the ID of the Content Object
	 \return Meta Data Object
	 \static
	*/
	static function create( $metaName = null, $metaValue = null, $contentObjectID = null )
	{
		$rows = array( 'id' => null,
					   'meta_name' => $metaName,
					   'meta_value' => $metaValue,
					   'contentobject_id' => $contentObjectID );
		$meta = new feZMetaData( $rows );
		return $meta;
	}
	
	/*!
	 Returns the translation of the Meta Name
	*/
	function getName()
	{
		$ini = eZINI::instance('ezmetadata.ini');
		$metaName = $this->attribute('meta_name');
		if( in_array( $metaName, $ini->variable( 'MetaData', 'AvailablesMetaData' ) ) )
		{
			$metaName = ezi18n( 'fezmetadata', $ini->variable( 'MetaData_'.$metaName, 'Name' ) );
		}
		return $metaName;
	}

	/*!
	 Return the value of the meta object
	*/
	function getValue()
	{
		return $this->attribute('meta_value');
	}

	function checkAccess( $functionName )
	{
        $user = eZUser::currentUser();
        $userID = $user->attribute( 'contentobject_id' );

		$accessResult = $user->hasAccessTo( 'fezmetadata', $functionName );
		$accessWord = $accessResult['accessWord'];

		if( $accessWord == 'yes' )
			return 1;
		else
			return 0;
	}

	/*!
     \return \c true if the node can be read by the current user.
     \sa checkAccess().
     \note The reference for the return value is required to workaround
           a bug with PHP references.
    */
    function canRead( )
    {
        if ( !isset( $this->Permissions["can_read"] ) )
        {
            $this->Permissions["can_read"] = $this->checkAccess( 'read' );
        }
        return ( $this->Permissions["can_read"] == 1 );
    }


	/*!
     \return \c true if the current user can create a new node as child of this node.
     \sa checkAccess().
     \note The reference for the return value is required to workaround
           a bug with PHP references.
    */
    function canCreate( )
    {
        if ( !isset( $this->Permissions["can_create"] ) )
        {
            $this->Permissions["can_create"] = $this->checkAccess( 'create' );
        }
        return ( $this->Permissions["can_create"] == 1 );
    }

    /*!
     \return \c true if the node can be removed by the current user.
     \sa checkAccess().
     \note The reference for the return value is required to workaround
           a bug with PHP references.
    */
    function canRemove( )
    {
        if ( !isset( $this->Permissions["can_remove"] ) )
        {
            $this->Permissions["can_remove"] = $this->checkAccess( 'remove' );
        }
        return ( $this->Permissions["can_remove"] == 1 );
    }


	/*!
     \return \c true if the node can be edited by the current user.
     \sa checkAccess().
     \note The reference for the return value is required to workaround
           a bug with PHP references.
    */
    function canEdit( )
    {
        if ( !isset( $this->Permissions["can_edit"] ) )
        {
            $this->Permissions["can_edit"] = $this->checkAccess( 'edit' );
            if ( $this->Permissions["can_edit"] != 1 )
            {
                 $user = eZUser::currentUser();
                 if ( $user->id() == $this->ContentObject->attribute( 'id' ) )
                 {
                     $access = $user->hasAccessTo( 'user', 'selfedit' );
                     if ( $access['accessWord'] == 'yes' )
                     {
                         $this->Permissions["can_edit"] = 1;
                     }
                 }
            }
        }
        return ( $this->Permissions["can_edit"] == 1 );
    }

	/*!
     \return the creator of the meta data.
     \note The reference for the return value is required to workaround
           a bug with PHP references.
    */
    function creator()
    {
        $db = eZDB::instance();
        $query = "SELECT creator_id
                  FROM ezcontentobject_version
                  WHERE
                        contentobject_id = '$this->ContentObjectID' ";

        $creatorArray = $db->arrayQuery( $query );
        return eZContentObject::fetch( $creatorArray[0]['creator_id'] );
    }
	/*!
     \return the object of the meta data.
     \note The reference for the return value is required to workaround
           a bug with PHP references.
    */
	function object()
    {
        if ( $this->hasContentObject() )
        {
            return $this->ContentObject;
        }
        $contentobject_id = $this->attribute( 'contentobject_id' );
        $obj = eZContentObject::fetch( $contentobject_id );
        $obj->setCurrentLanguage( $this->CurrentLanguage );
        $this->ContentObject = $obj;
        return $obj;
    }

    function hasContentObject()
    {
        if ( isset( $this->ContentObject ) && $this->ContentObject instanceof eZContentObject )
            return true;
        else
            return false;
    }

    /*!
     Sets the current content object for this node.
    */
    function setContentObject( $object )
    {
        $this->ContentObject = $object;
    }

	/*!
	\static
	 Fetch the meta data object with the given ID
	 \return the meta data object
	*/
	static function fetch( $metaID , $asObject = true)
	{
		$returnValue = null;
        $db = eZDB::instance();
		if( is_numeric( $metaID ) )
		{
			$query = "SELECT fezmeta_data.*
					  FROM fezmeta_data
					  WHERE id = $metaID";

			$metaDataArrayList = $db->arrayQuery( $query );
			if ( count( $metaDataArrayList ) === 1 )
			{
				if ( $asObject )
				{
					$returnValue =  feZMetaData::makeObjectArray( $metaDataArrayList[0] );
				}
				else
				{
					$returnValue = $metaDataArrayList[0];
				}
			}
		}

		return $returnValue;
	}

	/*!
	 Fetch all the meta data object associated at the node
	 \return Meta Data Collection
	*/
	static function fetchByNodeID( $nodeID, $asObject = true )
	{
		$retArray = array();
        $db = eZDB::instance();
		if( is_numeric( $nodeID ) )
		{
			$query = "SELECT fezmeta_data.*
					  FROM fezmeta_data, ezcontentobject, ezcontentobject_tree
					  WHERE ezcontentobject_tree.contentobject_id = ezcontentobject.id
					  AND ezcontentobject.id = fezmeta_data.contentobject_id
					  AND ezcontentobject_tree.node_id = $nodeID ";
			$metaDataList = $db->arrayQuery( $query );
			foreach( $metaDataList as $metaData )
			{
				if( $asObject )
				{
					$retArray[] = feZMetaData::makeObjectArray( $metaData );
				}
				else
				{
					$retArray[] = $metaData;
				}
			}
		}

		return $retArray;
	}

    /*!
	 Fetch all the meta data object associated at the node. Uses parent node metas
	 for those which are empty.	 
	 \return Meta Data Collection
	*/
	static function fetchBySubTree($nodeID, $depth, $asObject = true)
	{
		$ini = eZINI::instance('ezmetadata.ini');
		$metasList = $ini->variable('MetaData','AvailablesMetaData');
		$metasListState = array();
		foreach($metasList as $metaName)
		{
			$metasListState[$metaName] = false;
		}
		
		return self::searchMetas($nodeID, $depth, array(), $metasListState);
	}
	
	private static function searchMetas($nodeID, $depth, $retArray, $metasListState)
	{
		if($nodeID == $limitNodeID)
		{
			return $retArray;
		}

		$metasNode = self::fetchByNodeID($nodeID);
 		// update of the metas which are not defined
		foreach($metasNode as $meta)
		{
			$name = $meta->attribute('meta_name');
			if(!$metasListState[$name])
			{
				$metasListState[$name] = true;
				$retArray[] = $meta;
			}
		}	
		
		// If all metas are defined or the depth is over
		if(count($retArray) == count($metasListState) || $depth == 0)
		{
			return $retArray;
		}
		// Else we try to complete the array with metas of the parent node
		$node = eZContentObjectTreeNode::fetch($nodeID);
		// Case of the root node
		if($node->object()->ID == 1)
		{
			return $retArray;
		}
		return self::searchMetas($node->object()->mainParentNodeID(), $depth - 1, $retArray, $metasListState);
	}

	/*!
	 Fetch all the meta data object associated at the object
	 \param $contentObjectID The Content Object ID
	 \param $asObject Determine if 
	 \return Meta Data Collection
	*/

	static function fetchByContentObjectID( $contentObjectID, $asObject = true )
	{
		$retNodes = array();
		$db = eZDB::instance();
		if( is_numeric( $contentObjectID ) )
		{
			$query = "SELECT fezmeta_data.*
					  FROM fezmeta_data 
					  WHERE fezmeta_data.contentobject_id = $contentObjectID ";
			$metaDataList = $db->arrayQuery( $query );
			foreach( $metaDataList as $metaData )
			{
				if( $asObject )
				{
					$retArray[] = feZMetaData::makeObjectArray( $metaData );
				}
				else
				{
					$retArray[] = $metaData;
				}
			}
		}
	}

	static function makeObjectArray( $array )
	{
		$retNodes = null;
		if( !is_array( $array ))
			return $retNodes;

		unset( $object );
		$object = new feZMetaData( $array);

		return $object;
	}
}

?>
