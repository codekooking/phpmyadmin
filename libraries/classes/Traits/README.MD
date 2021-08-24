// Custom config.inc.php, only apply in case you need restricted special route
$cfg['RestrictedArea'] = [
    'Preferences' => true, // Disallow all "User Preferences"
    'Server' => ['Export', 'Import'], // Disallow "Import, Export database"
];
