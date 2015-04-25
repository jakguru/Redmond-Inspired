/**
 * JS Scripts for creation of dialogs ( floating windows )
 */
var processes = {};

function redmond_window( objid , title , content , filecommands , canResize , draggable , icon ) {
	if( typeof( filecommands ) !== 'object' ) {
		filecommands = {
			'close': {
				title: redmond_terms.close,
				onclick: 'redmond_close_this(this)',
			}
		};
	}
	if( typeof( draggable ) == 'undefined' ) {
		draggable = true;
	}
	if( typeof( canResize ) == 'undefined' ) {
		canResize = true;
	}
	if( typeof( content ) == 'undefined' ) {
		content = '';
	}
	if( typeof( icon ) == 'undefined' ) {
		icon = redmond_terms.windowIcon;
	}
	if( typeof( processes[objid] ) == 'undefined' ) {
		jQuery('#modal-holder').append('<div id="' + objid + '"><div class="file-bar"><ul></ul></div>' + content + '</div>');
		processes[objid] = jQuery("#" + objid);
		processes[objid].dialog({
			autoOpen: true,
			closeOnEscape: false,
			dialogClass: "redmond-dialog-window",
			draggable: draggable,
			resizable: canResize,
			close: function( event, ui ) {
				processes[objid].remove();
				delete processes[objid];
				jQuery(window).trigger('checkOpenWindows');
			},
			open: function( event, ui ) {
				processes[objid].find('div.file-bar>ul').append(redmond_filecommands_to_html(filecommands));
				processes[objid].parent().find('.ui-dialog-titlebar>span').css({
					'background-image': 'url(' + icon + ')',
					'background-repeat': 'no-repeat',
					'background-size': 'contain',
				});
				processes[objid].find('button.ui-dialog-titlebar-close').on('click',function(){
					processes[objid].dialog('destroy');
				});
				processes[objid].find('div.file-bar').zIndex(processes[objid].zIndex());
				jQuery(window).trigger('checkOpenWindows');
				processes[objid].parent().on('click',function() {
					find_window_on_top();
				});
				processes[objid].find('iframe').on('click',function() {
					processes[objid].dialog('moveToTop');
					find_window_on_top();
				});
				processes[objid].find('span.dialog-close-button').css({
					left: function() {
						var fullwidth = parseInt( processes[objid].find('span.dialog-close-button').parent().css('width') , 10 );
						return ( fullwidth / 2 ) - ( parseInt( processes[objid].find('span.dialog-close-button').css('width') , 10 ) / 2 ) - 10;
					}
				});
			},
			focus: function( event, ui ) {
				processes[objid].find('div.file-bar').zIndex(processes[objid].zIndex());
				find_window_on_top();
			},
			title: title,
			closeText: "&times;",
			width: 'auto',
			height: 'auto',
		});
	}
	else {
		processes[objid].html('<div class="file-bar"><ul></ul></div>' + content + '</div>');
		processes[objid].find('div.file-bar>ul').append(redmond_filecommands_to_html(filecommands));
		processes[objid].parent().find('.ui-dialog-titlebar>span').css({
			'background-image': 'url(' + icon + ')',
			'background-repeat': 'no-repeat',
			'background-size': 'contain',
		});
		processes[objid].find('div.file-bar').zIndex(processes[objid].zIndex());
		jQuery(window).trigger('checkOpenWindows');
		processes[objid].parent().on('click',function() {
			find_window_on_top();
		});
		processes[objid].find('span.dialog-close-button').css({
			left: function() {
				var fullwidth = parseInt( processes[objid].find('span.dialog-close-button').parent().css('width') , 10 );
				return ( fullwidth / 2 ) - ( parseInt( processes[objid].find('span.dialog-close-button').css('width') , 10 ) / 2 ) - 10;
			}
		});
		processes[objid].dialog('moveToTop');
		find_window_on_top();
	}
	jQuery("div.redmond-dialog-window").each(function() {
		jQuery(this).css({
			'height': ( jQuery(window).height() * 0.9 ),
			'overflow': 'hidden',
		});
	});
}

function redmond_filecommands_to_html( filecommands ) {
	html = '';
	html += '<li>' + "\r\n";
	html += '	' + redmond_terms.file;
	html += '	<ul class="file-sub-menu">' + "\r\n";
	for( var cmd in filecommands ) {
	html += '		<li data-file-command="' + cmd + '" onclick="' + filecommands[cmd].onclick + '">' + "\r\n";
	html += '			' + filecommands[cmd].title + "\r\n";
	html += '		</li>' + "\r\n";
	}
	html += '	</ul>' + "\r\n";
	html += '</li>' + "\r\n";
	return html;
}

function redmond_close_this( obj ) {
	jQuery(obj).parent().parent().parent().parent().parent().dialog('close');
}