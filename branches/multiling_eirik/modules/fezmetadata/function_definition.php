<?php

$FunctionList[] = array();

$FunctionList['list_by_node_id'] = array( 'name' => 'list_by_node_id',
							   			  'operation_types' => array( 'read' ),
										  'call_method' => array( 'class' => 'feZMetaDataFetchCollection', 'method' => 'fetchByNodeID' ),
										  'parameter_type' => 'standard',
										  'parameters' => array( 
										  						array( 'name' => 'node_id',
																	   'type' => 'integer',
																	   'required' => true,
																	   'default' => 0 ),
										  						array( 'name' => 'language',
																	   'type' => 'string',
																	   'required' => false,
																	   'default' => '' ) ) );

$FunctionList['tree_by_node_id'] = array( 'name' => 'tree_by_node_id',
                                          'operation_types' => array( 'read' ),
                                          'call_method' => array( 'class' => 'feZMetaDataFetchCollection', 'method' => 'fetchBySubTree' ),
                                          'parameter_type' => 'standard',
                                          'parameters' => array(
                                                                array( 'name' => 'node_id',
                                                                       'type' => 'integer',
                                                                       'required' => true,
                                                                       'default' => 0 ),
                                                                array( 'name' => 'depth',
                                                                       'type' => 'integer',
                                                                       'required' => true,
                                                                       'default' => 0 ),
                                                                array( 'name' => 'language',
																	   'type' => 'string',
																	   'required' => false,
																	   'default' => '' ) ) );


$FunctionList['access'] = array( 'name' => 'access',
								 'operator_types' => array( 'read' ),
								 'call_method' => array( 'class' => 'feZMetaDataFetchCollection', 'method' => 'checkAccess' ),
								 'parameter_type' => 'standard',
								 'parameters' => array(
								 						array( 'name' => 'access',
															   'type' => 'string',
															   'required' => 'true',
															   'default' => '' ),
														array( 'name' => 'contentobject',
															   'type' => 'object',
															   'required' => true,
															   'default' => 0 ) ) );
										
?>
