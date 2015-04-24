var sounds = {
	error: new Audio( redmond_terms.errorSound ),
	open: new Audio( redmond_terms.openSound ),
	login: new Audio( redmond_terms.loginSound ),
};

jQuery(function() {
	startSystemClock();
	handle_start_menu();
	jQuery('a').on('click',function(e){
		if( typeof( jQuery(this).attr('id') ) === 'undefined' || 
			( jQuery(this).attr('id') !== 'home-start-menu-link' 
				&& jQuery(this).attr('id') !== 'new-post-start-menu-link' 
				&& jQuery(this).attr('id') !== 'control-panel-start-menu-link'
				&& jQuery(this).attr('id') !== 'start-menu-bottom-bar-logout'
				&& jQuery(this).attr('id') !== 'start-menu-bottom-bar-register'
				&& jQuery(this).attr('id') !== 'start-menu-bottom-bar-login'
				&& jQuery(this).attr('id') !== 'system-info-start-menu-link' 
				&& jQuery(this).attr('id') !== 'my-documents-start-menu-link'
				&& jQuery(this).attr('id') !== 'my-tags-start-menu-link'
				&& jQuery(this).attr('id') !== 'system-search-start-menu-link' )
		) {
			e.preventDefault();
			open_this_as_redmond_dialog(this);
		}
	});
	jQuery(window).on('checkOpenWindows',function() {
		checkOpenWindows();
	});
	jQuery('body').on('onContextMenu',function(e){
		e.preventDefault();
		return false;
	});
	if( redmond_terms.playLoginSounds ) {
		sounds.login.play();
	}
	for( var process in processes ) {
		processes[process].dialog('moveToTop');
		find_window_on_top();
		break;
	}
});

function checkOpenWindows() {
	processList = '';
	for( var process in processes ) {
		if( parseInt(processes[process].parent().css('top'),10) >= 0 ) {
			processes[process].currentTop = parseInt(processes[process].parent().css('top'),10);
		}
		else {
			processes[process].parent().css('top',processes[process].currentTop);
		}
		processList += '<li onclick="processes[\'' +process+ '\'].dialog(\'moveToTop\')" id="' +process+ '_taskbar">';
		processList += '<span class="task-icon"';
		processList += ' style="' + processes[process].parent().find('.ui-dialog-title').attr('style') + '"';
		processList += '></span>';
		processList += processes[process].parent().find('.ui-dialog-title').html().substring(0,20) + '</li>' + "\r\n";
	}
	jQuery("#open-processes").html( processList );
	jQuery("#open-processes>li").on('click',function() {
		find_window_on_top();
	});
	find_window_on_top();
}

function find_window_on_top() {
	var top;
	var hightestZ = 0;
	for( var process in processes ) {
		if( processes[process].zIndex() > hightestZ ) {
			top = process;
			hightestZ = processes[process].zIndex();
		}
		var currTop = processes[process].parent().offset().top;
		if( currTop < 0 ) {
			processes[process].parent().offset({top: 100, left: processes[process].parent().offset().left});
		}
	}
	var taskbar = jQuery("#" + top + '_taskbar');
	jQuery("#open-processes>li").removeClass('active');
	taskbar.addClass('active');
}

function startSystemClock() {
	jQuery("#taskbar-clock").html( currentTime() );
	setInterval( function() {
		jQuery("#taskbar-clock").html( currentTime() );
	},1000);
}

function currentTime() {
	var d = new Date();
	return d.toLocaleTimeString();
}

function handle_start_menu() {
	jQuery("#start-button").on('click',function() {
		toggle_activated(jQuery(this).parent());
		jQuery('#start-menu-wrapper').toggle();
	});
	jQuery("#start-menu-wrapper a").on('click',function() {
		if( jQuery(this).is(':visible') ) {
			jQuery('#start-menu-wrapper').toggle();
			toggle_activated( jQuery("#start-button").parent() );
		}
	});
	jQuery("#start-menu-archives-link").on('mouseover',function() {
		jQuery("#start-menu-archives-link>div.archives-outer-wrapper").show();
		jQuery("#start-menu-archives-link>div.archives-outer-wrapper").css({
			bottom: 0,
		});
	});
	jQuery("#start-menu-archives-link").on('mouseout',function() {
		jQuery("#start-menu-archives-link>div.archives-outer-wrapper").hide();
	});
	jQuery("ul.archives-inner-wrapper>li").on('mouseover',function() {
		jQuery(this).find('div.archives-outer-wrapper').show();
		var newtop = jQuery(this).offset().top + jQuery(this).outerHeight(true);
		jQuery(this).find('div.archives-outer-wrapper').css({
			bottom: 0,
			height: function() {
				return parseInt( 22 * jQuery(this).find('li').length ,10);
			},
		});
		jQuery(this).find('div.archives-outer-wrapper').offset({top: newtop});
	});
	jQuery("ul.archives-inner-wrapper>li").on('mouseout',function() {
		jQuery(this).find('div.archives-outer-wrapper').hide();
	});
	jQuery("#my-documents-start-menu-link").on('click',function(e){
		e.preventDefault();
		open_archive_as_dialog();
	});
	jQuery("#my-tags-start-menu-link").on('click',function(e){
		e.preventDefault();
		open_archive_as_dialog('all','tags');
	});
	jQuery("#system-search-start-menu-link").on('click',function(e){
		e.preventDefault();
		open_redmond_search_window();
	});
}

function toggle_activated( obj ) {
	if( jQuery(obj).hasClass('activated') ) {
		jQuery(obj).removeClass('activated');
	}
	else {
		jQuery(obj).addClass('activated');
	}
}

function open_this_as_redmond_dialog( obj ) {
	var type = ( typeof( jQuery(obj).attr('data-post-id') ) !== 'undefined' ) ? 'inline' : 'iframe';
	if( type == 'inline' ) {
		open_post_as_dialog( parseInt( jQuery(obj).attr('data-post-id') , 10 ) );
	}
	else {
		var html = '<iframe src="' + jQuery(obj).attr('href') + '"></iframe>';
		var process = new Date().getTime();
		redmond_window( process , jQuery(obj).attr('title') , html , false , true , true , redmond_terms.externalPageIcon );
		processes[process].css({'overflow-y':'hidden'});
	}
}

function open_category_as_redmond_dialog( obj ) {
	var o = jQuery(obj);
	open_archive_as_dialog( o.attr('data-category-id') , o.attr('data-type') );
}

function open_post_as_dialog( postId ) {
	jQuery.ajax({
		url: redmond_terms.ajaxurl,
		data: {
			action: 'getpost',
			post: postId
		},
		async: true,
		beforeSend: function() {},
		cache: false,
		crossDomain: false,
		error: function() {
			do_redmond_error_window( redmond_terms.ajaxerror );
			console.log('AJAX Error');
		},
		method: 'POST',
		success: function( returned ) {
			var res = wpAjax.parseAjaxResponse( returned );
			switch(true) {
				case ( res === false ):
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('No such AJAX Action');
					break;

				case ( typeof( res.responses ) == 'undefined' ):
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('No Parsable Response');
					break;

				case ( res.responses.length > 0 ):
					var data = jQuery.parseJSON( res.responses[0].data );
					redmond_window( data.task_name , data.post_title , data.post_content , data.fileMenu , true, true , data.post_icon );
					processes[data.task_name].find('article').css({
						padding: 10,
					});
					sounds.open.play();
					break;

				default:
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('Unknown Error');
					break;
			}
		}
	});
}

function open_archive_as_dialog( archive , taxonomy , targetId ) {
	if( typeof( taxonomy ) == 'undefined' ) {
		taxonomy = 'category';
	}
	if( typeof( archive ) == 'undefined' ) {
		archive = 'all';
	}
	jQuery.ajax({
		url: redmond_terms.ajaxurl,
		data: {
			action: 'getarchive',
			taxonomy: taxonomy,
			archive: archive,
		},
		async: true,
		beforeSend: function() {},
		cache: false,
		crossDomain: false,
		error: function() {
			do_redmond_error_window( redmond_terms.ajaxerror );
			console.log('AJAX Error');
		},
		method: 'POST',
		success: function( returned ) {
			var res = wpAjax.parseAjaxResponse( returned );
			switch(true) {
				case ( res === false ):
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('No such AJAX Action');
					break;

				case ( typeof( res.responses ) == 'undefined' ):
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('No Parsable Response');
					break;

				case ( res.responses.length > 0 ):
					var data = jQuery.parseJSON( res.responses[0].data );
					if( typeof( targetId ) !== 'undefined' && jQuery("#" + targetId ).length > 0 ) {
						jQuery("#"+targetId).dialog('close');
					}
					redmond_window( data.taskname , data.title , data.html , data.menu , true, true , data.icon );
					jQuery("#" + data.taskname).find('a').on('click',function(e) {
						if( typeof( jQuery(this).attr('id') ) === 'undefined' && typeof( jQuery(this).attr('data-type') ) !== 'undefined' ) {
							e.preventDefault();
							switch( jQuery(this).attr('data-type') ) {
								case 'regular':
									open_this_as_redmond_dialog(this);
									break;

								default:
									open_category_as_redmond_dialog(this);
									break;
							}
						}
					});
					sounds.open.play();
					break;

				default:
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('Unknown Error');
					break;
			}
		}
	});
}

function open_redmond_search_window( search ) {
	if( typeof(search) == 'undefined' || search.length == 0 ) {
		var windowTitle = redmond_terms.search;
	}
	else {
		var windowTitle = redmond_terms.search_for + search;
	}
	jQuery.ajax({
		url: redmond_terms.ajaxurl,
		data: {
			action: 'getsearch',
			search:search,
		},
		async: true,
		beforeSend: function() {},
		cache: false,
		crossDomain: false,
		error: function() {
			do_redmond_error_window( redmond_terms.ajaxerror );
			console.log('AJAX Error');
		},
		method: 'POST',
		success: function( returned ) {
			var res = wpAjax.parseAjaxResponse( returned );
			switch(true) {
				case ( res === false ):
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('No such AJAX Action');
					break;

				case ( typeof( res.responses ) == 'undefined' ):
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('No Parsable Response');
					break;

				case ( res.responses.length > 0 ):
					var data = jQuery.parseJSON( res.responses[0].data );
					redmond_window( 'searchwindow' , windowTitle , data.html , redmond_terms.default_file_menu , false , true , redmond_terms.searchIcon );
					jQuery("#searchwindow").find('button').on('click',function(e) {
						e.preventDefault();
						open_redmond_search_window( jQuery('#searchwindow').find('input').val() );
					});
					jQuery("#searchwindow").find('input').on('keyup',function(e){
						if( e.keyCode == 13 ) {
							open_redmond_search_window( jQuery('#searchwindow').find('input').val() );	
						}
					});
					jQuery("#searchwindow").find('a').on('click',function(e) {
						if( typeof( jQuery(this).attr('id') ) === 'undefined' && typeof( jQuery(this).attr('data-type') ) !== 'undefined' ) {
							e.preventDefault();
							switch( jQuery(this).attr('data-type') ) {
								case 'regular':
									open_this_as_redmond_dialog(this);
									break;

								default:
									open_category_as_redmond_dialog(this);
									break;
							}
						}
					});
					sounds.open.play();
					break;

				default:
					do_redmond_error_window( redmond_terms.ajaxerror );
					console.log('Unknown Error');
					break;
			}
		}
	});
}

function do_redmond_error_window( message ) {
	var contents = '';
	contents += '<p>' + message +'</p>' + "\r\n";
	contents += '<span class="button-outer dialog-close-button"><button class="system-button" onclick="jQuery(this).parent().parent().dialog(\'close\')">' + redmond_terms.closetext + '</button></span>' + "\r\n";
	redmond_window('error',redmond_terms.errTitle,contents,null,false,true,redmond_terms.errorIcon);
	processes.error.css({
		'overflow-y': 'hidden',
		background:'#d4d0c8',
		'background-color':'#d4d0c8',
		padding: 10,
		'max-width': 700,
	});
	processes.error.find('div.file-bar').css({
		display:'none',
	});
	sounds.error.play();
}

function redmond_comment_field( postid ) {
	do_redmond_error_window('Sorry, that function is not working yet.');
}

function redmond_share_post( postid ) {
	do_redmond_error_window('Sorry, that function is not working yet.');
}