CKEDITOR.plugins.add( 'youtube', {
    icons: 'youtube',
    init: function( editor ) {
        editor.addCommand( 'youtube', new CKEDITOR.dialogCommand( 'youtubeDialog' ) );
        editor.ui.addButton( 'Youtube', {
            label: 'Insert Youtube Video',
            command: 'youtube',
            toolbar: 'insert'
        });

        CKEDITOR.dialog.add( 'youtubeDialog', this.path + 'dialogs/youtube.js' );
    }
});