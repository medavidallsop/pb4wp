<?php

$readme_file = 'readme.txt';
$plugin_file = 'plugin-name.php';

// Read file contents.
$plugin_content = file_get_contents( $plugin_file );
$readme_content = file_get_contents( $readme_file );

// ============================================================================
// EXTRACTION
// ============================================================================

// Extract version property from plugin file.
$base_version = null;
$lines        = explode( "\n", $plugin_content );
foreach ( $lines as $line ) {
	if ( strpos( $line, 'public' ) !== false && strpos( $line, '$version' ) !== false && strpos( $line, '=' ) !== false ) {
		// Extract version from line like "public $version = '1.0.0';".
		if ( preg_match( "/['\"]([^'\"]+)['\"]/", $line, $matches ) ) {
			$base_version = $matches[1];
			break;
		}
	}
}
if ( ! $base_version ) {
	fwrite( STDERR, "❌ Could not find version property in $plugin_file\n" );
	exit( 1 );
}

// Extract version from main plugin header.
if ( ! preg_match( '/^\s*\*\s*Version:\s*([0-9.]+)/mi', $plugin_content, $matches ) ) {
	fwrite( STDERR, "❌ Could not find version header in $plugin_file\n" );
	exit( 1 );
}
$plugin_version = $matches[1];

// Extract stable tag from readme.txt.
if ( ! preg_match( '/Stable tag:\s*([0-9.]+)/i', $readme_content, $matches ) ) {
	fwrite( STDERR, "❌ Could not find stable tag in $readme_file\n" );
	exit( 1 );
}
$readme_version = $matches[1];

// Extract "Requires PHP:" from plugin header.
if ( ! preg_match( '/^\s*\*\s*Requires PHP:\s*([0-9.]+)/mi', $plugin_content, $matches ) ) {
	fwrite( STDERR, "❌ Could not find 'Requires PHP:' header in $plugin_file\n" );
	exit( 1 );
}
$plugin_requires_php = $matches[1];

// Extract "Requires PHP:" from readme.txt.
if ( ! preg_match( '/Requires PHP:\s*([0-9.]+)/i', $readme_content, $matches ) ) {
	fwrite( STDERR, "❌ Could not find 'Requires PHP:' in $readme_file\n" );
	exit( 1 );
}
$readme_requires_php = $matches[1];

// Extract "Requires at least:" from plugin header.
if ( ! preg_match( '/^\s*\*\s*Requires at least:\s*([0-9.]+)/mi', $plugin_content, $matches ) ) {
	fwrite( STDERR, "❌ Could not find 'Requires at least:' header in $plugin_file\n" );
	exit( 1 );
}
$plugin_requires_wp = $matches[1];

// Extract "Requires at least:" from readme.txt.
if ( ! preg_match( '/Requires at least:\s*([0-9.]+)/i', $readme_content, $matches ) ) {
	fwrite( STDERR, "❌ Could not find 'Requires at least:' in $readme_file\n" );
	exit( 1 );
}
$readme_requires_wp = $matches[1];

// Extract "Tested up to:" from plugin header (optional).
$plugin_tested_up_to = null;
if ( preg_match( '/^\s*\*\s*Tested up to:\s*([0-9.]+)/mi', $plugin_content, $matches ) ) {
	$plugin_tested_up_to = $matches[1];
}

// Extract "Tested up to:" from readme.txt (optional).
$readme_tested_up_to = null;
if ( preg_match( '/Tested up to:\s*([0-9.]+)/i', $readme_content, $matches ) ) {
	$readme_tested_up_to = $matches[1];
}

// Extract changelog entries (= x.y.z - YYYY-MM-DD =).
preg_match_all(
	'/=\s*([0-9.]+)\s*[-–]\s*[0-9]{4}-[0-9]{2}-[0-9]{2}\s*=/i',
	$readme_content,
	$matches
);
$changelog_versions = $matches[1] ?? array();

// Extract version from composer.json.
$composer_file    = 'composer.json';
$composer_content = file_get_contents( $composer_file );
$composer_data    = json_decode( $composer_content, true );
if ( ! $composer_data || ! isset( $composer_data['version'] ) ) {
	fwrite( STDERR, "❌ Could not find version in $composer_file\n" );
	exit( 1 );
}
$composer_version = $composer_data['version'];

// Extract version from package.json.
$package_file    = 'package.json';
$package_content = file_get_contents( $package_file );
$package_data    = json_decode( $package_content, true );
if ( ! $package_data || ! isset( $package_data['version'] ) ) {
	fwrite( STDERR, "❌ Could not find version in $package_file\n" );
	exit( 1 );
}
$package_version = $package_data['version'];

// ============================================================================
// COMPARISONS
// ============================================================================

$ok              = true;
$mismatch_prefix = "❌ Version mismatch: version property ($base_version)";

// Version mismatches.
if ( $base_version !== $plugin_version ) {
	fwrite( STDERR, "$mismatch_prefix != plugin header ($plugin_version)\n" );
	$ok = false;
}
if ( $base_version !== $readme_version ) {
	fwrite( STDERR, "$mismatch_prefix != readme.txt stable tag ($readme_version)\n" );
	$ok = false;
}

// Requires PHP mismatch.
if ( $plugin_requires_php !== $readme_requires_php ) {
	fwrite( STDERR, "❌ Requires PHP mismatch: plugin header ($plugin_requires_php) != readme.txt ($readme_requires_php)\n" );
	$ok = false;
}

// Requires at least mismatch.
if ( $plugin_requires_wp !== $readme_requires_wp ) {
	fwrite( STDERR, "❌ Requires at least mismatch: plugin header ($plugin_requires_wp) != readme.txt ($readme_requires_wp)\n" );
	$ok = false;
}

// Tested up to mismatch (if both exist).
if ( null !== $plugin_tested_up_to && null !== $readme_tested_up_to ) {
	if ( $plugin_tested_up_to !== $readme_tested_up_to ) {
		fwrite( STDERR, "❌ Tested up to mismatch: plugin header ($plugin_tested_up_to) != readme.txt ($readme_tested_up_to)\n" );
		$ok = false;
	}
}

// Changelog checks.
if ( empty( $changelog_versions ) ) {
	fwrite( STDERR, "❌ Could not detect any changelog entries in $readme_file\n" );
	$ok = false;
} else {
	$latest_changelog = $changelog_versions[0];
	if ( $base_version !== $latest_changelog ) {
		fwrite( STDERR, "$mismatch_prefix != latest changelog entry ($latest_changelog)\n" );
		$ok = false;
	}
	if ( isset( $changelog_versions[1] ) && $latest_changelog === $changelog_versions[1] ) {
		fwrite( STDERR, "❌ Changelog problem: latest entry ($latest_changelog) is the same as the previous one.\n" );
		$ok = false;
	}
}

// Composer/package.json version mismatches.
if ( $base_version !== $composer_version ) {
	fwrite( STDERR, "$mismatch_prefix != composer.json version ($composer_version)\n" );
	$ok = false;
}
if ( $base_version !== $package_version ) {
	fwrite( STDERR, "$mismatch_prefix != package.json version ($package_version)\n" );
	$ok = false;
}

// ============================================================================
// OUTPUT
// ============================================================================

if ( $ok ) {
	echo "✅ All versions match: $base_version\n";
	echo "✅ Requires PHP matches: $plugin_requires_php\n";
	echo "✅ Requires at least matches: $plugin_requires_wp\n";
	if ( null !== $plugin_tested_up_to && null !== $readme_tested_up_to ) {
		echo "✅ Tested up to matches: $plugin_tested_up_to\n";
	}
	exit( 0 );
} else {
	exit( 1 );
}
