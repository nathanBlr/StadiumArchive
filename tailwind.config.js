import preset from './vendor/filament/support/tailwind.config.preset'
 
export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        './vendor/awcodes/filament-curator/resources/**/*.blade.php',
    ],
    plugins: [
        require('flowbite/plugin')
    ],
}