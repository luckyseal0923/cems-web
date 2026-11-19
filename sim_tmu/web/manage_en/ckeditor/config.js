/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document' ] },
		{ name: 'clipboard',   groups: [ 'clipboard' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		'/',
		{ name: 'styles' },//樣式
		{ name: 'colors' },
		{ name: 'basicstyles', groups: [ 'basicstyles' ] },//粗體、斜體...
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'align', 'bidi' ] },
		{ name: 'table' }
	];

	config.pasteFromWordRemoveFontStyles = false; 
    config.pasteFromWordRemoveStyles = false;

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.allowedContent = true;
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.font_names = "新細明體;標楷體;微軟正黑體;Arial;Courier New;Georgia;Verdana;Tahoma;Times New Roman;" ;								
	config.removeDialogTabs = 'image:advanced;link:advanced';
	
	config.width='auto';
	config.height='200px';
};
