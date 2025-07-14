<?php
// This file is generated. Do not modify it manually.
return array(
	'gradientblock' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'alethoblocks/gradientblock',
		'version' => '0.1.0',
		'title' => 'Gradientblock',
		'category' => 'widgets',
		'attributes' => array(
			'blockContent' => array(
				'type' => 'string',
				'default' => 'IT-trajecten en begeleiding'
			),
			'allowedBlocks' => array(
				'type' => 'array'
			),
			'templateLock' => array(
				'type' => array(
					'string',
					'boolean'
				),
				'enum' => array(
					'all',
					'insert',
					'contentOnly',
					false
				)
			)
		),
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'gradientblock',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	)
);
