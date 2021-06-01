CKEDITOR.plugins.add( 'ulmenu_one', {
    icons: 'ulmenu1',
    init: function( editor ) {
        editor.addCommand( 'ulmenu_one', {
            
                exec: function( editor ) {
                editor.insertHtml( '<div class="review_line"></div>' );
            }
        });
        editor.ui.addButton( 'ulmenu_one', {
            label: 'Добавить разделительную линию',
                        icon : this.path + 'icons/ulmenu1.png',
            command: 'ulmenu_one',
            toolbar: 'insert'
        });
    }
});