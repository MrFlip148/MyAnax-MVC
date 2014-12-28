<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu structure
    'items' => [
        // This is a menu item
        'home'  => [
            'text'  => '<i class="fa fa-home fa"></i>',   
            'url'   => '',  
            'title' => 'Home'
        ],
		'reports' => [
            'text' => 'Reports',
            'url' => 'reports',
            'title' => 'Course assignments',
			
			'submenu' => [
				'items' => [
					 'item 1'  => [
                        'text'  => 'Kmom01',
                        'url'   => 'kmom01',
                        'title' => 'Kmom01 Report'
                    ],
					'item 2'  => [
                        'text'  => 'Kmom02',
                        'url'   => 'kmom02',
                        'title' => 'Kmom02 Report'
                    ],
					'item 3'  => [
                        'text'  => 'Kmom03',
                        'url'   => 'kmom03',
                        'title' => 'Kmom03 Report'
                    ],
					'item 4'  => [
                        'text'  => 'Kmom04',
                        'url'   => 'kmom04',
                        'title' => 'Kmom04 Report'
                    ],
				],
			],
		],
        'source' => [
            'text'  => 'Source Code',
            'url'   => 'source',
            'title' => 'Source Code'
        ],
	
        'theme' => [
            'text'  =>'Theme Test', 
            'url'   =>'theme/grid',  
            'title' => 'Theme Test',
        
            'submenu' => [
                'items' => [
                    'grid'  => [ 
                        'text'  => 'Grid',    
                        'url'   => 'theme/grid',   
                        'title' => 'Grid' 
                    ],
                    'regions'  => [ 
                        'text'  => 'Regions',    
                        'url'   => 'theme/regions',   
                        'title' => 'Regions' 
                    ],
                     'typography'  => [ 
                        'text'  => 'Typography',    
                        'url'   => 'theme/typography',   
                        'title' => 'Typography' 
                    ],
                    'font'  => [ 
                        'text'  => 'Font-Awesome',    
                        'url'   => 'theme/font',   
                        'title' => 'Font-Awesome' 
                    ],
                ],
            ],
        ],
		
        'users' => [
            'text'  =>'User Data', 
            'url'   =>'users',  
            'title' => 'Database for Users',
        
			'submenu' => [
				'items' => [
					'list'  => [
						'text'  => 'List',   
						'url'   => 'users/list',   
						'title' => 'List all users',
					],
					'active'  => [
						'text'  => 'Active',   
						'url'   => 'users/active',   
						'title' => 'List all active users',
					],
					'inactive'  => [
						'text'  => 'Inactive',   
						'url'   => 'users/inactive',   
						'title' => 'List all inactive users',
					],
					'trash'  => [
						'text'  => 'Trash',   
						'url'   => 'users/trash',   
						'title' => 'List all soft-deleted users',
					],
					'setup' => [
						'text'  =>'Setup', 
						'url'   =>'users/setup',  
						'title' => 'Reset database table'
					],
					'add' => [
						'text'  =>'Add', 
						'url'   =>'users/add',  
						'title' => 'Add a new user'
					],
				],
			],
		],
	],
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];