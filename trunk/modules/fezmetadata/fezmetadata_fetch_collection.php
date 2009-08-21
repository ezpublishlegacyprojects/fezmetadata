<?php

class feZMetaDataFetchCollection
{
	function feZMetaDataFetchCollection()
	{
	}

	function fetchMetaData ( $metaDataID )
	{
        return array( 'result' => feZMetaData::fetch( $metaDataID ) );
	}

	function fetchByNodeID( $nodeID )
	{
		$retMetaData = feZMetaData::fetchByNodeID( $nodeID);
		return array( 'result' => $retMetaData );
	}

    function fetchBySubTree($nodeID, $depth)
    {
        $retMetaData = feZMetaData::fetchBySubTree( $nodeID, $depth);
        return array( 'result' => $retMetaData );
    }

	function checkAccess( $functionName, $contentObject )
	{
		if( $contentObject instanceof feZMetaData and $functionName)
		{
			$result = $contentObject->checkAccess( $functionName );
			return array( 'result' => $result );
		}
		else
		{
			$user = eZUser::currentUser();
        	$userID = $user->attribute( 'contentobject_id' );

		    $accessResult = $user->hasAccessTo( 'fezmetadata', $functionName );
		    $accessWord = $accessResult['accessWord'];

    		if( $accessWord == 'yes' )
	    	{
		    	return 1;
    		}
	    	else
		    {
    			return 0;
	    	}
		}
	}
}
