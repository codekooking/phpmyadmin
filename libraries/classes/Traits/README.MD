// Custom config.inc.php
$cfg['RestrictedArea'] = [
    'Preferences' => true, // Disallow all "User Preferences"
    'Server' => ['Export', 'Import'], // Disallow "Import, Export database"
];
