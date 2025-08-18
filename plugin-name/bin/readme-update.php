<?php

$readme       = 'readme.txt';
$api_url      = 'https://api.wordpress.org/core/stable-check/1.0/';
$error_prefix = 'Readme.txt cannot be updated: ';

// 1. Get latest WP version
$json = file_get_contents( $api_url );
if ( false === $json ) {
	fwrite( STDERR, $error_prefix . "Failed to fetch WordPress version data.\n" );
	exit( 1 );
}

$data = json_decode( $json, true );
if ( ! is_array( $data ) ) {
	fwrite( STDERR, $error_prefix . "Invalid response from WordPress API.\n" );
	exit( 1 );
}

$latest = array_search( 'latest', $data, true );
if ( ! $latest ) {
	fwrite( STDERR, $error_prefix . "Could not determine latest version.\n" );
	exit( 1 );
}

// 2. Read file
$contents = file_get_contents( $readme );
if ( false === $contents ) {
	fwrite( STDERR, $error_prefix . "Failed to read $readme.\n" );
	exit( 1 );
}

// 3. Show summary of changes
$today = date( 'Y-m-d' ); // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date

// Find current "Tested up to" version.
preg_match( '/Tested up to:\s*([\d.]+)/', $contents, $matches );
$current_version = $matches[1] ?? 'unknown';

// Find current changelog date.
preg_match( '/0000-00-00/', $contents, $date_matches );
$has_date_placeholder = ! empty( $date_matches );

echo "Summary of changes to be made:\n";
echo " - Tested up to: $current_version → $latest\n";
if ( $has_date_placeholder ) {
	echo " - Changelog date placeholder: 0000-00-00 → $today\n";
} else {
	echo " - No changelog date placeholder found to update\n";
}
echo "\n";

// Ask for confirmation.
echo 'Do you want to proceed with these changes? (y/N): ';
$handle   = fopen( 'php://stdin', 'r' );
$response = trim( fgets( $handle ) );
fclose( $handle );

if ( strtolower( $response ) !== 'y' && strtolower( $response ) !== 'yes' ) {
	echo "Operation cancelled.\n";
	exit( 0 );
}

// 4. Replace "Tested up to".
$contents = preg_replace(
	'/Tested up to:\s*[\d.]+/',
	"Tested up to: $latest",
	$contents
);

// 5. Replace "0000-00-00" with today's date.
$contents = preg_replace(
	'/0000-00-00/',
	$today,
	$contents
);

// 6. Save file.
// file_put_contents($readme, $contents);


echo "\nUpdated $readme:\n";
echo " - Tested up to now: $latest\n";
if ( $has_date_placeholder ) {
	echo " - Changelog date placeholder now: $today\n";
}
