$(document).ready( function () {
    // $('#table_id').DataTable();
    // feather.replace();

    $('#table_id').dataTable( {
        "drawCallback": function( settings ) {
            feather.replace();
        }
    } );
} );


CKEDITOR.replace( 'ckeditor', {
    customConfig: '/ckeditor_settings/config.js'
} );

// ClassicEditor
// .create( document.querySelector( '#editor' ) )
// .then( editor => {
//         console.log( editor );
// } )
// .catch( error => {
//         console.error( error );
// } );