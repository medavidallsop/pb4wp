/*
Ensure you have any dependencies for this file installed via package.json.
Update webpack.config.js and package.json build/watch scripts if you change the example folder/file structure.
*/

//import example from 'example'; // Import from a package.
//import 'example/dist/css/example.css'; // Import CSS from a package.
import './example-bundle-css.css'; // Import CSS from a non-package CSS file.
import './example-bundle-scss.scss'; // Import SCSS from a non-package SCSS file.
console.log('Example string (example-bundle).');
console.log(
	wp.i18n.__('Example translated string (example-bundle).', 'plugin-name')
); // To use a translated string, ensure wp_enqueue_script is called with wp-i18n as a dependency.
