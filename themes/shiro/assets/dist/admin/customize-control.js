!function(t){wp.customizerCtrlEditor={init:function(){t(window).load((function(){t("textarea.wp-editor-area").each((function(){var i,e,n=t(this),o=n.attr("id"),r=tinyMCE.get(o);r&&r.onChange.add((function(t){t.save(),e=r.getContent(),clearTimeout(i),i=setTimeout((function(){n.val(e).trigger("change")}),500)})),n.css({visibility:"visible"}).on("keyup",(function(){e=n.val(),clearTimeout(i),i=setTimeout((function(){e.trigger("change")}),500)}))}))}))}},wp.customizerCtrlEditor.init()}(jQuery);