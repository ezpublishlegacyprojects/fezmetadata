<?php

class feZMetaDataFetchCollection
{
	function feZMetaDataFetchCollection()
	{
	}

	function fetchMetaData ( $metaDataID )
	{
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
			var_dump( $result );
			return array( 'result' => $result );
		}
		else
		{
			$user = eZUser::currentUser();
        	$userID = $user->attribute( 'contentobject_id' );

		$accessResult = $user->hasAccessTo( 'fezmetadata', $functionName );
		var_dump( $accessResult );
		$accessWord = $accessResult['accessWord'];


		if( $accessWord == 'yes' )
		{
			echo "ok";
			return 1;
		}
		else
		{
			echo "no";
			return 0;
		}
		}

	}
}
