import Litepicker from 'litepicker'; // This will get bundled into a dist .js file as per webpack.config.js - put this stuff id readme.md
import 'litepicker/dist/css/litepicker.css'; // If using CSS from a package, import it here, it will result in a css file in dist you can enqueue- put this stuff id readme.md
//import * as css from 'example-bundle-css.css';
import './example-bundle-css.css'; // example custom css not loaded from package

// Remember to update webpack.config.js with the correct paths and filenames for your file
// Remember to amend package.json scripts, e.g. amend build:assets:bundle and watch:client:bundle

const picker = new Litepicker({
	element: document.getElementById('litepicker'),
});

console.log(picker);
