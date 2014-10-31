CKEDITOR.plugins.add( 'fileUpload', {
    icons: 'fileUpload',
    init: function( editor ) {


        editor.addCommand( 'fileUpload', new CKEDITOR.dialogCommand( 'fileUploadDialog' ) );

        editor.ui.addButton( 'FileUpload', {
            label: 'Upload a File',
            command: 'fileUpload',
            toolbar: 'insert'
        });

        CKEDITOR.dialog.add( 'fileUploadDialog', this.path + 'dialogs/fileUpload.js' );

    }
});