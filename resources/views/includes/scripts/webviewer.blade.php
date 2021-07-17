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
    const document_id = window.parent.document.getElementById('document-page-select').getAttribute("data-doc-id")
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
    // Insert Attach Page Button
    if (window.parent.document.querySelectorAll('.doc-search-append').length > 0 ) {
      instance.setHeaderItems((header) => {
        const pageSelectionButton = {
          type: 'actionButton',
          label: 'Attach Page',
          onClick: () => {
            const page = docViewer.getCurrentPage();
            var page_list = window.parent.document.getElementById('selected-page-list');
            if (!page_list.querySelector('#selected-page-' + page)) {
              page_list.innerHTML += '<div class="col-md-2 d-flex selected-document-input" data-selected-type="page"><input class="selected-page-on-popup" id="selected-page-' + page + '" data-doc-id="' + document_id + '" value="' + page + '" readonly><img src="{{env("DOMAIN_URL")}}/img/Close.svg" class=" selected-page-remove-from-modal"></img></div>'
            }
          },
          name: 'pageButton',
          dataElement: 'pageSelectionButton',
        };
        header.push(pageSelectionButton);
      });
      // Insert Attach Text Button
      instance.setHeaderItems((header) => {
        const textSelecitonButton = {
          type: 'actionButton',
          label: 'Attach Text',
          onClick: () => {
            var text = window.parent.document.getElementById('selected-text-content-copying').value
            var quads = window.parent.document.getElementById('selected-text-content-copying').getAttribute('data-quads')
            var page = window.parent.document.getElementById('selected-text-page-copying').value
            if (text.length > 0) {
              var exist = window.parent.document.getElementById('selected-text-list').childElementCount;
              var add_text = exist + 1;
              window.parent.document.getElementById('selected-text-list').innerHTML += '<div class="d-flex selected-document-input" data-selected-type="text"><div class="selected-text-wrapper"><textarea class="selected-text-on-popup" id="selected-textarea-' + add_text + '" data-doc-id="' + document_id + '" data-selected-page=' + page + ' disabled cols="100" data-quads=' + quads + '>' + text + '</textarea></div><img src="{{env("DOMAIN_URL")}}/img/Close.svg" class=" selected-page-remove-from-modal"></img><em class="fa fa-eye selected-text-on-popup" data-doc-id="' + document_id + '" data-selected-page=' + page + ' data-quads=' + quads + '></em></div>'
              var textbox = window.parent.document.getElementById('selected-textarea-' + add_text)
              var txt = textbox.value;
              var cols = textbox.cols;
              var arraytxt = txt.split('\n');
              var rows = arraytxt.length;
              for (i = 0; i < arraytxt.length; i++)
                rows += parseInt(arraytxt[i].length / cols);
              textbox.rows = rows;
            }
            window.parent.document.getElementById('selected-text-content-copying').value = ''
            window.parent.document.getElementById('selected-text-page-copying').value = ''
            iframeDoc.querySelector('[data-element="textSelectionButton"]').style.boxShadow = "0px 0px 0px #fff"
            iframeDoc.querySelector('[data-element="textSelectionButton"]').style.fontSize = "12px";
          },
          name: 'textButton',
          dataElement: 'textSelectionButton',
        };
        header.push(textSelecitonButton);
      });
    }

    // Get selected text
    docViewer.getTool('TextSelect').on('selectionComplete', (startQuad, allQuads) => {
      var selectedText = docViewer.getSelectedText()
      var pageNumber = docViewer.getCurrentPage()
      if (selectedText.length > 0) {
        window.parent.document.getElementById('selected-text-content-copying').value = selectedText
        window.parent.document.getElementById('selected-text-content-copying').setAttribute('data-quads', JSON.stringify(allQuads))
        window.parent.document.getElementById('selected-text-page-copying').value = pageNumber
        iframeDoc.querySelector('[data-element="textSelectionButton"]').style.boxShadow = "0px 0px 30px #fff";
        iframeDoc.querySelector('[data-element="textSelectionButton"]').style.fontSize = "14px";
        iframeDoc.querySelector('[data-element="textSelectionButton"]').disabled = false;
      }
    });
    // Create Document Thumbnail on Complete the selection process
    window.parent.document.getElementById('document-confirm').onclick = function(e) {
      // var file = e.getAttribute('data-doc-name');
      window.parent.document.getElementById('document-page-select').click()
      var selected_pages = window.parent.document.getElementById('selected-page-list')
      var page = selected_pages.childElementCount;
      var selected_text = window.parent.document.getElementById('selected-text-list')
      var text_count = selected_text.childElementCount
      const document = docViewer.getDocument();
      if (page > 0) {
        var page_number = selected_pages.firstElementChild.querySelector('input').value
        document.loadThumbnailAsync(page_number, (thumbnail) => {
          // thumbnail is a HTMLCanvasElement or HTMLImageElement
          window.parent.document.getElementById('document-thumbnail').appendChild(thumbnail)
          window.parent.document.getElementById('document-thumbnail').setAttribute('data-selection-type', 'Selection')
        });
      } else if (text_count > 0) {
        var text = selected_text.firstElementChild.querySelector('textarea').value
        var thumbnail = window.parent.document.createElement('canvas')
        thumbnail.style.cssText = 'width:66px;height:80px;backgound-color:#fff;color:black;border:1px solid #ccc;'
        var pad_top = 15
        var pad_left = 15
        var line_height = 15
        var ctx = thumbnail.getContext("2d")
        ctx.font = '8px Arial';
        var fitWidth = 200
        var words = text.split(' ');
        var currentLine = 0;
        var idx = 1;
        while (words.length > 0 && idx <= words.length) {
          var str = words.slice(0, idx).join(' ');
          str = str.split("").join(String.fromCharCode(8202))
          var w = ctx.measureText(str).width;
          if (w > fitWidth) {
            if (idx == 1) {
              idx = 2;
            }
            ctx.fillText(words.slice(0, idx - 1).join(' '), pad_left, pad_top + (line_height* currentLine));
            currentLine++;
            words = words.splice(idx - 1);
            idx = 1;
          } else {
            idx++;
          }
        }
        if (idx > 0) {
          ctx.fillText(words.join(' '), pad_left, pad_top + (line_height* currentLine));
        }
        window.parent.document.getElementById('document-thumbnail').appendChild(thumbnail)
        window.parent.document.getElementById('document-thumbnail').setAttribute('data-selection-type', 'Selection')
      } else {
        document.loadThumbnailAsync(1, (thumbnail) => {
          // thumbnail is a HTMLCanvasElement or HTMLImageElement
          window.parent.document.getElementById('document-thumbnail').appendChild(thumbnail)
          window.parent.document.getElementById('document-thumbnail').setAttribute('data-selection-type', 'All')
        });
      }
    };
    // Remove the Attach Button shadow
    iframeDoc.onclick = function() {
      if (docViewer.getSelectedText().length == 0) {
        iframeDoc.querySelector('[data-element="textSelectionButton"]').style.boxShadow = "0px 0px 0px #fff"
        iframeDoc.querySelector('[data-element="textSelectionButton"]').style.fontSize = "12px";
        iframeDoc.querySelector('[data-element="textSelectionButton"]').disabled = true;
      }
    };

    $(window.parent.document).ready(function() {
      $(window.parent.document).on('click', '.selected-page-on-popup', function() {
        $('.selected-page-on-popup').removeClass('show-selected-input')
        $(this).addClass('show-selected-input');
        docViewer.setCurrentPage($(this).val())
      });
    });

    $(window.parent.document).ready(function() {
      $(window.parent.document).on('click', '.selected-text-on-popup', function() {
        var page = $(this).attr('data-selected-page')
        var quads = JSON.parse($(this).attr('data-quads'))
        docViewer.setCurrentPage(page)
      });
    });

    docViewer.on('annotationsLoaded', () => {
      const annots = annotManager.getAnnotationsList();
      // remove annotations
      annotManager.deleteAnnotations(annots);
    });

    docViewer.on('documentLoaded', () => {
      $('.document-confirm').attr('disabled',false) 
    });

  }); 
</script>