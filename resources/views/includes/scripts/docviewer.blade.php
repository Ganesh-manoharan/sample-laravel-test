<div class="viewer-wrapper">
    <div id='viewer'> </div>
</div>
<script src="{{env('DOMAIN_URL').'/dist/lib/webviewer.min.js'}}"> </script>
<script>
    var viewerElement = document.getElementById('viewer');
    WebViewer({
        path: "{{env('DOMAIN_URL').'/dist/lib'}}",
        initialDoc: "{{env('AWS_URL').'/'.$doc_path}}", // replace with your own PDF file
        css: "{{env('DOMAIN_URL').'/css/doc.css'}}",
        //config: "http://localhost:8000/js/iframe_function.js" // relative to your HTML file
        config: "https://code.jquery.com/jquery-3.5.1.min.js"
    }, viewerElement).then((instance) => {
        var Feature = instance.Feature;
        const iframeDoc = instance.iframeWindow.document;
        var {
            Annotations,
            annotManager,
            docViewer
        } = instance;

        instance.setTheme('dark')
        instance.disableElements(['highlightToolGroupButton']);
        instance.disableElements(['underlineToolGroupButton']);
        instance.disableElements(['strikeoutToolGroupButton']);
        instance.disableElements(['squigglyToolGroupButton']);
        instance.disableElements(['stickyToolGroupButton']);
        instance.disableElements(['freeTextToolGroupButton']);
        instance.disableElements(['shapeToolGroupButton']);
        instance.disableElements(['freeHandToolGroupButton']);
        instance.disableElements(['eraserToolButton']);
        instance.disableElements(['panToolButton']);
        instance.disableElements(['ribbons']);
        instance.disableElements(['viewControlsButton']);
        instance.disableElements(['leftPanelButton']);
        instance.disableElements(['menuButton']);
        instance.disableElements(['toggleNotesButton']);
        instance.disableElements(['ribbonsDropdown']);
        instance.disableElements(['undoButton']);
        instance.disableElements(['redoButton']);
        instance.disableElements(['textPopup']);
        instance.disableElements(['contextMenuPopup']);
        instance.disableElements(['annotationPopup']);
        instance.disableFeatures([Feature.LocalStorage]);

    });
</script>