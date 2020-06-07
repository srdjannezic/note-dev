<?php return [
    'plugin' => [
        'name' => 'Import',
        'description' => 'You can (bulk) upload your custom plugins and themes here and they will become available in their respective sections in October CMS. These plugins and themes are similar to plugins you create using Builder or themes you create within October CMS in that they cannot be automatically updated from the October CMS Marketplace.',
        'notice' => 'You need to sign out and then back in to run database migrations and complete the installation of uploaded plugins.',
        'warning' => 'Plugins and themes will be uploaded and extracted into their respective folders. Folders found in uploaded archives will overwrite existing folders if they have the same name!',
        'success' => 'Archive extracted!',
        'error' => 'Error extracting archive',
        'invalid' => 'Invalid archive (.zip)!',
        'empty' => 'Upload an archive (.zip)!',
        'upload' => 'Upload and extract',
        'label' => 'Upload .zip archive',
        'hint' => 'e.g. Demo.zip',
        'plugins' => 'Plugins',
        'themes' => 'Themes',
    ]
];