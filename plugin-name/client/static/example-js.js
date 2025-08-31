console.log('Example string (example-js).');
console.log(
	wp.i18n.__('Example translated string (example-js).', 'plugin-name')
); // To use a translated string, ensure wp_enqueue_script is called with wp-i18n as a dependency.
