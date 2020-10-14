/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
   config.filebrowserBrowseUrl = '/laravel/public/js/admin/kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = '/laravel/public/js/admin/kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = '/laravel/public/js/admin/kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = '/laravel/public/js/admin/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = '/laravel/public/js/admin/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = '/laravel/public/js/admin/kcfinder/upload.php?type=flash';
};
