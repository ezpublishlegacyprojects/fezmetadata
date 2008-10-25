<?php

$Module = array( 'name' => 'fezmetadata', 'variable_params' => false, 'ui_component_match' => 'module' );

$ViewList = array();

$ViewList['edit'] = array( 
						'script' => 'edit.php',
						'functions' => array( 'edit or create' ),
						'params' => array( 'metaID' ),
						'unordered_params' => array( 'contentObjectID' => 'contentObjectID' ),
						'ui_context' => 'edit',
						'ui_component' => 'fezmetadata',
						'default_navigation_part' => 'fezmetadatanavigationpart',
						'single_post_actions' => array( 'PublishButton' => 'Publish' )
						);

$FunctionList = array();

$ClassID = array(
    'name'=> 'Class',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezcontentclass.php',
    'class' => 'eZContentClass',
    'function' => 'fetchList',
    'parameter' => array( 0, false, false, array( 'name' => 'asc' ) )
    );

$ParentClassID = array(
    'name'=> 'ParentClass',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezcontentclass.php',
    'class' => 'eZContentClass',
    'function' => 'fetchList',
    'parameter' => array( 0, false, false, array( 'name' => 'asc' ) )
    );

$SectionID = array(
    'name'=> 'Section',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezsection.php',
    'class' => 'eZSection',
    'function' => 'fetchList',
    'parameter' => array( false )
    );

$Language = array(
    'name'=> 'Language',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezcontentlanguage.php',
    'class' => 'eZContentLanguage',
    'function' => 'fetchLimitationList',
    'parameter' => array( false )
    );

$Node = array(
    'name'=> 'Node',
    'values'=> array()
    );

$Subtree = array(
    'name'=> 'Subtree',
    'values'=> array()
    );

$FunctionList['create'] = array( 'Class' => $ClassID, 
								 'Section' => $SectionID,
								 'ParentClass' => $ParentClassID,
								 'Node'  => array_merge(  $Node, array( 'DropList' => array( 'ParentClass', 'Section' ) ) ),
                                 'Subtree' => $Subtree,
                                 'Language' => $Language
                                 );
$FunctionList['edit'] = array( 'Class' => $ClassID, 
								 'Section' => $SectionID,
								 'ParentClass' => $ParentClassID,
								 'Node'  => array_merge(  $Node, array( 'DropList' => array( 'ParentClass', 'Section' ) ) ),
                                 'Subtree' => $Subtree,
                                 'Language' => $Language
                                 );

$FunctionList['remove'] = array( 'Class' => $ClassID, 
								 'Section' => $SectionID,
								 'ParentClass' => $ParentClassID,
								 'Node'  => array_merge(  $Node, array( 'DropList' => array( 'ParentClass', 'Section' ) ) ),
                                 'Subtree' => $Subtree,
                                 'Language' => $Language
                                 );



?>
